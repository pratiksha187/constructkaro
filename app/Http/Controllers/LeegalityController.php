<?php

// app/Http/Controllers/LeegalityController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

use App\Models\SignPacket;

class LeegalityController extends Controller
{
    private function client(): Client
    {
        return new Client([
            'base_uri' => config('services.leegality.base_url'),
            'headers'  => [
                // Leegality commonly uses Bearer or x-api-key style; token name can vary by plan.
                'Authorization' => 'Bearer '.config('services.leegality.auth_token'),
                'Accept'        => 'application/json',
            ],
            // 'http_errors' => false,
            // 'timeout'     => 30,
            'verify'      => 'C:\xampp\php\extras\ssl\cacert.pem',
            'timeout'     => 30,
            'http_errors' => false,
            'curl'        => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                // Optional hardening if needed:
                // CURLOPT_SSL_CIPHER_LIST => 'ECDHE+AESGCM:!aNULL:!MD5',
            ],  
        ]);
    }

    public function createInviteView()
    {
        return view('leegality.new'); // simple form (see next step)
    }

    /**
     * Example: Run a Workflow (recommended) with one signer using Aadhaar eSign (OTP)
     * and optional Digital Stamping inside the same flow.
     * Adjust payload keys per your enabled Workflow.
     */
    public function createInvite(Request $request)
    {
        $data = $request->validate([
            'doc_name'     => 'required|string',
            'pdf'          => 'required|file|mimes:pdf|max:5120',
            'signer_name'  => 'required|string',
            'signer_email' => 'nullable|email',
            'signer_phone' => 'nullable|string',
        ]);

        // 1) Upload the PDF to temp and read contents
        $pdfPath = $request->file('pdf')->store('tmp');
        $pdf     = Storage::get($pdfPath);

        // 2) Create local record
        $packet = SignPacket::create([
            'doc_name'     => $data['doc_name'],
            'signer_email' => $data['signer_email'] ?? null,
            'signer_phone' => $data['signer_phone'] ?? null,
            'status'       => 'created',
        ]);

        $payload = [
            'workflowId' => 'wf_xxxxxxxxxxxxx', // your Workflow ID from Leegality
            'document'   => [
                'fileName' => $data['doc_name'].'.pdf',
                'content'  => base64_encode($pdf),
            ],
            'invitees'   => [[
                'name'   => $data['signer_name'],
                // provide at least one: email or phone (as per your config)
                'email'  => $data['signer_email'] ?? null,
                'phone'  => $data['signer_phone'] ?? null,
                'esign'  => [
                    'type' => 'AADHAAR_OTP', // or FACE_ESIGN / DSC_TOKEN based on your flow
                ],
            ]],
            // Optional: stamping inside same workflow (if enabled)
            'stamping'   => [
                'enabled' => true,      // requires configuration on your account
                'mode'    => 'BHARATSTAMP',
                // denomination/series usually configured at workflow level
            ],
            // Where Leegality redirects after signer finishes
            'redirects'  => [
                'successUrl' => route('esign.new'),       // set your thank-you page
                'failureUrl' => route('esign.new'),
            ],
            // Webhook is configured in dashboard; we still can add per-invite headers if allowed
        ];

    
        $resp = $this->client()->post('/v1/workflows/run', ['json' => $payload]);
        $json = json_decode((string) $resp->getBody(), true);

        if (($resp->getStatusCode() ?? 500) >= 300) {
            Log::error('Leegality run workflow failed', ['status' => $resp->getStatusCode(), 'body' => $json]);
            return back()->withErrors(['api' => 'Could not create eSign invite.']);
        }

        // Expect something like: { runId, packetId, inviteUrl(s) ... }
        $packet->update([
            'ext_id' => $json['runId'] ?? ($json['packetId'] ?? null),
            'status' => 'sent',
            'meta'   => $json,
        ]);

        return redirect()->route('esign.new')->with('ok', 'Invite created and sent for eSign.');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $headers = $request->headers->all();

        // Depending on your configuration you may receive a `mac` header or field.
        $mac = $request->header('X-Leegality-Mac') ?? $request->input('mac');

        if (!$mac) {
            Log::warning('Leegality webhook missing MAC');
            return response()->noContent(400);
        }

        // Verify MAC using Private Salt (dashboard → API)
        $expected = hash_hmac('sha256', $payload, config('services.leegality.private_salt'));
        if (!hash_equals($expected, (string) $mac)) {
            Log::warning('Leegality webhook MAC mismatch');
            return response()->noContent(401);
        }

        // Process event
        $event  = $request->input('event');            
        $extId  = $request->input('runId') ?? $request->input('packetId');
        $status = $request->input('status') ?? $request->input('state');

        if ($extId) {
            $packet = SignPacket::where('ext_id', $extId)->first();
            if ($packet) {
                $packet->update([
                    'status' => $status ?? ($event === 'signer.completed' ? 'signed' : $packet->status),
                    'meta'   => array_merge($packet->meta ?? [], ['last_webhook' => $request->all()]),
                ]);
            }
        }

        return response()->noContent();
    }
}

