<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    private Client $client;
    private ?string $from;
    private ?string $messagingServiceSid;

    public function __construct()
    {
        $this->client = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );

        $this->from = env('TWILIO_PHONE'); // optional
        $this->messagingServiceSid = env('TWILIO_MESSAGING_SERVICE_SID'); // preferred
    }

    /**
     * Send SMS via Twilio
     * $to must be E.164 (+91XXXXXXXXXX)
     */
    public function send(string $to, string $message): array
    {
        try {
            $params = ['body' => $message];

            if ($this->messagingServiceSid) {
                $params['messagingServiceSid'] = $this->messagingServiceSid;
            } elseif ($this->from) {
                $params['from'] = $this->from;
            } else {
                throw new \RuntimeException('No Twilio sender configured');
            }

            $msg = $this->client->messages->create($to, $params);

            return ['ok' => true, 'sid' => $msg->sid];
        } catch (\Throwable $e) {
            Log::error('Twilio SMS failed', ['error' => $e->getMessage()]);
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }
}
