<?php

namespace App\Http\Controllers;

use App\Services\LeegalityService;

class LeegalityController extends Controller
{
    protected $api;

    public function __construct(LeegalityService $api)
    {
        $this->api = $api;
    }

    // MAIN STATIC FUNCTION
    public function staticTest()
    {
        // Step 1 — Create document
        $create = $this->api->createStaticDocument();

        if (!isset($create['documentId'])) {
            return response()->json([
                "error" => "Failed to create document",
                "leegality_response" => $create
            ], 400);
        }

        $docId = $create['documentId'];

        // Step 2 — Get signing link
        $signLink = $this->api->getStaticSigningLink($docId);

        return [
            "document_id" => $docId,
            "signing_link" => $signLink
        ];
    }
}
