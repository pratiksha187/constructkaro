<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LeegalityService
{
    private function headers()
    {
        return [
            "X-Api-Key" => env("LEEGALITY_API_KEY"),
            "Content-Type" => "application/json"
        ];
    }

    // Create simple static document using WORKFLOW
    public function createStaticDocument()
    {
        $payload = [
            "workflowId" => env("LEEGALITY_WORKFLOW_ID"),

            "data" => [
                "placeholders" => [
                    "customer_name" => "Test Customer",
                    "customer_address" => "Mumbai",
                    "customer_mobile" => "9999999999",
                    "customer_email" => "test@demo.com",

                    "vendor_name" => "Demo Vendor",
                    "vendor_address" => "Pune",
                    "vendor_mobile" => "8888888888",
                    "vendor_email" => "vendor@demo.com",

                    "project_id" => "123",
                    "project_value" => "500000",

                    "date" => now()->format('d-m-Y'),
                    "start_date" => now()->format('d-m-Y'),
                    "end_date" => now()->addMonths(1)->format('d-m-Y'),
                ]
            ],

            "invitees" => [
                [
                    "inviteeId" => 1,
                    "name" => "Test Customer",
                    "email" => "test@demo.com",
                    "phone" => "9999999999",
                    "order" => 1
                ],
                [
                    "inviteeId" => 2,
                    "name" => "ConstructKaro Authorized",
                    "email" => "agreements@constructkaro.com",
                    "phone" => "9999999999",
                    "order" => 2
                ]
            ]
        ];

        // return Http::withHeaders($this->headers())
        //     ->post(env("LEEGALITY_BASE_URL") . "/api/v3/document/create", $payload)
        //     ->json();
    //   return Http::withHeaders($this->headers())
    //             ->withOptions(['verify' => false])  // Disable SSL verify, only for local dev
    //             ->post(env("LEEGALITY_BASE_URL") . "/api/v3/document/create", $payload)
    //             ->json();
return Http::withHeaders($this->headers())
    ->withOptions([
        'curl' => [
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2, // force TLS 1.2
        ],
        'verify' => true, // keep SSL verification enabled on AWS
    ])
    ->post(env("LEEGALITY_BASE_URL") . "/api/v3/document/create", $payload)
    ->json();



    }

    // Get signing link (FOR INVITEE #1)
    public function getStaticSigningLink($documentId)
    {
        return Http::withHeaders($this->headers())
            ->get(env("LEEGALITY_BASE_URL") . "/api/v3/document/invitee/link?documentId=$documentId&inviteeId=1")
            ->json();
    }
}
