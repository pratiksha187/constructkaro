<?php
// app/Services/SmsService.php
namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    // Replace this with real provider (Twilio/MSG91/Vonage)
    public function send(string $to, string $message): void
    {
        Log::info("SMS to {$to}: {$message}");
        // Example: call your SMS API here.
    }
}
