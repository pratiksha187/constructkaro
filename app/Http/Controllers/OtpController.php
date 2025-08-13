<?php
// app/Http/Controllers/OtpController.php
namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class OtpController extends Controller
{
    public function send(Request $request, SmsService $sms)
    {
        $data = $request->validate([
            'type'      => ['required', Rule::in(['phone','email'])],
            'recipient' => ['required','string','max:191'],
        ]);

        // Simple validation on frontend format (server-side fallback)
        if ($data['type'] === 'phone' && !preg_match('/^[6-9]\d{9}$/', preg_replace('/\D/','',$data['recipient']))) {
            return response()->json(['message' => 'Enter a valid Indian mobile number.'], 422);
        }
        if ($data['type'] === 'email' && !filter_var($data['recipient'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'Enter a valid email address.'], 422);
        }

        // Rate-limit: block resend within 60s for same recipient/type
        $recent = OtpCode::where('type',$data['type'])
            ->where('recipient',$data['recipient'])
            ->whereNull('consumed_at')
            ->where('created_at','>=',now()->subSeconds(60))
            ->first();
        if ($recent) {
            return response()->json(['message' => 'Please wait before requesting a new code.'], 429);
        }

        $code = (string) random_int(100000, 999999);
        $otp = OtpCode::create([
            'type'       => $data['type'],
            'recipient'  => $data['recipient'],
            'code'       => $code,
            'expires_at' => now()->addMinutes(10),
            'session_id' => $request->session()->getId(),
        ]);

        if ($data['type'] === 'email') {
            Mail::to($data['recipient'])->send(new OtpMail($code));
        } else {
            $sms->send($data['recipient'], "Your ConstructKaro code is {$code}. It expires in 10 minutes.");
        }

        return response()->json(['message' => 'Verification code sent.']);
    }

    public function verify(Request $request)
    {
        $data = $request->validate([
            'type'      => ['required', Rule::in(['phone','email'])],
            'recipient' => ['required','string','max:191'],
            'code'      => ['required','digits:6'],
        ]);

        $otp = OtpCode::where('type',$data['type'])
            ->where('recipient',$data['recipient'])
            ->where('session_id',$request->session()->getId())
            ->orderByDesc('id')
            ->first();

        if (!$otp || $otp->isExpired() || $otp->isConsumed()) {
            return response()->json(['message' => 'Code expired or not found.'], 422);
        }

        // Optional: limit attempts
        if ($otp->attempts >= 5) {
            return response()->json(['message' => 'Too many attempts. Request new code.'], 429);
        }

        $otp->increment('attempts');

        if ($otp->code !== $data['code']) {
            return response()->json(['message' => 'Invalid code.'], 422);
        }

        $otp->update(['consumed_at' => now()]);

        // Mark verified in session for your final submit check
        if ($data['type'] === 'email') {
            session(['verified_email' => $data['recipient']]);
        } else {
            session(['verified_phone' => preg_replace('/\D/','',$data['recipient'])]);
        }

        return response()->json(['message' => 'Verified successfully.']);
    }
}

