<?php

namespace App\Http\Controllers;

use App\Models\BannerSection;
use App\Models\MainContent;
use App\Models\GuestOfHonour;
use App\Models\Video;
use App\Models\Slider;
use App\Models\Participant;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\CmsPage;
use App\Models\CertiStudent;
use App\Models\CertiDownload;
use App\Models\MobileVerification;

class HomeController extends Controller
{
    /**
     * Display the home page with dynamic content
     */
    public function index(Request $request)
    {
        // Get language from query parameter or default to 'en'
        $currentLanguage = $request->get('lang', 'en');
        
        // Validate language parameter
        if (!in_array($currentLanguage, ['en', 'hi'])) {
            $currentLanguage = 'en';
        }

        // Fetch active banner sections for current language
        $bannerSections = BannerSection::where('is_active', true)
            ->where('language', $currentLanguage)
            ->orderBy('sort_order')
            ->get();

        // Fetch active main content for current language
        $mainContent = MainContent::where('is_active', true)
            ->where('language', $currentLanguage)
            ->orderBy('sort_order')
            ->first();

        // Fetch active guest of honour entries for current language
        $guestOfHonours = GuestOfHonour::where('status', true)
            ->where('language', $currentLanguage)
            ->orderBy('id')
            ->get();

        // Fetch active videos (language independent)
        $videos = Video::where('is_active', true)
            ->orderBy('id')
            ->get();

        // Fetch active slider images (language independent)
        $sliders = Slider::where('status', true)
            ->orderBy('id')
            ->get();

        // Fetch active participant statistics for current language
        $participants = Participant::where('status', true)
            ->where('language', $currentLanguage)
            ->orderBy('id')
            ->get();

        // Fetch active processes with their steps for current language
        $processes = Process::where('status', true)
            ->where('language', $currentLanguage)
            ->with(['steps' => function($query) {
                $query->where('status', true)->orderBy('id');
            }])
            ->orderBy('id')
            ->get();

        return view('front.home', compact(
            'bannerSections',
            'mainContent',
            'guestOfHonours',
            'videos',
            'sliders',
            'participants',
            'processes',
            'currentLanguage'
        ));
    }

    public function contactUsPage()
    {
        return view('front.contact');
    }
    public function privacyPage(Request $request)
    {
        $content = CmsPage::where('slug', 'privacy-policy')->first();
        return view('front.cms', compact('content'));
    }
    public function termsPage()
    {
        $content = CmsPage::where('slug', 'terms-and-conditions')->first();
        return view('front.cms', compact('content'));
        //return view('front.terms-of-service');      
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

        // Check daily OTP request limit for this mobile number - COMMENTED OUT
        // $config = config('certificate_rate_limit');
        // $dailyOtpKey = $config['cache_prefix']['otp_requests'] . '_daily:' . $mobile . ':' . date('Y-m-d');
        // $dailyOtpCount = Cache::get($dailyOtpKey, 0);
        
        // if ($dailyOtpCount >= $config['otp_requests']['per_day']) {
        //     return response()->json([
        //         'status' => 0,
        //         'message' => 'Daily OTP limit exceeded. You can request maximum ' . $config['otp_requests']['per_day'] . ' OTPs per day. Please try again tomorrow.',
        //         'data' => []
        //     ], 429);
        // }

        // check if student exists after given date
        $student = CertiStudent::where('mobile_number', $mobile)
            ->first();

        if ($student) {
            // Check if mobile can receive new OTP using MobileVerification model - COMMENTED OUT
            // if (!MobileVerification::canSendOtp($mobile)) {
            //     $rateLimitInfo = MobileVerification::getRateLimitInfo($mobile);
            //     $nextAvailable = $rateLimitInfo['next_available'];
                
            //     if ($nextAvailable) {
            //         $timeRemaining = $nextAvailable->diffInSeconds(now());
            //         return response()->json([
            //             'status' => 0,
            //             'message' => "Please wait {$timeRemaining} seconds before requesting another OTP.",
            //             'data' => []
            //         ], 429);
            //     } else {
            //         return response()->json([
            //             'status' => 0,
            //             'message' => 'Too many OTP requests. Please try again later.',
            //             'data' => []
            //         ], 429);
            //     }
            // }

            // Generate and store OTP using MobileVerification model
            $verification = MobileVerification::generateOtp(
                $mobile, 
                $request->ip(), 
                $request->userAgent()
            );

            $message = $verification->otp . ' is your verification code for Dainik Bhaskar. - Bhaskar Group';

            $this->postMessage($mobile, $message);

            // Increment daily OTP request counter - COMMENTED OUT
            // Cache::put($dailyOtpKey, $dailyOtpCount + 1, now()->endOfDay());

            return response()->json([
                'status'  => 1,
                'message' => 'Receipt Found! We sent your OTP!'
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
     * Verify OTP for certificate download
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6'
        ]);

        $mobile = $request->mobile;
        $otp = $request->otp;

        // Check if student exists
        $student = CertiStudent::where('mobile_number', $mobile)
            ->where('created_date', '>', '2024-04-20')
            ->first();

        if (!$student) {
            return response()->json([
                'status' => 0,
                'message' => 'Student not found with this mobile number.',
            ]);
        }

        // Verify OTP using MobileVerification model
        $isVerified = MobileVerification::verifyOtp($mobile, $otp);

        if ($isVerified) {
            return response()->json([
                'status' => 1,
                'message' => 'OTP verified successfully! You can now download your certificate.',
                'data' => [
                    'mobile' => $mobile,
                    'name' => $student->name
                ]
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid or expired OTP. Please try again.',
            ]);
        }
    }

    /**
     * Generate certificate for verified mobile number
     */
    public function certificateGenerate(Request $request)
    {
        $mobile = $request->get('mobile');
        
        if (!$mobile) {
            return response()->json([
                'status' => 0,
                'message' => 'Mobile number is required.',
            ]);
        }

        // Check if student exists
        $student = CertiStudent::where('mobile_number', $mobile)
            ->where('created_date', '>', '2024-04-20')
            ->first();

        if (!$student) {
            return response()->json([
                'status' => 0,
                'message' => 'Student not found with this mobile number.',
            ]);
        }

        // Redirect back to certificate download page with success message
        return redirect()->route('certificate.get')->with('success', 'Certificate downloaded successfully!');
    }

    /**
     * Download certificate as JPG image
     */
    public function certificateDownloadJpg(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $mobile = $request->mobile;

        // Check daily download limit for this mobile number - COMMENTED OUT
        // $config = config('certificate_rate_limit');
        // $dailyDownloadKey = $config['cache_prefix']['downloads'] . '_daily:' . $mobile . ':' . date('Y-m-d');
        // $dailyDownloadCount = Cache::get($dailyDownloadKey, 0);
        
        // if ($dailyDownloadCount >= $config['downloads']['per_day']) {
        //     return response()->json([
        //         'status' => 0,
        //         'message' => str_replace(':limit', $config['downloads']['per_day'], $config['error_messages']['too_many_downloads']),
        //     ], 429);
        // }

        // Check if student exists
        $student = CertiStudent::where('mobile_number', $mobile)
            ->where('created_date', '>', '2024-04-20')
            ->first();

        if (!$student) {
            return response()->json([
                'status' => 0,
                'message' => 'Student not found with this mobile number.',
            ]);
        }

        // Check if mobile number is verified via OTP
        if (!MobileVerification::isMobileVerified($mobile)) {
            return response()->json([
                'status' => 0,
                'message' => 'Please verify your mobile number with OTP before downloading certificate.',
            ]);
        }

        // We'll track the download after successful image generation

        // Track the download like in the original certi.php
        try {
            CertiDownload::create([
                'name' => $student->name,
                'mobile_number' => $mobile,
                'download_from' => request()->header('User-Agent'),
                'created_at' => now()
            ]);
        } catch (\Exception $e) {
            // Don't fail the download if tracking fails
            Log::error('Download tracking error: ' . $e->getMessage());
        }


        // Clear all output buffers first
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Load the certificate image exactly like certi.php
        $certificatePath = public_path('front/assets/img/certificate/certificate.jpg');
        
        if (!file_exists($certificatePath)) {
            echo "Certificate template not found";
            exit;
        }

        // Create image from certificate template
        $image = imagecreatefromjpeg($certificatePath);
        
        if (!$image) {
            echo "Error loading certificate template";
            exit;
        }

        // Set text color exactly like certi.php
        $textColor = imagecolorallocate($image, 19, 21, 22);
        
        // Get the font file path
        $fontFile = public_path('front/assets/fonts/OpenSans-SemiBold.ttf');
        
        // Use TTF font like the original certi.php
        $name = ucfirst($student->name);
        $nameFontSize = 60;
        
        // Calculate text width and adjust font size if needed
        $nameBox = imagettfbbox($nameFontSize, 0, $fontFile, $name);
        $nameWidth = abs($nameBox[4] - $nameBox[0]);
        
        // Reduce font size if text is too wide (matching original logic)
        while ($nameWidth > 1000 && $nameFontSize > 8) {
            $nameFontSize -= 2;
            $nameBox = imagettfbbox($nameFontSize, 0, $fontFile, $name);
            $nameWidth = abs($nameBox[4] - $nameBox[0]);
        }
        
        // Calculate position (matching original coordinates)
        $nameX = 1200 - ($nameWidth / 2);
        $nameX = round($nameX);
        $nameY = 1150;
        
        // Draw the text using TTF font
        imagettftext($image, $nameFontSize, 0, $nameX, $nameY, $textColor, $fontFile, $name);
        
        // Generate filename like the original certi.php
        $file_name = str_replace(' ', '_', $name);
        $filename = $file_name . '.jpg';
        
        // Set headers exactly like certi.php
        header("content-type:image/jpeg");
        header('Content-Disposition: attachment; filename=' . $filename);
        
        // Output the image directly like certi.php
        imagejpeg($image, null, 100);
        imagedestroy($image);
        
        // Increment daily download counter - COMMENTED OUT
        // Cache::put($dailyDownloadKey, $dailyDownloadCount + 1, now()->endOfDay());
        
        exit;
    }

    /**
     * Send SMS via Infobip
     */
    private function postMessage($numbers, $message)
    {
        if (strlen($numbers) <= 10) {
            $numbers = "91" . $numbers;
        }
        $url = "https://api.infobip.com/sms/1/text/query?username=missedcall&password=M!ssedc@ll2209&to=" . urlencode($numbers) . "&text=" . urlencode($message) . "&from=BHASKR&indiaDltPrincipalEntityId=1101693520000011534&indiaDltContentTemplateId=1107161140374009077";

        try {
            $response = Http::get($url);

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

    public function registerForm()
    {
        return view('front.register');
    }

}
