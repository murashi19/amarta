<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $otp;

    public function __construct($name, $otp)
    {
        $this->name = $name;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi Akun Anda')
                    ->view('emails.verify-code')
                    ->with([
                        'name' => $this->name,
                        'otp' => $this->otp
                    ]);
    }
}

