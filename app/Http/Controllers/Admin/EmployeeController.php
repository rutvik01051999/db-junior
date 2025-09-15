<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmployeeApiService;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    protected $employeeApiService;

    public function __construct(EmployeeApiService $employeeApiService)
    {
        $this->employeeApiService = $employeeApiService;
    }

    /**
     * Display a listing of employees (users with Admin role)
     */
    public function index()
    {
        $employees = User::role('Admin')
            ->where('id', '!=', Auth::id()) // Exclude current logged-in user
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee (as User with Admin role)
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'department' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        try {
            // Create user using DB::table to bypass enum casting issues
            $userId = DB::table('users')->insertGetId([
                'username' => $request->employee_id,
                'email' => $request->email,
                'first_name' => explode(' ', $request->full_name)[0] ?? '',
                'last_name' => implode(' ', array_slice(explode(' ', $request->full_name), 1)) ?? '',
                'full_name' => $request->full_name,
                'department' => $request->department,
                'mobile_number' => $request->phone_number,
                'password' => Hash::make('default_password_' . time()), // Temporary password
                'status' => 'active', // Active status as string (matches DB enum)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Get the user model instance
            $user = User::find($userId);
            
            // Assign Admin role
            $user->assignRole('Admin');
            
            return redirect()->route('admin.employees.index')
                ->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create employee: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create employee. Please try again.');
        }
    }

    /**
     * Fetch employee data from external API
     */
    public function fetchEmployeeData(Request $request)
    {
        $request->validate([
            'alias' => 'required|string|max:255'
        ]);

        $alias = $request->input('alias');
        
        // Fetch data from external API
        $apiResult = $this->employeeApiService->getEmployeeData($alias);
        
        if (!$apiResult['success']) {
            return response()->json([
                'success' => false,
                'message' => $apiResult['message'] ?? 'Failed to fetch employee data'
            ], 400);
        }

        // Parse the API response
        $parsedResult = $this->employeeApiService->parseEmployeeData($apiResult['data']);
        
        if (!$parsedResult['success']) {
            return response()->json([
                'success' => false,
                'message' => $parsedResult['message'] ?? 'Failed to parse employee data'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $parsedResult['data']
        ]);
    }

    /**
     * Display the specified employee (User with Admin role)
     */
    public function show(User $employee)
    {
        // Ensure the user has Admin role
        if (!$employee->hasRole('Admin')) {
            abort(404, 'Employee not found');
        }
        
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Remove the specified employee from storage
     */
    public function destroy(User $employee)
    {
        try {
            // Prevent users from deleting themselves
            if ($employee->id === Auth::id()) {
                return redirect()->route('admin.employees.index')
                    ->with('error', 'You cannot delete your own account.');
            }

            // Ensure the user has Admin role
            if (!$employee->hasRole('Admin')) {
                abort(404, 'Employee not found');
            }

            // Remove the Admin role first
            $employee->removeRole('Admin');
            
            // Delete the user
            $employee->delete();
            
            return redirect()->route('admin.employees.index')
                ->with('success', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete employee: ' . $e->getMessage());
            return redirect()->route('admin.employees.index')
                ->with('error', 'Failed to delete employee. Please try again.');
        }
    }
}
