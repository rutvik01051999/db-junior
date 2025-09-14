<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JuniorEditor;
use App\Models\Participant;
use App\Models\Contact;
use App\Models\Employee;
use Carbon\Carbon;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get module statistics
        $moduleStats = $this->getModuleStatistics();
        
        return view('admin.dashboard.index', compact('moduleStats'));
    }
    
    /**
     * Get module statistics for dashboard
     */
    private function getModuleStatistics()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        return [
            'junior_editors' => [
                'total' => JuniorEditor::count(),
                'today' => JuniorEditor::whereDate('created_at', $today)->count(),
                'this_month' => JuniorEditor::where('created_at', '>=', $thisMonth)->count(),
                'verified' => JuniorEditor::where('mobile_verified', true)->count(),
                'paid' => JuniorEditor::where('payment_status', 'paid')->count(),
            ],
            'winners' => [
                'total' => \App\Models\Winner::count(),
                'today' => \App\Models\Winner::whereDate('created_date', $today)->count(),
                'this_month' => \App\Models\Winner::where('created_date', '>=', $thisMonth)->count(),
                'batches' => \App\Models\Winner::distinct('batch_no')->count('batch_no'),
            ],
            'contacts' => [
                'total' => Contact::count(),
                'today' => Contact::whereDate('created_at', $today)->count(),
                'this_month' => Contact::where('created_at', '>=', $thisMonth)->count(),
            ],
            'employees' => [
                'total' => Employee::count(),
                'today' => Employee::whereDate('created_at', $today)->count(),
                'this_month' => Employee::where('created_at', '>=', $thisMonth)->count(),
            ],
            'participants' => [
                'total' => Participant::count(),
                'active' => Participant::where('status', true)->count(),
                'inactive' => Participant::where('status', false)->count(),
            ],
            'recent_junior_editors' => JuniorEditor::with([])
                ->latest()
                ->limit(5)
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
            'recent_winners' => \App\Models\Winner::latest('created_date')
                ->limit(5)
                ->get(['id', 'name', 'mobile_number', 'email', 'batch_no', 'created_date'])
                ->map(function ($winner) {
                    return [
                        'id' => $winner->id,
                        'name' => $winner->name,
                        'mobile' => $winner->mobile_number,
                        'email' => $winner->email,
                        'batch' => $winner->batch_no,
                        'date' => $winner->created_date ? Carbon::parse($winner->created_date)->format('d M Y') : 'N/A',
                    ];
                }),
            'recent_contacts' => Contact::latest()
                ->limit(5)
                ->get(['id', 'name', 'email', 'phone_number', 'message', 'created_at'])
                ->map(function ($contact) {
                    return [
                        'id' => $contact->id,
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'phone' => $contact->phone_number,
                        'message' => strlen($contact->message) > 30 ? substr($contact->message, 0, 30) . '...' : $contact->message,
                        'date' => $contact->created_at->format('d M Y'),
                    ];
                }),
        ];
    }

}
