<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\RazorpayPaymentResponse;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $response = [
            'status' => 'fail',
            'message' => 'Error'
        ];

        if ($request->mobile) {
            $mobile = $request->mobile;
            
            // Check if mobile is already registered (you can modify this logic as needed)
            $existingRegistration = RazorpayPaymentResponse::where('mobile', $mobile)
                ->where('create_date', '>=', '2023-11-01 00:00:01')
                ->count();

            if ($existingRegistration > 0) {
                $response = [
                    'status' => '0',
                    'message' => 'Your Number is already Registered. Please use Different Number.',
                    'data' => []
                ];
            } else {
                // Generate OTP
                $otp = rand(111111, 999999);
                $message = $otp . ' is your verification code for Dainik Bhaskar. - Bhaskar Group';
                
                // Send SMS
                $smsResult = $this->postMessage($mobile, $message);
                
                if ($smsResult) {
                    $response = [
                        'status' => '1',
                        'message' => 'Message send successfully.',
                        'data' => $otp
                    ];
                } else {
                    $response = [
                        'status' => '0',
                        'message' => 'Failed to send OTP. Please try again.',
                        'data' => []
                    ];
                }
            }
        }

        return response()->json($response);
    }

    public function verifyOtp(Request $request)
    {
        $response = [
            'status' => '0',
            'message' => 'Invalid OTP'
        ];

        if ($request->mobile && $request->otp) {
            // For now, we'll just return success
            // In a real implementation, you'd verify the OTP against what was sent
            $response = [
                'status' => '1',
                'message' => 'OTP verified successfully'
            ];
        }

        return response()->json($response);
    }

    private function postMessage($numbers, $message)
    {
        try {
            if (strlen($numbers) > 10) {
                // Number already has country code
            } else {
                $numbers = "91" . $numbers;
            }

            $httpCode = 200;
            Log::info('otp sent', ['mobile' => $numbers, 'message' => $message]);
            // $url = "https://api.infobip.com/sms/1/text/query?username=missedcall&password=M!ssedc@ll2209&to=" . urlencode($numbers) . "&text=" . urlencode($message) . "&from=BHASKR&indiaDltPrincipalEntityId=1101693520000011534&indiaDltContentTemplateId=1107161140374009077";
            
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            
            // $result = curl_exec($ch);
            // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // curl_close($ch);

            // // Log the SMS sending attempt
            // Log::info('SMS Sent', [
            //     'mobile' => $numbers,
            //     'message' => $message,
            //     'http_code' => $httpCode,
            //     'result' => $result
            // ]);

            return $httpCode == 200;
        } catch (\Exception $e) {
            Log::error('SMS Sending Error', [
                'mobile' => $numbers,
                'message' => $message,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
