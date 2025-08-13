<?php 
// app/Mail/OtpMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $code) {}

    public function build()
    {
        return $this->subject('Your ConstructKaro Verification Code')
            ->view('emails.otp')
            ->with(['code' => $this->code]);
    }
}
