<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropdownController extends Controller
{
    // Show the main dropdown page
    public function index()
    {
        $workTypes = DB::table('work_types')->get();
        // dd($workTypes);
        return view('dropdowns', compact('workTypes'));
    }

    // Get subtypes for a selected work type
    public function getSubtypes($workTypeId)
    {
        $subtypes = DB::table('work_subtypes')
                    ->where('work_type_id', $workTypeId)
                    ->get();
// dd($subtypes);
        return response()->json($subtypes);
    }

    // Get vendors for a selected work subtype
    public function getVendors($subtypeId)
    {
        $vendors = DB::table('suggested_vendor_types')
                    ->where('work_subtype_id', $subtypeId)
                    ->get();
// dd($vendors);
        return response()->json($vendors);
    }

    public function getVendorssubcategories($vendsubtypeId)
    {
        $vendors = DB::table('vendor_subcategories')
                    ->where('vendor_type_id', $vendsubtypeId)
                    ->get();
// dd($vendors);
        return response()->json($vendors);
    }
}
