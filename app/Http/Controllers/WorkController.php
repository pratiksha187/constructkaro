<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkType;
use App\Models\WorkSubtype;
use App\Models\Vendor;

class WorkController extends Controller
{
    // Show form
    public function create()
    {
        $workTypes = WorkType::all();
        return view('work.create', compact('workTypes'));
    }

    // AJAX: Get subtypes by work type
    public function getSubtypes($typeId)
    {
        $subtypes = WorkSubtype::where('work_type_id', $typeId)->get();
        return response()->json($subtypes);
    }

    // AJAX: Get vendors by subtype
    public function getVendors($subtypeId)
    {
        $vendors = Vendor::where('work_subtype_id', $subtypeId)->get();
        
        return response()->json($vendors);
    }

}