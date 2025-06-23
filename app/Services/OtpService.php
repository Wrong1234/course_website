<?php

namespace App\Services;
use App\Models\user_otp;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OtpService
{
    public function generateOtp($email)
    {

        user_otp::where('email', $email)
            ->where('is_used', false)
            ->delete(); 

        //Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        //Generate a unique verification token
        $verificationToken = Str::random(64);

        $user_otp = user_otp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'verification_token' => $verificationToken,
            'is_used' => false,
        ]);

        //Generate verification link
        $verificationLink = route('email.verify.link', ['token' => $verificationToken]);

        //Send OTP and verification link via email
        mail::to($email)->send(new OtpMail($otp, $verificationLink));

        return $user_otp;
    }

   public function verifyOtp($email, $otp)
    {
        $userOtp = user_otp::where('email', $email)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->first();

        if (!$userOtp && $userOtp->isExpired()) {
         
            return false; 

        }

        // Mark the OTP as used
        $userOtp->update(['is_used' => true]);

        return true;
    }

    public function verifyByToken($token)
    {
        $userOtp = user_otp::where('verification_token', $token)
            ->where('is_used', false)
            ->first();

        if (!$userOtp || $userOtp->isExpired()) {
            return false; 
        }

        // Mark the OTP as used
        $userOtp->update(['is_used' => true]);

        return $userOtp->email;
    }
}