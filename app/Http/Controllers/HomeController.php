<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function contactUsPage()
    {
        return view('front.contact');
    }
    public function privacyPage()
    {
        return view('front.privacy-policy');
    }
    public function termsPage()
    {
        return view('front.terms-of-service');      
    }
    public function certificateGet()
    {
        return view('front.certificate-download');      
    }
    public function certificateDownload(Request $request)
    {
         $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $mobile = $request->mobile;

        // check if student exists after given date
        
        $student = DB::connection('sms')->table('je6_certi_student')
            ->where('mobile_number', $mobile)
            ->where('created_date', '>', '2024-04-20')
            ->first();

        if ($student) {
            $otp = rand(111111, 999999);
            $message = $otp . ' is your verification code for Dainik Bhaskar. - Bhaskar Group';

            $this->postMessage($mobile, $message);

            return response()->json([
                'status'  => 1,
                'message' => 'Receipt Found! We sent your OTP!',
                'data'    => $otp,
            ]);
        } else {
            return response()->json([
                'status'  => 0,
                'message' => 'Please enter your registered mobile number.',
                'data'    => [],
            ]);
        }
    }
    /**
     * Send SMS via Infobip
     */
    private function postMessage($numbers, $message)
    {
        if (strlen($numbers) <= 10) {
            $numbers = "91" . $numbers;
        }

        $url = "https://api.infobip.com/sms/1/text/query";

        $params = [
            "username" => "missedcall",
            "password" => "missedcall@123",
            "to" => $numbers,
            "text" => $message,
            "from" => "BHASKR",
            "indiaDltPrincipalEntityId" => "1101693520000011534",
            "indiaDltContentTemplateId" => "1107161140374009077",
        ];

        try {
            $response = Http::asForm()->post($url, $params);

            Log::info('Infobip SMS Response', [
                'mobile'   => $numbers,
                'response' => $response->body(),
            ]);

            return $response->body();
        } catch (\Exception $e) {
            Log::error('Infobip SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
