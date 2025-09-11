<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MobileVerification extends Model
{
    use HasFactory;

    protected $table = 'mobile_verifications';

    protected $fillable = [
        'mobile_number',
        'otp',
        'otp_expires_at',
        'is_verified',
        'verified_at',
        'attempts',
        'last_attempt_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'last_attempt_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    /**
     * Generate and store OTP for mobile number
     */
    public static function generateOtp(string $mobileNumber, string $ipAddress = null, string $userAgent = null): self
    {
        // Check if there's an existing unverified OTP that's still valid
        $existing = self::where('mobile_number', $mobileNumber)
            ->where('is_verified', false)
            ->where('otp_expires_at', '>', now())
            ->first();

        if ($existing) {
            // Update attempts and last attempt time
            $existing->update([
                'attempts' => $existing->attempts + 1,
                'last_attempt_at' => now(),
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);
            return $existing;
        }

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Create new verification record
        $verification = self::create([
            'mobile_number' => $mobileNumber,
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5), // OTP expires in 5 minutes
            'is_verified' => false,
            'attempts' => 1,
            'last_attempt_at' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        Log::info("OTP generated for mobile {$mobileNumber}: {$otp}");
        
        return $verification;
    }

    /**
     * Verify OTP for mobile number
     */
    public static function verifyOtp(string $mobileNumber, string $otp): bool
    {
        $verification = self::where('mobile_number', $mobileNumber)
            ->where('is_verified', false)
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$verification) {
            Log::warning("OTP verification failed: No valid OTP found for mobile {$mobileNumber}");
            return false;
        }

        // Check if too many attempts
        if ($verification->attempts >= 5) {
            Log::warning("OTP verification failed: Too many attempts for mobile {$mobileNumber}");
            return false;
        }

        if ($verification->otp === $otp) {
            // Mark as verified
            $verification->update([
                'is_verified' => true,
                'verified_at' => now(),
            ]);

            Log::info("OTP verified successfully for mobile {$mobileNumber}");
            return true;
        } else {
            // Increment attempts
            $verification->update([
                'attempts' => $verification->attempts + 1,
                'last_attempt_at' => now(),
            ]);

            Log::warning("OTP verification failed: Invalid OTP for mobile {$mobileNumber}");
            return false;
        }
    }

    /**
     * Check if mobile number is verified
     */
    public static function isMobileVerified(string $mobileNumber): bool
    {
        return self::where('mobile_number', $mobileNumber)
            ->where('is_verified', true)
            ->exists();
    }

    /**
     * Get the latest verification for a mobile number
     */
    public static function getLatestVerification(string $mobileNumber): ?self
    {
        return self::where('mobile_number', $mobileNumber)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Clean up expired OTPs (can be called via scheduled task)
     */
    public static function cleanupExpiredOtps(): int
    {
        return self::where('otp_expires_at', '<', now())
            ->where('is_verified', false)
            ->delete();
    }

    /**
     * Check if OTP is valid and not expired
     */
    public function isOtpValid(): bool
    {
        return $this->otp_expires_at && $this->otp_expires_at->isFuture();
    }

    /**
     * Check if mobile can receive new OTP (rate limiting)
     */
    public static function canSendOtp(string $mobileNumber): bool
    {
        $lastVerification = self::where('mobile_number', $mobileNumber)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$lastVerification) {
            return true;
        }

        // Allow new OTP only if last one was sent more than 1 minute ago
        return $lastVerification->created_at->addMinute()->isPast();
    }
}