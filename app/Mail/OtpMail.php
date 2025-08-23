<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $code) {}

    public function build(): self
    {
        return $this->subject('Your Verification Code')
            ->markdown('emails.otp', ['code' => $this->code]);
    }
}
