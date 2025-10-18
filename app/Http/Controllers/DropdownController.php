<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropdownController extends Controller
{
    
    public function index()
    {
        $workTypes = DB::table('work_types')->get();

        return view('dropdowns', compact('workTypes'));
    }

    public function getSubtypes($workTypeId)
    {
        $subtypes = DB::table('work_subtypes')
                    ->where('work_type_id', $workTypeId)
                    ->get();
        return response()->json($subtypes);
    }

    public function getVendors(Request $request)
    {
        $subtypeIds = $request->subtype_ids; 
        $vendors = DB::table('suggested_vendor_types')
        ->whereIn('work_subtype_id', $subtypeIds)->get();
        return response()->json($vendors);
    }

    public function getVendors_id($subtypeId)
    {
        return response()->json(
            DB::table('suggested_vendor_types')->where('work_subtype_id', $subtypeId)->get(['id','vendor_type'])
        );
    }

    public function getVendorssubcategories($vendsubtypeId)
    {
        $vendors = DB::table('vendor_subcategories')
                    ->where('vendor_type_id', $vendsubtypeId)
                    ->get();

        return response()->json($vendors);
    }

    
}
