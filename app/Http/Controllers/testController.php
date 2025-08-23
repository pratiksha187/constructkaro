<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client as Twilio;
use App\Models\OtpVerification;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class testController extends Controller
{
    /**
     * Send OTP to a mobile number via Twilio SMS.
     * Route: POST /otp/sms/send
     * Body:  { phone: "+91XXXXXXXXXX" }
     * Return: JSON {status, message}
     */
    // public function sendSmsOtp(Request $request)
    // {
    //     // 1) Validate input
    //     $data = $request->validate([
    //         'phone' => ['required', 'string', 'max:20'],
    //     ]);

    //     // Require E.164 format (+countrycode then number)
    //     if (!preg_match('/^\+\d{8,15}$/', $data['phone'])) {
    //         throw ValidationException::withMessages([
    //             'phone' => 'Phone must be in E.164 format, e.g. +9198XXXXXXXX',
    //         ]);
    //     }

    //     $phone = $data['phone'];

    //     // 2) Global rate limit (avoid abuse)
    //     $rateKey = "otp:sms:send:{$phone}";
    //     if (RateLimiter::tooManyAttempts($rateKey, 5)) {
    //         $sec = RateLimiter::availableIn($rateKey);
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => "Too many requests. Try again in {$sec}s",
    //         ], 429);
    //     }
    //     RateLimiter::hit($rateKey, 60); // decay 60s

    //     $cooldown = (int) config('otp.resend_cooldown_seconds', 45);
    //     $prev = OtpVerification::where('channel', 'sms')
    //         ->where('destination', $phone)
    //         ->whereNull('verified_at')
    //         ->latest()
    //         ->first();

    //     if ($prev && $prev->last_sent_at) {
    //         // seconds elapsed since the last send
    //         $elapsed = $prev->last_sent_at->diffInSeconds(now()); // integer
    //         $left    = max(0, $cooldown - $elapsed);              // integer seconds left

    //         if ($left > 0) {
    //             return response()->json([
    //                 'status'  => 'error',
    //                 'message' => "Please wait {$left}s before requesting another code.",
    //             ], 429);
    //         }
    //     }

    //     // 4) Generate OTP (fixed digit length)
    //     $len = (int) config('otp.length', 6);
    //     $min = (int) pow(10, $len - 1);
    //     $max = (int) pow(10, $len) - 1;
    //     $code = (string) random_int($min, $max);

    //     // 5) Persist OTP (hash for security)
    //     $row = OtpVerification::create([
    //         'channel'      => 'sms',
    //         'destination'  => $phone,
    //         'code_hash'    => Hash::make($code),
    //         'expires_at'   => now()->addMinutes((int) config('otp.expires_minutes', 10)),
    //         'last_sent_at' => now(),
    //         'session_key'  => null, // optional
    //     ]);

    //     // 6) Send SMS via Twilio
    //     try {
    //         $sid   = config('services.twilio.sid');
    //         $token = config('services.twilio.token');
    //         $from  = config('services.twilio.from_sms');

    //         if (!$sid || !$token || !$from) {
    //             throw new \RuntimeException('Twilio credentials or from number missing in config/services.php or .env');
    //         }

    //         $twilio = new Twilio($sid, $token);
    //         $message = "Your verification code is: {$code}. It expires in " . config('otp.expires_minutes', 10) . " minutes.";

    //         $twilio->messages->create($phone, [
    //             'from' => $from,
    //             'body' => $message,
    //         ]);

    //         return response()->json(['status' => 'ok', 'message' => 'OTP sent']);

    //     } catch (\Twilio\Exceptions\RestException $e) {
    //         // Helpful messages for common Twilio trial errors
    //         $msg = $e->getMessage();

    //         if (str_contains($msg, 'unverified')) {
    //             $msg = 'On Twilio trial, you can only message verified numbers. Verify this recipient in Twilio Console or upgrade & buy a number.';
    //         } elseif (str_contains($msg, "To' and 'From' number cannot be the same")) {
    //             $msg = "The 'To' and 'From' numbers cannot be the same. Use your Twilio number as From, and a different recipient as To.";
    //         } elseif (str_contains($msg, 'Invalid "To" Phone Number')) {
    //             $msg = 'Invalid phone number. Ensure it is in E.164 format (e.g., +9198XXXXXXXX).';
    //         }

    //         // Optionally mark this OTP row as expired if sending failed
    //         $row->expires_at = now(); $row->save();

    //         return response()->json(['status' => 'error', 'message' => $msg], 400);

    //     } catch (\Throwable $e) {
    //         // Generic failure
    //         $row->expires_at = now(); $row->save();

    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Failed to send OTP. ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }
 public function sendSmsOtp(Request $request)
    {
        // 1) Validate phone (E.164)
        $data = $request->validate(['phone' => ['required','string','max:20']]);
        if (!preg_match('/^\+\d{8,15}$/', $data['phone'])) {
            throw ValidationException::withMessages([
                'phone' => 'Phone must be in E.164 format, e.g. +9198XXXXXXXX',
            ]);
        }
        $phone = $data['phone'];

        // 2) Rate limit
        $rateKey = "otp:sms:send:{$phone}";
        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            $sec = RateLimiter::availableIn($rateKey);
            return response()->json(['status'=>'error','message'=>"Too many requests. Try again in {$sec}s"], 429);
        }
        RateLimiter::hit($rateKey, 60);

        // 3) Resend cooldown
        $cooldown = (int) config('otp.resend_cooldown_seconds', 45);
        $prev = OtpVerification::where('channel','sms')->where('destination',$phone)->whereNull('verified_at')->latest()->first();
        if ($prev && $prev->last_sent_at) {
            $left = max(0, $cooldown - $prev->last_sent_at->diffInSeconds(now()));
            if ($left > 0) {
                return response()->json(['status'=>'error','message'=>"Please wait {$left}s before requesting another code."], 429);
            }
        }

        // 4) OTP generate
        $len = (int) config('otp.length', 6);
        $min = (int) pow(10, $len - 1);
        $max = (int) pow(10, $len) - 1;
        $code = (string) random_int($min, $max);

        // 5) Save hashed OTP
        $row = OtpVerification::create([
            'channel'      => 'sms',
            'destination'  => $phone,
            'code_hash'    => Hash::make($code),
            'expires_at'   => now()->addMinutes((int) config('otp.expires_minutes', 10)),
            'last_sent_at' => now(),
        ]);

        // 6) Send via Twilio REST (cURL)
        try {
            $sid   = config('services.twilio.sid');        // <-- uses TWILIO_SID
            $token = config('services.twilio.token');      // <-- uses TWILIO_TOKEN
            $from  = config('services.twilio.from_sms');   // <-- uses TWILIO_FROM_SMS

            if (!$sid || !$token || !$from) {
                throw new \RuntimeException('Twilio SID/TOKEN/FROM missing. Check config/services.php and .env');
            }

            $message = "Your verification code is: {$code}. It expires in " . (int) config('otp.expires_minutes', 10) . " minutes.";
            $result = $this->twilioSendSmsCurl($sid, $token, $from, $phone, $message);

            if (!$result['ok']) {
                $row->expires_at = now(); $row->save();

                // Friendlier errors for common cases
                $friendly = $result['error'] ?? 'Failed to send OTP.';
                if (str_contains($friendly, '21608')) {
                    $friendly = 'Twilio trial: you can only message verified numbers. Verify recipient or upgrade & buy a number.';
                } elseif (str_contains($friendly, '21612') || str_contains($friendly, "To' and 'From' number cannot be the same")) {
                    $friendly = "The 'To' and 'From' numbers cannot be the same.";
                } elseif (str_contains($friendly, '21211')) {
                    $friendly = 'Invalid phone number. Use E.164 (e.g., +9198XXXXXXXX).';
                } elseif (str_contains($friendly, '21610')) {
                    $friendly = 'Recipient has replied STOP. Obtain consent or use a different number.';
                }

                return response()->json(['status'=>'error','message'=>$friendly,'twilio'=>$result['raw'] ?? null], 400);
            }

            return response()->json(['status'=>'ok','message'=>'OTP sent']);

        } catch (\Throwable $e) {
            $row->expires_at = now(); $row->save();
            return response()->json(['status'=>'error','message'=>'Failed to send OTP. '.$e->getMessage()], 500);
        }
    }

    private function twilioSendSmsCurl(string $sid, string $token, string $from, string $to, string $body): array
    {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
        $payload = http_build_query(['To'=>$to,'From'=>$from,'Body'=>$body]);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_USERPWD        => "{$sid}:{$token}",
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_TIMEOUT        => 30,
        ]);

        $resp   = curl_exec($ch);
        $errno  = curl_errno($ch);
        $error  = $errno ? curl_error($ch) : null;
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = $resp !== false ? json_decode($resp, true) : null;

        if ($errno) return ['ok'=>false,'status'=>null,'sid'=>null,'error'=>"Curl error: {$error}",'raw'=>$resp];
        if ($status >= 200 && $status < 300) {
            return ['ok'=>true,'status'=>$status,'sid'=>$decoded['sid'] ?? null,'error'=>null,'raw'=>$decoded];
        }
        $errMsg  = $decoded['message'] ?? 'Unknown Twilio error';
        $errCode = $decoded['code'] ?? '';
        return ['ok'=>false,'status'=>$status,'sid'=>null,'error'=>trim("{$errMsg} {$errCode}"),'raw'=>$decoded];
    }

    
    public function verifySmsOtp(\Illuminate\Http\Request $request)
{
    // 1) Validate input
    $data = $request->validate([
        'phone' => ['required','string','max:20','regex:/^\+\d{8,15}$/'], // E.164
        'code'  => ['required','digits:'.config('otp.length', 6)],
    ]);

    // 2) Find latest unverified OTP for this phone
    $row = OtpVerification::where('channel','sms')
        ->where('destination',$data['phone'])
        ->whereNull('verified_at')
        ->latest()
        ->first();

    if (!$row) {
        return response()->json([
            'status'  => 'error',
            'message' => 'No active OTP found. Please request a new code.',
        ], 422);
    }

    // 3) Check expiry & attempts
    if (now()->greaterThan($row->expires_at)) {
        return response()->json([
            'status'  => 'error',
            'message' => 'OTP expired. Please request a new code.',
        ], 422);
    }

    if ($row->attempts >= (int) config('otp.max_attempts', 5)) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Too many attempts. Please request a new code.',
        ], 429);
    }

    // 4) Verify code
    if (Hash::check($data['code'], $row->code_hash)) {
        $row->verified_at = now();
        $row->save();

        // (Optional) mark session flag for later use:
        // session(['otp.sms_verified:'.$data['phone'] => true]);

        return response()->json([
            'status'       => 'ok',
            'message'      => 'Phone verified',
            'verified_at'  => $row->verified_at->toIso8601String(),
        ]);
    }

    // Wrong code → count attempt
    $row->increment('attempts');

    return response()->json([
        'status'  => 'error',
        'message' => 'Incorrect code.',
    ], 422);
}

public function sendEmailOtp(\Illuminate\Http\Request $request)
{
    // 1) Validate input
    $data = $request->validate([
        'email' => ['required','string','email','max:191'],
    ]);
    $email = strtolower(trim($data['email']));

    // 2) Rate limit per destination
    $rateKey = "otp:email:send:{$email}";
    if (RateLimiter::tooManyAttempts($rateKey, 5)) {
        $sec = RateLimiter::availableIn($rateKey);
        return response()->json(['status'=>'error','message'=>"Too many requests. Try again in {$sec}s"], 429);
    }
    RateLimiter::hit($rateKey, 60); // 60s decay per hit

    // 3) Resend cooldown
    $cooldown = (int) config('otp.resend_cooldown_seconds', 45);
    $prev = OtpVerification::where('channel','email')
        ->where('destination',$email)
        ->whereNull('verified_at')
        ->latest()->first();

    if ($prev && $prev->last_sent_at) {
        $elapsed = $prev->last_sent_at->diffInSeconds(now());
        $left    = max(0, $cooldown - $elapsed);
        if ($left > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => "Please wait {$left}s before requesting another code.",
            ], 429);
        }
    }

    // 4) Generate & store OTP
    $len  = (int) config('otp.length', 6);
    $min  = (int) pow(10, $len - 1);
    $max  = (int) pow(10, $len) - 1;
    $code = (string) random_int($min, $max);

    $row = OtpVerification::create([
        'channel'      => 'email',
        'destination'  => $email,
        'code_hash'    => Hash::make($code),
        'expires_at'   => now()->addMinutes((int) config('otp.expires_minutes', 10)),
        'last_sent_at' => now(),
        'session_key'  => null,
    ]);

    // 5) Send email
    try {
        Mail::to($email)->send(new OtpMail($code));
        return response()->json(['status'=>'ok','message'=>'OTP sent to email']);
    } catch (\Throwable $e) {
        // expire this OTP on failure (optional)
        $row->expires_at = now(); $row->save();
        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to send email. '.$e->getMessage(),
        ], 500);
    }
}

public function verifyEmailOtp(\Illuminate\Http\Request $request)
{
    // 1) Validate input
    $data = $request->validate([
        'email' => ['required','string','email','max:191'],
        'code'  => ['required','digits:'.config('otp.length', 6)],
    ]);
    $email = strtolower(trim($data['email']));

    // 2) Find latest unverified OTP
    $row = OtpVerification::where('channel','email')
        ->where('destination',$email)
        ->whereNull('verified_at')
        ->latest()->first();

    if (!$row) {
        return response()->json([
            'status'=>'error',
            'message'=>'No active OTP found. Please request a new code.'
        ], 422);
    }

    // 3) Check expiry & attempts
    if (now()->greaterThan($row->expires_at)) {
        return response()->json(['status'=>'error','message'=>'OTP expired. Please request a new code.'], 422);
    }
    if ($row->attempts >= (int) config('otp.max_attempts', 5)) {
        return response()->json(['status'=>'error','message'=>'Too many attempts. Please request a new code.'], 429);
    }

    // 4) Verify
    if (Hash::check($data['code'], $row->code_hash)) {
        $row->verified_at = now();
        $row->save();

        return response()->json([
            'status'      => 'ok',
            'message'     => 'Email verified',
            'verified_at' => $row->verified_at->toIso8601String(),
        ]);
    }

    $row->increment('attempts');
    return response()->json(['status'=>'error','message'=>'Incorrect code.'], 422);
}

}
