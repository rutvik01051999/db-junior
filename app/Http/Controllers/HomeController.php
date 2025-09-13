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

        try {
            // Load the certificate image
            $certificatePath = public_path('front/assets/img/certificate/certificate.jpg');
            
            if (!file_exists($certificatePath)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Certificate template not found.',
                ]);
            }

            // Check if the file is a valid JPEG
            $imageInfo = getimagesize($certificatePath);
            if ($imageInfo === false || $imageInfo[2] !== IMAGETYPE_JPEG) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Invalid certificate template format.',
                ]);
            }

            // Create image from certificate template
            $image = imagecreatefromjpeg($certificatePath);
            
            if (!$image) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Error loading certificate template.',
                ]);
            }

            // Set text colors - using darker colors for better visibility
            $textColor = imagecolorallocate($image, 0, 0, 0); // Black text
            $whiteColor = imagecolorallocate($image, 255, 255, 255); // White background
            
            // Get image dimensions
            $imageWidth = imagesx($image);
            $imageHeight = imagesy($image);
            
            // Calculate text position (center of image)
            $text = strtoupper($student->name);
            
            // Create larger text effect by using multiple font sizes and positioning
            $fontSize = 5; // Largest built-in font
            $fontWidth = imagefontwidth($fontSize);
            $fontHeight = imagefontheight($fontSize);
            
            // Calculate position for student name (center of image)
            $textLength = strlen($text);
            $textWidth = $textLength * $fontWidth;
            $textX = ($imageWidth - $textWidth) / 2;
            $textY = ($imageHeight / 2) - ($fontHeight / 2);
            
            // Add larger white background rectangle behind text for better visibility
            $padding = 20; // Increased padding for larger appearance
            imagefilledrectangle($image, 
                $textX - $padding, 
                $textY - $padding, 
                $textX + $textWidth + $padding, 
                $textY + $fontHeight + $padding, 
                $whiteColor
            );
            
            // Create a larger text effect by scaling up the font
            // Method 1: Draw text multiple times with offsets for bold effect
            $offset = 2; // Increased offset for more prominent effect
            for ($i = -$offset; $i <= $offset; $i++) {
                for ($j = -$offset; $j <= $offset; $j++) {
                    imagestring($image, $fontSize, $textX + $i, $textY + $j, $text, $textColor);
                }
            }
            
            // Method 2: Create a scaled version by drawing each character larger
            $charSpacing = 0;
            $currentX = $textX;
            for ($i = 0; $i < strlen($text); $i++) {
                $char = $text[$i];
                // Draw each character with slight scaling effect
                imagestring($image, $fontSize, $currentX, $textY, $char, $textColor);
                imagestring($image, $fontSize, $currentX + 1, $textY, $char, $textColor);
                imagestring($image, $fontSize, $currentX, $textY + 1, $char, $textColor);
                imagestring($image, $fontSize, $currentX + 1, $textY + 1, $char, $textColor);
                
                $currentX += $fontWidth + $charSpacing;
            }
            
            // Add certificate details at bottom
            $details = "Mobile: " . $student->mobile_number . " | Date: " . date('d M Y', strtotime($student->created_date));
            $detailsFontSize = 3;
            $detailsFontWidth = imagefontwidth($detailsFontSize);
            $detailsFontHeight = imagefontheight($detailsFontSize);
            $detailsLength = strlen($details);
            $detailsWidth = $detailsLength * $detailsFontWidth;
            $detailsX = ($imageWidth - $detailsWidth) / 2;
            $detailsY = $imageHeight - 150;
            
            // Add white background for details
            imagefilledrectangle($image, 
                $detailsX - 5, 
                $detailsY - 5, 
                $detailsX + $detailsWidth + 5, 
                $detailsY + $detailsFontHeight + 5, 
                $whiteColor
            );
            
            imagestring($image, $detailsFontSize, $detailsX, $detailsY, $details, $textColor);
            
            // Add certificate ID
            $certId = "ID: JE" . $student->id . date('Y');
            $certIdFontSize = 2;
            $certIdFontWidth = imagefontwidth($certIdFontSize);
            $certIdFontHeight = imagefontheight($certIdFontSize);
            $certIdLength = strlen($certId);
            $certIdWidth = $certIdLength * $certIdFontWidth;
            $certIdX = $imageWidth - $certIdWidth - 100;
            $certIdY = $imageHeight - 100;
            
            // Add white background for certificate ID
            imagefilledrectangle($image, 
                $certIdX - 5, 
                $certIdY - 5, 
                $certIdX + $certIdWidth + 5, 
                $certIdY + $certIdFontHeight + 5, 
                $whiteColor
            );
            
            imagestring($image, $certIdFontSize, $certIdX, $certIdY, $certId, $textColor);
            
            // Set filename
            $filename = 'Certificate_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->name) . '_' . date('Y-m-d') . '.jpg';
            
            // Create a temporary file to store the image
            $tempFile = tempnam(sys_get_temp_dir(), 'cert_');
            $tempFile .= '.jpg';
            
            // Save image to temporary file first
            if (!imagejpeg($image, $tempFile, 90)) {
                imagedestroy($image);
                return response()->json([
                    'status' => 0,
                    'message' => 'Error saving certificate image.',
                ]);
            }
            
            // Clean up the image resource
            imagedestroy($image);
            
            // Read the file and output it
            $imageData = file_get_contents($tempFile);
            
            // Verify the image data is valid
            if ($imageData === false || strlen($imageData) === 0) {
                unlink($tempFile);
                return response()->json([
                    'status' => 0,
                    'message' => 'Error reading generated certificate.',
                ]);
            }
            
            // Check if the data starts with proper JPEG header
            $jpegHeader = substr($imageData, 0, 4);
            if ($jpegHeader !== "\xFF\xD8\xFF\xE0" && $jpegHeader !== "\xFF\xD8\xFF\xE1") {
                \Log::error('Invalid JPEG header: ' . bin2hex($jpegHeader));
                unlink($tempFile);
                return response()->json([
                    'status' => 0,
                    'message' => 'Generated certificate is corrupted.',
                ]);
            }
            
            // Clean up temporary file
            unlink($tempFile);
            
            // Clear any output buffer to prevent corruption
            if (ob_get_level()) {
                ob_clean();
            }
            
            // Set proper headers and return clean response
            return response($imageData, 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($imageData),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('JPG Generation Error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 0,
                'message' => 'Error generating certificate. Please try again.',
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
