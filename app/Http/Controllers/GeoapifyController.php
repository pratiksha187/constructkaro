<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeoapifyController extends Controller
{
    public function getCoordinates(Request $request)
    {
        $address = $request->input('location') . ' ' . $request->input('survey_no');
        $apiKey = env('GEOAPIFY_API_KEY');

        $url = "https://api.geoapify.com/v1/geocode/search?text=" . urlencode($address) . "&apiKey=" . $apiKey;

        $response = Http::get($url)->json();

        if (!empty($response['features']) && count($response['features']) > 0) {
            $coords = $response['features'][0]['geometry']['coordinates'];
            $properties = $response['features'][0]['properties'];

            return response()->json([
                'lat' => $coords[1],
                'lng' => $coords[0],
                'formatted_address' => $properties['formatted']
            ]);
        } else {
            return response()->json(['error' => 'Location not found'], 404);
        }
    }
}
