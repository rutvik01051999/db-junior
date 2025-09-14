<?php

namespace App\Http\Controllers;

use App\Models\JuniorEditor;
use App\Models\MobileVerification;
use App\Models\State;
use App\Models\City;
use App\Models\RazorpayPaymentResponse;
use App\Models\RazorpayPaymentTransaction;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class JuniorEditorController extends Controller
{
    /**
     * Show the registration form
     */
    public function index()
    {
        return view('front.register');
    }

    /**
     * Send OTP to mobile number
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Please enter a valid 10-digit mobile number'
            ]);
        }

        try {
            $mobile = $request->mobile;
            
            // Check if registration already exists
            $existingRegistration = JuniorEditor::where('mobile_number', $mobile)
                ->where('payment_status', 'completed')
                ->first();

            if ($existingRegistration) {
                return response()->json([
                    'status' => '0',
                    'message' => 'Registration already completed for this mobile number'
                ]);
            }

            // Check rate limiting
            if (!MobileVerification::canSendOtp($mobile)) {
                $rateLimitInfo = MobileVerification::getRateLimitInfo($mobile);
                $timeRemaining = MobileVerification::getTimeUntilNextOtp($mobile);
                
                $message = 'Please wait before requesting another OTP';
                if ($rateLimitInfo['counts']['per_day'] >= $rateLimitInfo['limits']['per_day']) {
                    $message = 'Daily OTP limit reached. Please try again tomorrow.';
                } elseif ($rateLimitInfo['counts']['per_hour'] >= $rateLimitInfo['limits']['per_hour']) {
                    $message = 'Hourly OTP limit reached. Please try again in an hour.';
                } elseif ($timeRemaining > 0) {
                    $message = "Please wait {$timeRemaining} seconds before requesting another OTP";
                }
                
                return response()->json([
                    'status' => '0',
                    'message' => $message,
                    'rate_limit_info' => $rateLimitInfo,
                    'time_remaining' => $timeRemaining
                ]);
            }

            // Generate OTP using MobileVerification model
            $verification = MobileVerification::generateOtp(
                $mobile,
                $request->ip(),
                $request->userAgent()
            );

            // Log OTP activity
            ActivityLogService::logOtpActivity($request, 'sent', $mobile);

            // TODO: Send OTP via SMS service
            // For now, we'll return the OTP in response for testing
            Log::info("OTP for mobile {$mobile}: {$verification->otp}");

            return response()->json([
                'status' => '1',
                'message' => 'OTP sent successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('OTP sending failed: ' . $e->getMessage());
            return response()->json([
                'status' => '0',
                'message' => 'Failed to send OTP. Please try again.'
            ]);
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Invalid OTP format'
            ]);
        }

        try {
            // Verify OTP using MobileVerification model
            if (MobileVerification::verifyOtp($request->mobile, $request->otp)) {
                // Log successful OTP verification
                ActivityLogService::logOtpActivity($request, 'verified', $request->mobile);
                
                return response()->json([
                    'status' => '1',
                    'message' => 'Mobile number verified successfully'
                ]);
            } else {
                // Log failed OTP verification
                ActivityLogService::logOtpActivity($request, 'verification_failed', $request->mobile);
                
                return response()->json([
                    'status' => '0',
                    'message' => 'Invalid or expired OTP'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('OTP verification failed: ' . $e->getMessage());
            return response()->json([
                'status' => '0',
                'message' => 'OTP verification failed. Please try again.'
            ]);
        }
    }

    /**
     * Get all states
     */
    public function getStates()
    {
        try {
            $states = State::orderBy('name')->get(['id', 'name']);
            
            return response()->json([
                'status' => 'success',
                'data' => $states
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch states: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch states'
            ]);
        }
    }

    /**
     * Get cities by state
     */
    public function getCities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'State is required'
            ]);
        }

        try {
            $state = State::where('name', $request->state)->first();
            
            if (!$state) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'State not found'
                ]);
            }

            $cities = City::where('state_id', $state->id)
                ->orderBy('name')
                ->get(['id', 'name']);

            return response()->json([
                'status' => 'success',
                'data' => $cities
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch cities: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch cities'
            ]);
        }
    }

    /**
     * Save partial registration data
     */
    public function savePartialRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_name' => 'nullable|string|max:255',
            'mobile' => 'required|digits:10',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'pincode' => 'nullable|digits:6',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'school_name' => 'nullable|string|max:255',
            'school_telephone' => 'nullable|string|max:12',
            'school_class' => 'nullable|in:4,5,6,7,8,9,10,11,12',
            'school_address' => 'nullable|string',
            'delivery_type' => 'nullable|in:Door Step Delivery,Self Pick Up',
            'amount' => 'nullable|numeric|min:0',
            'pickup_centers' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        try {
            // Check if mobile is verified using MobileVerification model
            if (!MobileVerification::isMobileVerified($request->mobile)) {
                return response()->json([
                    'status' => '0',
                    'message' => 'Please verify your mobile number first'
                ]);
            }

            // Find or create registration record
            $registration = JuniorEditor::firstOrCreate(
                ['mobile_number' => $request->mobile],
                ['mobile_verified' => true]
            );

            // Prepare data for update (only include non-null values)
            $updateData = [
                'from_source' => $request->from ?? 'direct',
            ];

            // Only update fields that have values
            $fieldsToUpdate = [
                'parent_name', 'first_name', 'last_name', 'email', 'birth_date',
                'gender', 'address', 'pincode', 'state', 'city', 'school_name',
                'school_telephone', 'school_class', 'school_address', 'delivery_type',
                'amount', 'pickup_centers'
            ];

            foreach ($fieldsToUpdate as $field) {
                if ($request->has($field) && $request->$field !== null && $request->$field !== '') {
                    $updateData[$field] = $request->$field;
                }
            }

            // Update registration with form data
            $registration->update($updateData);

            // Log form submission activity
            ActivityLogService::logFormSubmission($request, 'Junior Editor Registration', $request->all());

            return response()->json([
                'status' => '1',
                'message' => 'Registration data saved successfully',
                'data' => [
                    'registration_id' => $registration->id,
                    'mobile' => $request->mobile,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Partial registration save failed: ' . $e->getMessage());
            return response()->json([
                'status' => '0',
                'message' => 'Failed to save registration data. Please try again.'
            ]);
        }
    }

    /**
     * Create Razorpay order
     */
    public function createOrder(Request $request)
    {
        Log::info('=== CREATE ORDER REQUEST START ===');
        Log::info('Request Method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Request Headers: ', $request->headers->all());
        Log::info('Request Data: ', $request->all());
        Log::info('CSRF Token: ' . $request->header('X-CSRF-TOKEN'));
        Log::info('Content Type: ' . $request->header('Content-Type'));
        
        $validator = Validator::make($request->all(), [
            'parent_name' => 'nullable|string|max:255',
            'mobile' => 'required|digits:10',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'pincode' => 'nullable|digits:6',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'school_name' => 'nullable|string|max:255',
            'school_telephone' => 'nullable|string|max:12',
            'school_class' => 'nullable|in:4,5,6,7,8,9,10,11,12',
            'school_address' => 'nullable|string',
            'delivery_type' => 'nullable|in:Door Step Delivery,Self Pick Up',
            'amount' => 'nullable|numeric|min:0',
            'pickup_centers' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        try {
            // Check if mobile is verified using MobileVerification model
            if (!MobileVerification::isMobileVerified($request->mobile)) {
                return response()->json([
                    'status' => '0',
                    'message' => 'Please verify your mobile number first'
                ]);
            }

            // Find or create registration record
            $registration = JuniorEditor::firstOrCreate(
                ['mobile_number' => $request->mobile],
                ['mobile_verified' => true]
            );

            // Prepare data for update (only include non-null values)
            $updateData = [
                'from_source' => $request->from ?? 'direct',
            ];

            // Only update fields that have values
            $fieldsToUpdate = [
                'parent_name', 'first_name', 'last_name', 'email', 'birth_date',
                'gender', 'address', 'pincode', 'state', 'city', 'school_name',
                'school_telephone', 'school_class', 'school_address', 'delivery_type',
                'amount', 'pickup_centers'
            ];

            foreach ($fieldsToUpdate as $field) {
                if ($request->has($field) && $request->$field !== null && $request->$field !== '') {
                    $updateData[$field] = $request->$field;
                }
            }

            // Update registration with form data
            $registration->update($updateData);

            // Create Razorpay order
            $amount = $request->amount * 100; // Convert to paise
            $receipt = 'JE_' . $registration->id . '_' . time();

            // Create order via Razorpay API
            $orderData = [
                'amount' => $amount,
                'currency' => 'INR',
                'receipt' => $receipt,
                'payment_capture' => 1,
                'notes' => [
                    'registration_id' => $registration->id,
                    'mobile' => $request->mobile,
                    'parent_name' => $request->parent_name ?? 'N/A',
                ]
            ];

            // Generate Razorpay order
            $razorpayResponse = $this->generateRazorpayOrder($orderData);
            
            if (!$razorpayResponse || !isset($razorpayResponse['id'])) {
                return response()->json([
                    'status' => '0',
                    'message' => 'Failed to create payment order. Please try again.'
                ]);
            }

            $orderId = $razorpayResponse['id'];
            $registration->update(['razorpay_order_id' => $orderId]);

            Log::info('Order created successfully: ' . $orderId);
            Log::info('=== CREATE ORDER REQUEST END ===');
            
            return response()->json([
                'status' => '1',
                'message' => 'Order created successfully',
                'data' => [
                    'order_id' => $orderId,
                    'amount' => $amount,
                    'receipt' => $receipt,
                    'mobile' => $request->mobile,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());
            Log::info('=== CREATE ORDER REQUEST END (ERROR) ===');
            return response()->json([
                'status' => '0',
                'message' => 'Failed to create order. Please try again.'
            ]);
        }
    }

    /**
     * Update payment status
     */
    public function updatePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'mobile' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Invalid payment data'
            ]);
        }

        try {
            $registration = JuniorEditor::where('mobile_number', $request->mobile)
                ->where('razorpay_order_id', $request->razorpay_order_id)
                ->first();

            if (!$registration) {
                return response()->json([
                    'status' => '0',
                    'message' => 'Registration not found'
                ]);
            }

            // Verify Razorpay signature
            $isSignatureValid = $this->verifyRazorpaySignature(
                $request->razorpay_order_id,
                $request->razorpay_payment_id,
                $request->razorpay_signature
            );

            if (!$isSignatureValid) {
                Log::warning('Invalid Razorpay signature for order: ' . $request->razorpay_order_id);
                return response()->json([
                    'status' => '0',
                    'message' => 'Payment verification failed'
                ]);
            }

            // Use database transaction to ensure data consistency
            DB::beginTransaction();
            
            try {
                // Update registration
                $registration->update([
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                    'payment_status' => 'completed',
                ]);

                // Save to razorpay_payment_response table
                RazorpayPaymentResponse::create([
                    'mobile' => $request->mobile,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_signature' => $request->razorpay_signature,
                    'status' => 1, // 1 for completed, 0 for failed
                    'date' => now()->format('Y-m-d'),
                ]);

                // Save to razorpay_payments_transaction table
                RazorpayPaymentTransaction::create([
                    'mobile' => $request->mobile,
                    'order_id' => $request->razorpay_order_id,
                    'entity' => 'payment',
                    'amount' => $registration->amount ? ($registration->amount * 100) : '0', // Convert to paise
                    'amount_paid' => $registration->amount ? ($registration->amount * 100) : '0',
                    'amount_due' => '0',
                    'currency' => 'INR',
                    'receipt' => 'JE_' . $registration->id . '_' . time(),
                    'status' => 'paid',
                    'attempts' => '1',
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'payment_update_api_check' => 1,
                ]);

                DB::commit();
                Log::info('Payment data saved to both tables for mobile: ' . $request->mobile);
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Failed to save payment data to tables: ' . $e->getMessage());
                throw $e; // Re-throw to be caught by outer try-catch
            }

            // TODO: Send confirmation email and SMS

            return response()->json([
                'status' => '1',
                'message' => 'Payment updated successfully',
                'razorpay_payment_id' => $request->razorpay_payment_id
            ]);

        } catch (\Exception $e) {
            Log::error('Payment update failed: ' . $e->getMessage());
            return response()->json([
                'status' => '0',
                'message' => 'Failed to update payment'
            ]);
        }
    }

    /**
     * Generate Razorpay order
     */
    private function generateRazorpayOrder($orderData)
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.razorpay.com/v1/orders",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($orderData),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Basic cnpwX2xpdmVfVTZTUWtJMU9IU2paMm46WjltTFhmYXVPd0JtbWRyWVJVckNIdEgw"
                ),
            ));

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                Log::error('Razorpay cURL Error: ' . $error);
                return null;
            }

            if ($httpCode !== 200) {
                Log::error('Razorpay API Error: HTTP ' . $httpCode . ' - ' . $response);
                return null;
            }

            $responseData = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Razorpay JSON Decode Error: ' . json_last_error_msg());
                return null;
            }

            Log::info('Razorpay Order Created: ' . $response);
            return $responseData;

        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify Razorpay signature
     */
    private function verifyRazorpaySignature($orderId, $paymentId, $signature)
    {
        try {
            $razorpayKeySecret = 'Z9mLXfauOwBmmdrYRUrCHtH0'; // Extract from your auth string
            
            $generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $razorpayKeySecret);
            
            return hash_equals($generatedSignature, $signature);
            
        } catch (\Exception $e) {
            Log::error('Razorpay Signature Verification Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Test endpoint to check if form submission is working
     */
    public function testFormSubmission(Request $request)
    {
        Log::info('=== TEST FORM SUBMISSION ===');
        Log::info('Request Method: ' . $request->method());
        Log::info('Request Data: ', $request->all());
        Log::info('CSRF Token: ' . $request->header('X-CSRF-TOKEN'));
        
        return response()->json([
            'status' => '1',
            'message' => 'Test form submission successful',
            'data' => $request->all()
        ]);
    }

    /**
     * Get rate limit information for a mobile number
     */
    public function getRateLimitInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Please enter a valid 10-digit mobile number'
            ]);
        }

        try {
            $mobile = $request->mobile;
            $rateLimitInfo = MobileVerification::getRateLimitInfo($mobile);
            $timeRemaining = MobileVerification::getTimeUntilNextOtp($mobile);
            
            return response()->json([
                'status' => '1',
                'data' => [
                    'rate_limit_info' => $rateLimitInfo,
                    'time_remaining' => $timeRemaining
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Rate limit info failed: ' . $e->getMessage());
            return response()->json([
                'status' => '0',
                'message' => 'Failed to get rate limit information'
            ]);
        }
    }

    /**
     * Handle payment failure
     */
    public function handlePaymentFailure(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_order_id' => 'required|string',
            'mobile' => 'required|string',
            'error_code' => 'nullable|string',
            'error_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Invalid payment failure data'
            ]);
        }

        try {
            $registration = JuniorEditor::where('mobile_number', $request->mobile)
                ->where('razorpay_order_id', $request->razorpay_order_id)
                ->first();

            if (!$registration) {
                return response()->json([
                    'status' => '0',
                    'message' => 'Registration not found'
                ]);
            }

            $registration->update([
                'payment_status' => 'failed',
            ]);

            Log::info('Payment failed for registration: ' . $registration->id, [
                'error_code' => $request->error_code,
                'error_description' => $request->error_description
            ]);

            return response()->json([
                'status' => '1',
                'message' => 'Payment failure recorded'
            ]);

        } catch (\Exception $e) {
            Log::error('Payment failure handling failed: ' . $e->getMessage());
            return response()->json([
                'status' => '0',
                'message' => 'Failed to record payment failure'
            ]);
        }
    }
}