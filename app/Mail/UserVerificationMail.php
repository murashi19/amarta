<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $otpCode;
    public $verificationUrl;

    public function __construct($name, $verification_code, $verificationUrl)
    {
        $this->name = $name;
        $this->verification_code = $verification_code;
        $this->verificationUrl = $verificationUrl;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi Akun Anda')
                    ->view('emails.verify-code')
                    ->with([
                        'name' => $this->name,
                        'verification_code' => $this->verification_code,
                        'verificationUrl' => $this->verificationUrl
                    ]);
    }
}

