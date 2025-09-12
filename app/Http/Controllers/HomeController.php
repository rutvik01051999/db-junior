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
use App\Models\CmsPage;
use App\Models\CertiStudent;

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

        // check if student exists after given date
        
        $student = CertiStudent::where('mobile_number', $mobile)
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

        // For now, redirect to a simple certificate view
        // You can implement PDF generation here later
        return view('front.certificate', compact('student'));
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
