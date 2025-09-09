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

class HomeController extends Controller
{
    /**
     * Display the home page with dynamic content
     */
    public function index()
    {
        // Fetch active banner sections ordered by language and sort_order
        $bannerSections = BannerSection::where('is_active', true)
            ->orderBy('language')
            ->orderBy('sort_order')
            ->get();

        // Fetch active main content ordered by language and sort_order
        $mainContent = MainContent::where('is_active', true)
            ->orderBy('language')
            ->orderBy('sort_order')
            ->first();

        // Fetch active guest of honour entries
        $guestOfHonours = GuestOfHonour::where('status', true)
            ->orderBy('language')
            ->orderBy('id')
            ->get();

        // Fetch active videos
        $videos = Video::where('is_active', true)
            ->orderBy('id')
            ->get();

        // Fetch active slider images
        $sliders = Slider::where('status', true)
            ->orderBy('id')
            ->get();

        // Fetch active participant statistics
        $participants = Participant::where('status', true)
            ->orderBy('language')
            ->orderBy('id')
            ->get();

        // Fetch active processes with their steps
        $processes = Process::where('status', true)
            ->with(['steps' => function($query) {
                $query->where('status', true)->orderBy('id');
            }])
            ->orderBy('language')
            ->orderBy('id')
            ->get();

        return view('front.home', compact(
            'bannerSections',
            'mainContent',
            'guestOfHonours',
            'videos',
            'sliders',
            'participants',
            'processes'
        ));
    }

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

    public function registerForm()
    {
        return view('front.register');
    }
}
