<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Aws\Sns\SnsClient;
use App\Models\MobOtp;
use App\Services\SmsService;
use Twilio\Rest\Client;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Log;
use App\Models\EmailOtp;
use Carbon\Carbon;

use Illuminate\Support\Str;

class OtpController extends Controller
{
     private TwilioService $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }
    public function sendEmailOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $otp = rand(100000, 999999);

        // Store OTP in database
        EmailOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(5)
            ]
        );

        try {
            Mail::raw("Your OTP code is: $otp", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Your Email OTP');
            });

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $record = EmailOtp::where('email', $request->email)
                        ->where('otp', $request->otp)
                        ->where('expires_at', '>', now())
                        ->first();

        if ($record) {
            $record->delete(); // Optional: delete after successful verification
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid or expired OTP']);
    }


      public function sendOtp(Request $request)
    {
        $mobile = $request->input('phone_number');
        $otp = rand(100000, 999999); // generate 6-digit OTP

            // ✅ Correct way
        $sid   = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $from  = env('TWILIO_FROM_SMS');

        $client = new Client($sid, $token);

        // try {
            $message = $client->messages->create(
                $mobile, // receiver phone number
                [
                    'from' => '18145262956', // your Twilio number
                    'body' => "Your OTP is: $otp"
                ]
            );
 dd($message);
            // Save OTP in session (or DB for verification)
            session(['phone_otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent to ' . $mobile
            ]);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => $e->getMessage()
        //     ], 500);
        // }
    }
   
    
}
