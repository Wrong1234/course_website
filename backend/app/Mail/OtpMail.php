<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $verificationLink; // ✅ fixed casing

    public function __construct($otp, $verificationLink) // ✅ match casing
    {
        $this->otp = $otp;
        $this->verificationLink = $verificationLink;
    }

    public function build()
    {
        return $this->subject('Email Verification')
                    ->view('emails.otpLink');
    }
}
