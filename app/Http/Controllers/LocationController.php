<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
class LocationController extends Controller {

    public function index() {
        $states = DB::table('states')->where('is_active',1)->get(); 
        return view('test', compact('states'));
    }

    // Fetch regions by state
    public function getRegions($state_id) {
        $regions = DB::table('regions')
                     ->where('states_id', $state_id)
                     ->where('is_active',1)
                     ->pluck('name', 'id');
        return response()->json($regions);
    }

    // Fetch cities by region
    public function getCities($region_id) {
        $cities = DB::table('cities')
                    ->where('regions_id', $region_id)
                    ->pluck('name', 'id');
        return response()->json($cities);
    }

    public function getCitiesByRegions(Request $request)
    {
        $cities = DB::table('cities')
            ->whereIn('regions_id', $request->region_ids)
            ->pluck('name', 'id');

        return response()->json($cities);
    }

    
}

