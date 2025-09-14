<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use App\Services\ActivityLogService;
use App\Services\PepipostMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Store a newly created contact form submission.
     */
    public function store(ContactFormRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Log form submission activity
            ActivityLogService::logFormSubmission($request, 'Contact Form', $validated);

            // Send email notification
            $this->sendContactEmail($validated['name'], $validated['email'], $validated['phone_number'], $validated['message']);

            return redirect()->back()->with('success', __('contact.messages.success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('contact.messages.error'));
        }
    }

    /**
     * Send contact form email notification
     */
    private function sendContactEmail($name, $email, $phone, $message)
    {
        try {
            // Primary recipient
            $primaryRecipient = 'yb@dbcorp.in';
            
            // CC recipients
            $ccRecipients = [
                'harshkishorkumar.dave@dainikbhaskar.com',
                // 'gopal@dbcorp.in', // Uncomment if needed
            ];

            // Generate HTML content using the email template
            $htmlContent = view('emails.contact-form', [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'message' => $message
            ])->render();

            // Send email using Pepipost service
            $pepipostService = new PepipostMailService();
            $result = $pepipostService->sendEmail(
                $primaryRecipient,
                $ccRecipients,
                'New Inquiry Junior Editor',
                $htmlContent
            );

            if ($result) {
                Log::info('Contact form email sent successfully via Pepipost');
            } else {
                Log::error('Failed to send contact form email via Pepipost');
            }

        } catch (\Exception $e) {
            // Log the error but don't fail the form submission
            Log::error('Failed to send contact form email: ' . $e->getMessage());
        }
    }
}
