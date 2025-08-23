<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client as Twilio;

class OtpService
{
    public function __construct(private ?Twilio $twilio = null)
    {
        $sid   = config('services.twilio.sid');
        $token = config('services.twilio.token');
        if ($sid && $token) {
            $this->twilio = new Twilio($sid, $token);
        }
    }

    public function generateCode(): string
    {
        $len = config('otp.length');
        $min = (int) pow(10, $len - 1);
        $max = (int) pow(10, $len) - 1;
        return (string) random_int($min, $max);
    }

    public function canResend(?OtpVerification $row): bool
    {
        if (!$row || !$row->last_sent_at) return true;
        return now()->diffInSeconds($row->last_sent_at) >= config('otp.resend_cooldown_seconds');
    }

    public function send(string $channel, string $destination, ?string $sessionKey = null): void
    {
        $channel = strtolower($channel);
        if (!in_array($channel, ['sms','email'])) {
            throw ValidationException::withMessages(['channel' => 'Invalid channel.']);
        }

        $prev = OtpVerification::where('channel',$channel)
            ->where('destination',$destination)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if ($prev && !$this->canResend($prev)) {
            $sec = config('otp.resend_cooldown_seconds');
            throw ValidationException::withMessages(['resend' => "Please wait {$sec} seconds before requesting another code."]);
        }

        $code = $this->generateCode();

        $row = OtpVerification::create([
            'channel'      => $channel,
            'destination'  => $destination,
            'code_hash'    => Hash::make($code),
            'expires_at'   => now()->addMinutes(config('otp.expires_minutes')),
            'last_sent_at' => now(),
            'session_key'  => $sessionKey,
        ]);

        if ($channel === 'sms') {
            $this->sendSms($destination, $code);
        } else {
            $this->sendEmail($destination, $code);
        }
    }

    public function verify(string $channel, string $destination, string $code): bool
    {
        $row = OtpVerification::where('channel',$channel)
            ->where('destination',$destination)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$row) {
            throw ValidationException::withMessages(['otp' => 'No active OTP found. Request a new code.']);
        }

        if ($row->isExpired()) {
            throw ValidationException::withMessages(['otp' => 'OTP expired. Request a new code.']);
        }

        if ($row->attempts >= config('otp.max_attempts')) {
            throw ValidationException::withMessages(['otp' => 'Too many attempts. Request a new code.']);
        }

        $row->increment('attempts');

        if (!Hash::check($code, $row->code_hash)) {
            throw ValidationException::withMessages(['otp' => 'Incorrect code.']);
        }

        $row->verified_at = now();
        $row->save();

        return true;
    }

    protected function sendSms(string $to, string $code): void
    {
        if (!$this->twilio) {
            throw new \RuntimeException('Twilio client not initialized.');
        }

        $from = config('services.twilio.from_sms');
        $msg  = "Your verification code is: {$code}. It expires in ".config('otp.expires_minutes')." minutes.";

        $this->twilio->messages->create($to, [
            'from' => $from,
            'body' => $msg,
        ]);
    }

    protected function sendEmail(string $email, string $code): void
    {
        Mail::to($email)->send(new OtpMail($code));
    }
}
