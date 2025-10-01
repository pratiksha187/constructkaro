<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class CallingController extends Controller
{
    public function calling_dashboard(){
        return view('calling.calling_dashboard');
        
    }

//    public function index(){

//         return view('calling.vendoradd');
         
//     }

    public function index()
    {
        $vendors = DB::table('calling_vendor_list')->get();
        return view('calling.vendoradd', compact('vendors'));
    }

    public function store(Request $request)
    {
        $id = DB::table('calling_vendor_list')->insertGetId([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'location' => $request->location,
            // 'remark' => '-',
            // 'status' => 'Active',
        ]);

        $vendor = DB::table('calling_vendor_list')->where('id', $id)->first();
        return response()->json($vendor);
    }

    public function update(Request $request, $id)
    {
        DB::table('calling_vendor_list')
            ->where('id', $id)
            ->update([
                'remark' => $request->remark ?? '-',
                'status' => $request->status,
            ]);

        $vendor = DB::table('calling_vendor_list')->where('id', $id)->first();
        return response()->json($vendor);
    }
}