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

    public function index()
    {
        $vendors = DB::table('calling_vendor_list')->get();
        return view('calling.vendoradd', compact('vendors'));
    }

    public function store(Request $request)
    {
        // format WhatsApp number
        $wp = $this->formatWhatsappNumber($request->wp_mobileno);

        $id = DB::table('calling_vendor_list')->insertGetId([
            'name'      => $request->name,
            'mobile'    => $request->mobile,
            'address'   => $request->address,
            'location'  => $request->location,
            'wp_mobileno' => $wp,
        ]);

        $vendor = DB::table('calling_vendor_list')->where('id', $id)->first();
        return response()->json($vendor);
    }

    public function update(Request $request, $id)
    {
        // format WhatsApp number
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

    /**
     * Format WhatsApp number:
     * - keep only digits
     * - prepend +91 if only 10 digits are given
     * - if already has +91, keep as it is
     */
    private function formatWhatsappNumber($number)
    {
        if (!$number) {
            return null;
        }

        // keep only digits
        $digits = preg_replace('/\D/', '', $number);

        // if user entered 10 digits, add +91
        if (strlen($digits) === 10) {
            return '+91'.$digits;
        }

        // if user already typed with country code
        if (substr($digits, 0, 2) === '91' && strlen($digits) === 12) {
            return '+'.$digits;
        }

        // fallback → just return with +
        return '+'.$digits;
    }
}

    // public function calling_dashboard(){
    //     return view('calling.calling_dashboard');
        
    // }

//    public function index(){

//         return view('calling.vendoradd');
         
//     }

    // public function index()
    // {
    //     $vendors = DB::table('calling_vendor_list')->get();
    //     return view('calling.vendoradd', compact('vendors'));
    // }

    // public function store(Request $request)
    // {
        
    //     $id = DB::table('calling_vendor_list')->insertGetId([
    //         'name' => $request->name,
    //         'mobile' => $request->mobile,
    //         'address' => $request->address,
    //         'location' => $request->location,
    //         'wp_mobileno' =>$request->wp_mobileno,
    //         // 'remark' => '-',
    //         // 'status' => 'Active',
    //     ]);

    //     $vendor = DB::table('calling_vendor_list')->where('id', $id)->first();
    //     return response()->json($vendor);
    // }

    // public function update(Request $request, $id)
    // {
    //     DB::table('calling_vendor_list')
    //         ->where('id', $id)
    //         ->update([
    //             'remark' => $request->remark ?? '-',
    //             'status' => $request->status,
    //             'wp_mobileno' =>$request->wp_mobileno,
    //         ]);

    //     $vendor = DB::table('calling_vendor_list')->where('id', $id)->first();
    //     return response()->json($vendor);
    // }
