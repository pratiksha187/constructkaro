<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CallingController extends Controller
{
    public function calling_dashboard()
    {
        return view('calling.calling_dashboard');
    }

    public function index()
    {
        $vendors = DB::table('calling_vendor_list')->get();
        return view('calling.vendoradd', compact('vendors'));
    }

    public function store(Request $request)
    {
        $wp = $this->formatWhatsappNumber($request->wp_mobileno);

        $id = DB::table('calling_vendor_list')->insertGetId([
            'name'        => $request->name,
            'mobile'      => $request->mobile,
            'address'     => $request->address,
            'location'    => $request->location,
            'wp_mobileno' => $wp,
            'status'      => 'Pending',
        ]);

        $vendor = DB::table('calling_vendor_list')->where('id', $id)->first();
        return response()->json($vendor);
    }

    public function update(Request $request, $id)
    {
       
        $wp = $this->formatWhatsappNumber($request->wp_mobileno);

        DB::table('calling_vendor_list')
            ->where('id', $id)
            ->update([
                'remark'      => $request->remark ?? '-',
                'status'      => $request->status,
                'wp_mobileno' => $wp,
            ]);

        $vendor = DB::table('calling_vendor_list')->where('id', $id)->first();
        return response()->json($vendor);
    }

    private function formatWhatsappNumber($number)
    {
        if (!$number) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $number);

        if (strlen($digits) === 10) {
            return '+91' . $digits;
        }

        if (substr($digits, 0, 2) === '91' && strlen($digits) === 12) {
            return '+' . $digits;
        }

        return '+' . $digits;
    }
}
