<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\HonoAuthService;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';
    protected $honoAuthService;

    public function __construct(HonoAuthService $honoAuthService)
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
        $this->honoAuthService = $honoAuthService;
    }

    /**
     * Handle login request with automatic authentication
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $emailOrUsername = $credentials['email'];
        $password = $credentials['password'];

        // Step 1: Try Super Admin Authentication First (database only)
        $superAdminResult = $this->trySuperAdminAuthentication($request, $emailOrUsername, $password);
        if ($superAdminResult['success']) {
            return redirect()->intended($this->redirectTo);
        }

        // Step 2: Try Admin Authentication (third-party + database)
        $adminResult = $this->tryAdminAuthentication($request, $emailOrUsername, $password);
        if ($adminResult['success']) {
            return redirect()->intended($this->redirectTo);
        }

        // Step 3: Both failed, show specific error message
        return $this->sendFailedLoginResponse($request, $superAdminResult, $adminResult);
    }

    /**
     * Try Super Admin authentication (database only)
     */
    protected function trySuperAdminAuthentication(Request $request, string $emailOrUsername, string $password): array
    {
        // Try to authenticate with email
        if (Auth::attempt(['email' => $emailOrUsername, 'password' => $password], $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if user is Super Admin
            if ($user->hasRole('Super Admin')) {
                $request->session()->regenerate();
                $this->logAdminLogin($request, $user);
                return ['success' => true, 'message' => 'Super Admin login successful'];
            } else {
                // Logout if not Super Admin
                Auth::logout();
                return ['success' => false, 'message' => 'User exists but does not have Super Admin privileges'];
            }
        }

        // Try to authenticate with username
        if (Auth::attempt(['username' => $emailOrUsername, 'password' => $password], $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if user is Super Admin
            if ($user->hasRole('Super Admin')) {
                $request->session()->regenerate();
                $this->logAdminLogin($request, $user);
                return ['success' => true, 'message' => 'Super Admin login successful'];
            } else {
                // Logout if not Super Admin
                Auth::logout();
                return ['success' => false, 'message' => 'User exists but does not have Super Admin privileges'];
            }
        }

        return ['success' => false, 'message' => 'Invalid Super Admin credentials'];
    }

    /**
     * Try Admin authentication (third-party + database validation)
     */
    protected function tryAdminAuthentication(Request $request, string $emailOrUsername, string $password): array
    {
        // Step 1: Authenticate with third-party API first
        $honoResult = $this->honoAuthService->authenticateWithHono($emailOrUsername, $password);

        if (!$honoResult['success']) {
            if (isset($honoResult['error'])) {
                Log::warning('Third-party authentication failed for admin user', [
                    'username' => $emailOrUsername,
                    'hono_response' => $honoResult
                ]);
                return ['success' => false, 'message' => 'Authentication service is currently unavailable. Please try again later.'];
            } else {
                Log::warning('Third-party authentication failed for admin user', [
                    'username' => $emailOrUsername,
                    'hono_response' => $honoResult
                ]);
                return ['success' => false, 'message' => 'Invalid credentials for Admin access.'];
            }
        }

        $honoData = $honoResult['user_data'];

        // Step 2: Check if user exists in database
        $user = User::where('username', $emailOrUsername)
            ->orWhere('email', $emailOrUsername)
            ->first();

        if (!$user) {
            Log::warning('Admin user not found in database after third-party authentication', [
                'username' => $emailOrUsername,
                'hono_data' => $honoData
            ]);
            return ['success' => false, 'message' => 'Your account is not registered in the system. Please contact your administrator.'];
        }

        // Step 3: Verify user has Admin role (not Super Admin)
        if (!$user->hasRole('Admin')) {
            Log::warning('User does not have Admin role', [
                'username' => $emailOrUsername,
                'user_id' => $user->id,
                'roles' => $user->roles->pluck('name')->toArray()
            ]);
            return ['success' => false, 'message' => 'Your account does not have Admin privileges. Please contact your administrator.'];
        }

        // Step 4: Update user data from third-party
        $this->updateUserFromHonoData($user, $honoData);

        // Step 5: Login the user
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();
        $this->logHonoLogin($request, $user, $honoData);
        
        Log::info('Admin authentication successful - Both third-party and database validation passed', [
            'username' => $emailOrUsername,
            'user_id' => $user->id,
            'roles' => $user->roles->pluck('name')->toArray()
        ]);
        
        return ['success' => true, 'message' => 'Admin login successful'];
    }

    /**
     * Create new user from Hono data (for existing users only)
     */
    protected function createUserFromHonoData(array $honoData, string $emailOrUsername): ?User
    {
        try {
            $userData = [
                'username' => $emailOrUsername,
                'email' => $honoData['email'] ?? $emailOrUsername,
                'first_name' => $honoData['first_name'] ?? '',
                'last_name' => $honoData['last_name'] ?? '',
                'mobile_number' => $honoData['mobile_number'] ?? '',
                'password' => Hash::make('default_password_' . time()), // Temporary password
                'status' => true, // Fixed: use boolean instead of string
            ];

            $user = User::create($userData);
            
            // Assign default role
            $user->assignRole('Admin');
            
            return $user;
        } catch (\Exception $e) {
            Log::error('Error creating user from Hono data', [
                'username' => $emailOrUsername,
                'hono_data' => $honoData,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Update existing user from Hono data
     */
    protected function updateUserFromHonoData(User $user, array $honoData): void
    {
        $updateData = [];
        
        if (isset($honoData['first_name'])) {
            $updateData['first_name'] = $honoData['first_name'];
        }
        
        if (isset($honoData['last_name'])) {
            $updateData['last_name'] = $honoData['last_name'];
        }
        
        if (isset($honoData['mobile_number'])) {
            $updateData['mobile_number'] = $honoData['mobile_number'];
        }
        
        if (isset($honoData['email'])) {
            $updateData['email'] = $honoData['email'];
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }
    }

    /**
     * Send failed login response with specific error messages
     */
    protected function sendFailedLoginResponse(Request $request, array $superAdminResult = null, array $adminResult = null)
    {
        $emailOrUsername = $request->input('email');
        
        Log::warning('Login attempt failed', [
            'username' => $emailOrUsername,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'super_admin_result' => $superAdminResult,
            'admin_result' => $adminResult
        ]);

        // Determine the most specific error message
        $errorMessage = 'Invalid credentials. Please check your username/email and password.';
        
        if ($superAdminResult && $adminResult) {
            // Both authentication methods failed
            if (strpos($superAdminResult['message'], 'does not have Super Admin privileges') !== false) {
                $errorMessage = 'Your account does not have Super Admin privileges.';
            } elseif (strpos($adminResult['message'], 'not registered in the system') !== false) {
                $errorMessage = 'Your account is not registered in the system. Please contact your administrator.';
            } elseif (strpos($adminResult['message'], 'does not have Admin privileges') !== false) {
                $errorMessage = 'Your account does not have Admin privileges. Please contact your administrator.';
            } elseif (strpos($adminResult['message'], 'Authentication service is currently unavailable') !== false) {
                $errorMessage = 'Authentication service is currently unavailable. Please try again later.';
            } elseif (strpos($adminResult['message'], 'Invalid credentials for Admin access') !== false) {
                $errorMessage = 'Invalid credentials for Admin access.';
            }
        }

        return redirect()->back()
            ->withInput($request->except('password'))
            ->withErrors([
                'email' => $errorMessage,
            ]);
    }

    /**
     * Log admin login
     */
    protected function logAdminLogin(Request $request, User $user): void
    {
        Log::info('Admin login successful', [
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name')->toArray(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'login_type' => 'database_only'
        ]);
    }

    /**
     * Log Hono login
     */
    protected function logHonoLogin(Request $request, User $user, array $honoData): void
    {
        Log::info('Hono login successful', [
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name')->toArray(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'login_type' => 'third_party_and_database',
            'hono_data' => $honoData
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Log::info('User logout', [
            'user_id' => $user->id ?? null,
            'username' => $user->username ?? null,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent')
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}