<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OTPController extends Controller
{
    // Send OTP to the user's phone number
    public function sendOtp(Request $request)
    {
        // Validate phone number
        $request->validate([
            'mobile' => 'required|regex:/^(?!0)(?!.*(\d)\1{9})[6-9]\d{9}$/'
        ]);

        $mobile = $request->input('mobile');

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in session for later verification
        Session::put('otp', $otp);
        Session::put('mobile', $mobile);

        // Send OTP via Twilio
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_PHONE_NUMBER');
        
        $client = new Client($sid, $token);

        try {
            $message = $client->messages->create(
                '+91' . $mobile, // To phone number with country code
                [
                    'from' => $from,
                    'body' => 'Your OTP is: ' . $otp
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error sending OTP: ' . $e->getMessage(),
            ]);
        }
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        // Get OTP and mobile from session
        $sessionOtp = Session::get('otp');
        $mobile = Session::get('mobile');
        $otp = $request->input('otp');

        if ($otp == $sessionOtp) {
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid OTP',
        ]);
    }

 public function sendEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $otp = rand(100000, 999999);

        // Store OTP in session (or DB if needed)
        session([
            'email_otp' => $otp,
            'email_for_otp' => $request->email
        ]);

        // Send OTP email
        Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json(['status' => 'success', 'message' => 'Email OTP sent successfully!']);
    }

    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        if ($request->otp == session('email_otp')) {
            return response()->json(['status' => 'success', 'message' => 'Email OTP verified successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid Email OTP']);
    }
}
