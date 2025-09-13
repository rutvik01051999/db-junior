<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JuniorEditor;
use App\Models\Participant;
use App\Models\CertiStudent;
use App\Models\Contact;
use App\Models\Employee;
use App\Services\RoleService;
use App\Services\UserService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected RoleService $roleService;
    protected UserService $userService;

    public function __construct(RoleService $roleService, UserService $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleService->all(['users'], ['users']);
        $usersCounts = $this->userService->totalCounts();
        
        // Get registration details
        $registrationDetails = $this->getRegistrationDetails();
        
        return view('admin.dashboard.index', compact('roles', 'usersCounts', 'registrationDetails'));
    }
    
    /**
     * Get registration details for dashboard
     */
    private function getRegistrationDetails()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        return [
            'junior_editors' => [
                'total' => JuniorEditor::count(),
                'today' => JuniorEditor::whereDate('created_at', $today)->count(),
                'this_month' => JuniorEditor::where('created_at', '>=', $thisMonth)->count(),
                'last_month' => JuniorEditor::whereBetween('created_at', [
                    $lastMonth, 
                    $lastMonth->copy()->endOfMonth()
                ])->count(),
                'verified' => JuniorEditor::where('mobile_verified', true)->count(),
                'paid' => JuniorEditor::where('payment_status', 'paid')->count(),
            ],
            'participants' => [
                'total' => Participant::count(),
                'active' => Participant::where('status', true)->count(),
                'inactive' => Participant::where('status', false)->count(),
            ],
            'certificate_students' => [
                'total' => CertiStudent::count(),
                'today' => CertiStudent::whereDate('created_date', $today)->count(),
                'this_month' => CertiStudent::where('created_date', '>=', $thisMonth)->count(),
            ],
            'contact_submissions' => [
                'total' => Contact::count(),
                'today' => Contact::whereDate('created_at', $today)->count(),
                'this_month' => Contact::where('created_at', '>=', $thisMonth)->count(),
                'last_month' => Contact::whereBetween('created_at', [
                    $lastMonth, 
                    $lastMonth->copy()->endOfMonth()
                ])->count(),
            ],
            'employees' => [
                'total' => Employee::count(),
                'today' => Employee::whereDate('created_at', $today)->count(),
                'this_month' => Employee::where('created_at', '>=', $thisMonth)->count(),
                'last_month' => Employee::whereBetween('created_at', [
                    $lastMonth, 
                    $lastMonth->copy()->endOfMonth()
                ])->count(),
            ],
            'recent_registrations' => JuniorEditor::with([])
                ->latest()
                ->limit(10)
                ->get(['id', 'first_name', 'last_name', 'mobile_number', 'email', 'created_at', 'payment_status'])
                ->map(function ($registration) {
                    return [
                        'id' => $registration->id,
                        'name' => $registration->full_name,
                        'mobile' => $registration->mobile_number,
                        'email' => $registration->email,
                        'date' => $registration->created_at->format('d M Y'),
                        'payment_status' => $registration->payment_status,
                    ];
                }),
            'recent_contacts' => Contact::latest()
                ->limit(10)
                ->get(['id', 'name', 'email', 'phone_number', 'message', 'created_at'])
                ->map(function ($contact) {
                    return [
                        'id' => $contact->id,
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'phone' => $contact->phone_number,
                        'message' => strlen($contact->message) > 50 ? substr($contact->message, 0, 50) . '...' : $contact->message,
                        'date' => $contact->created_at->format('d M Y'),
                    ];
                }),
            'recent_employees' => Employee::latest()
                ->limit(10)
                ->get(['id', 'employee_id', 'full_name', 'email', 'department', 'designation', 'created_at'])
                ->map(function ($employee) {
                    return [
                        'id' => $employee->id,
                        'employee_id' => $employee->employee_id,
                        'name' => $employee->full_name,
                        'email' => $employee->email,
                        'department' => $employee->department,
                        'designation' => $employee->designation,
                        'date' => $employee->created_at->format('d M Y'),
                    ];
                }),
        ];
    }

    public function userRegistrations(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
        } else {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate = Carbon::now();
        }

        // Check range from start date to end date means is today, last 7 days or last 30 days
        $filterBy = Helper::labelFromDateRanges($startDate, $endDate);

        $funName = isset($filterBy['label']) && $filterBy['label'] ? 'getRegistrations' . $filterBy['label'] : 'Custom';

        if ($funName != 'Custom' && method_exists($this, $funName)) {
            $data = $this->{$funName}($filterBy['labels'] ?? []);
        } else {
            $data = $this->getRegistrationsCustom($startDate, $endDate);
        }


        return response()->json($data);
    }

    public function getRegistrationsYesterday($labels = [])
    {
        $registrations = User::query()
            ->whereBetween('created_at', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])
            ->selectRaw('TIME_FORMAT(created_at, "%H") as category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->keyBy('category')
            ->toArray();

        foreach ($labels as $key => $label) {
            $hour = Carbon::createFromFormat('H', $key)->format('h');
            $labels[$key]['count'] = $registrations[$hour]['count'] ?? 0;
            $labels[$key]['category'] = Carbon::createFromFormat('H', $key)->format('h');
        }

        return $labels;
    }

    public function getRegistrationsToday($labels = [])
    {
        $registrations = User::query()
            ->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
            ->selectRaw('DATE_FORMAT(created_at, "%H") as category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->keyBy('category')
            ->toArray();

        foreach ($labels as $key => $label) {
            $hour = Carbon::createFromFormat('H', $key)->format('h');
            $labels[$key]['count'] = $registrations[$hour]['count'] ?? 0;
            $labels[$key]['category'] = Carbon::createFromFormat('H', $key)->format('h');
        }

        return $labels;
    }

    public function getRegistrationsLast7Days($labels = [])
    {
        $registrations = User::query()
            ->whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->selectRaw('DATE_FORMAT(created_at, "%d") as category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->keyBy('category')
            ->toArray();

        foreach ($labels as $key => $label) {
            $day = $label['category'];
            $labels[$key]['count'] = $registrations[$day]['count'] ?? 0;
            $labels[$key]['category'] = Carbon::createFromFormat('d', $key)->format('Y-m-d');
        }

        $labels = array_reverse($labels);

        return $labels;
    }

    public function getRegistrationsLast30Days($labels = [])
    {
        $registrations = User::query()
            ->whereBetween('created_at', [Carbon::now()->subDays(30)->startOfDay(), Carbon::now()->endOfDay()])
            ->selectRaw('DATE_FORMAT(created_at, "%d") as category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->keyBy('category')
            ->toArray();

        foreach ($labels as $key => $label) {
            $day = $label['category'];
            $labels[$key]['count'] = $registrations[$day]['count'] ?? 0;
            $labels[$key]['category'] = Carbon::createFromFormat('d', $day)->format('Y-m-d');
        }

        $labels = array_reverse($labels);

        return $labels;
    }

    public function getRegistrationsThisMonth($labels = [])
    {
        $registrations = User::query()
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->selectRaw('DATE_FORMAT(created_at, "%d") as category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->keyBy('category')
            ->toArray();

        foreach ($labels as $key => $label) {
            $day = Carbon::createFromFormat('d', $key)->format('d');
            $labels[$key]['count'] = $registrations[$day]['count'] ?? 0;
            $labels[$key]['category'] = Carbon::createFromFormat('d', $key)->format('Y-m-d');
        }

        $labels = array_values($labels);

        return $labels;
    }

    public function getRegistrationsLastMonth($labels = [])
    {
        $registrations = User::query()
            ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->selectRaw('DATE_FORMAT(created_at, "%d") as category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->keyBy('category')
            ->toArray();

        foreach ($labels as $key => $label) {
            $day = Carbon::createFromFormat('d', $key)->format('d');
            $labels[$key]['count'] = $registrations[$day]['count'] ?? 0;
            $labels[$key]['category'] = Carbon::createFromFormat('d', $key)->format('Y-m-d');
        }

        $labels = array_values($labels);

        return $labels;
    }

    public function getRegistrationsCustom($from, $to)
    {
        $registrations = User::query()
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE_FORMAT(created_at, "%d-%m-%Y") as category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->keyBy('category')
            ->toArray();

        $registrations = array_values($registrations);

        return $registrations;
    }
}
