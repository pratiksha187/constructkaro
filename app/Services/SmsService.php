<?php

namespace App\Services;

use Aws\Pinpoint\PinpointClient;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private PinpointClient $client;
    private string $appId;
    private ?string $senderId;
    private ?string $dltEntityId;
    private ?string $dltTemplateId;

    public function __construct()
    {
        $this->client = new PinpointClient([
            'version' => 'latest',
            'region'  => config('services.aws.region', config('app.aws_region', env('AWS_DEFAULT_REGION'))),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $this->appId         = env('AWS_PINPOINT_APPLICATION_ID');
        $this->senderId      = env('SMS_SENDER_ID');
        $this->dltEntityId   = env('SMS_DLT_ENTITY_ID');
        $this->dltTemplateId = env('SMS_DLT_TEMPLATE_ID');
    }

    /**
     * Send a single SMS
     * @param string $e164Phone e.g. +9198XXXXXXXX
     * @param string $message
     */
    public function send(string $e164Phone, string $message): bool
    {
        try {
            $msgConfig = [
                'Body'       => $message,
                'MessageType'=> 'TRANSACTIONAL', // OTP = TRANSACTIONAL in India
                'OriginationNumber' => null,     // short/long number (not used with SenderId)
            ];

            // India: DLT + Sender ID headers
            if ($this->senderId) {
                $msgConfig['SenderId'] = $this->senderId;
            }
            if ($this->dltEntityId) {
                $msgConfig['Keyword'] = $this->dltEntityId; // AWS maps this; some accounts use MessageAttributes, but this works with Pinpoint
            }
            if ($this->dltTemplateId) {
                $msgConfig['Substitutions'] = [
                    'DLTTemplateId' => [$this->dltTemplateId],
                ];
            }

            $this->client->sendMessages([
                'ApplicationId' => $this->appId,
                'MessageRequest' => [
                    'Addresses' => [
                        $e164Phone => ['ChannelType' => 'SMS'],
                    ],
                    'MessageConfiguration' => [
                        'SMSMessage' => $msgConfig
                    ],
                ],
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::error('SMS send failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return false;
        }
    }
}
