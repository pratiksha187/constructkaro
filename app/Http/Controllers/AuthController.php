<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        // ✅ Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'login_as' => 'required|in:staff,vendor,customer',
        ]);

        $role = $request->login_as;

        /* ============================================================
        STAFF LOGIN
        ============================================================ */
        if ($role === 'staff') {
            $staff = DB::table('users')->where('email', $request->email)->first();

            if ($staff && Hash::check($request->password, $staff->password)) {
                switch ($staff->login_as) {
                    case 1: // Admin
                        session(['admin' => $staff]);
                        return redirect('/admin_dashboard');
                    case 2: // Engineer
                        session(['engineer' => $staff]);
                        return redirect('/engineer_dashboard');
                    case 5: // Calling Staff
                        session(['calling' => $staff]);
                        return redirect('/calling_dashboard');
                    default:
                        return back()->with('error', 'Unauthorized staff role.');
                }
            }

            return back()->with('error', 'Invalid staff credentials.');
        }

      
        if ($role === 'vendor') {
            $vendor = DB::table('service_provider')
                ->where('email', $request->email)
                ->first();

            if ($vendor && Hash::check($request->password, $vendor->password)) {
                if ($vendor->login_as == 4) {
                    session(['vendor_id' => $vendor->id]);

                    // 🔹 Step 0: If vendor has_followed = 1 → Go directly to dashboard
                    if ($vendor->has_followed == 1) {
                        return redirect()->route('vendor_dashboard')
                            ->with('success', 'Welcome back to your dashboard!');
                    }

                    // 🔹 Step 1: Check agency_services
                    $agencyExists = DB::table('agency_services')
                        ->where('user_id', $vendor->id)
                        ->exists();
                    if (!$agencyExists) {
                        return redirect()->route('types_of_agency')
                            ->with('info', 'Please complete your agency information.');
                    }

                    // 🔹 Step 2: Check business_registrations
                    $businessExists = DB::table('business_registrations')
                        ->where('user_id', $vendor->id)
                        ->exists();
                    if (!$businessExists) {
                        return redirect()->route('about_business')
                            ->with('info', 'Please complete your business registration.');
                    }

                    // 🔹 Step 3: All good → Go to vendor confirmation
                    return redirect('/vendor_confiermetion');
                }

                return back()->with('error', 'Unauthorized role for vendor login.');
            }

            return back()->with('error', 'Invalid vendor credentials.');
        }

        /* ============================================================
        CUSTOMER LOGIN
        ============================================================ */
        if ($role === 'customer') {
            // Step 1: Check if user exists in customer_basic_info
            $user = DB::table('customer_basic_info')->where('email', $request->email)->first();

            if (!$user) {
                // No record found — ask to complete basic info registration
                return redirect()->route('customer_basic_info')
                    ->with('error', 'No account found. Please register first.');
            }

            // Step 2: Verify password
            if (!Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Invalid email or password.');
            }

            // Step 3: Check if project exists for this user
            $project = DB::table('projects')
                ->where('user_id', $user->id)
                ->first();

            if (!$project) {
                // No project yet → redirect to project creation form
                session(['user' => $user]);
                return redirect()->route('project')
                    ->with('info', 'Please create your first project.');
            }

            // Step 4: Check if project details exist
            $projectDetails = DB::table('projects_details')
                ->where('project_id', $project->id)
                ->exists();

            if (!$projectDetails) {
                // No project details yet → redirect to project details form
                session(['user' => $user]);
                return redirect()->route('project_details')
                    ->with('info', 'Please complete your project details.');
            }

            // ✅ Step 5: All data exists → go to dashboard
            $totalProjects = DB::table('projects')
                ->where('user_id', $user->id)
                ->count();

            session([
                'user' => $user,
                'totalProjects' => $totalProjects,
            ]);

            return redirect()->route('customer.dashboard');
        }

        /* ============================================================
        DEFAULT FALLBACK
        ============================================================ */
        return back()->with('error', 'Invalid credentials or unauthorized user.');
    }

    // Show "Forgot Password" form
    public function forgotpass()
    {
        return view('auth.forgot-password');
    }

     // Send reset link
    // public function sendLink(Request $request)
    // {
    //     dd($request);
    //     $request->validate(['email' => 'required|email']);

    //     // check in all possible tables
    //     $tables = ['users', 'service_provider', 'customer_basic_info'];
    //     $found = null;
    //     $foundTable = null;

    //     foreach ($tables as $table) {
    //         $row = DB::table($table)->where('email', $request->email)->first();
    //         if ($row) {
    //             $found = $row;
    //             $foundTable = $table;
    //             break;
    //         }
    //     }

    //     if (!$found) {
    //         return back()->with('error', 'No account found with that email address.');
    //     }

    //     // create reset token
    //     $token = Str::random(64);
    //     DB::table('password_resets')->updateOrInsert(
    //         ['email' => $request->email],
    //         ['token' => $token, 'created_at' => now()]
    //     );

    //     // send simple mail
    //     $resetLink = url('/reset-password/' . $token);
    //     Mail::raw("Click the link to reset your password:\n\n$resetLink", function ($m) use ($request) {
    //         $m->to($request->email)->subject('ConstructKaro Password Reset');
    //     });

    //     return back()->with('success', 'Password reset link has been sent to your email.');
    // }
public function sendLink(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'login_as' => 'required|in:staff,vendor,customer'
    ]);

    // 🔹 Step 1: Decide which table to check based on login_as
    switch ($request->login_as) {
        case 'staff':
            $table = 'users';
            break;
        case 'vendor':
            $table = 'service_provider';
            break;
        case 'customer':
            $table = 'customer_basic_info';
            break;
        default:
            return back()->with('error', 'Invalid role selected.');
    }

    // 🔹 Step 2: Find user in the chosen table
    $user = DB::table($table)->where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'No account found for this email under selected role.');
    }

    // 🔹 Step 3: Generate reset token
    $token = Str::random(64);
    DB::table('password_resets')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => $token,
            'created_at' => now(),
            'role' => $request->login_as, // optional column if you want to track role
        ]
    );

    // 🔹 Step 4: Build reset link
    $resetLink = url('/reset-password/' . $token . '?role=' . $request->login_as);

    // 🔹 Step 5: Send mail
    Mail::raw("Hello,\n\nClick the link below to reset your ConstructKaro password:\n\n$resetLink\n\nIf you didn’t request this, please ignore this email.",
        function ($m) use ($request) {
            $m->to($request->email)->subject('ConstructKaro Password Reset');
        });

    return back()->with('success', 'Password reset link sent to your email.');
}

    // Show reset form
    public function resetForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    // Handle password update
    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:6|confirmed',
    //         'token' => 'required'
    //     ]);

    //     $reset = DB::table('password_resets')
    //         ->where('email', $request->email)
    //         ->where('token', $request->token)
    //         ->first();

    //     if (!$reset) {
    //         return back()->with('error', 'Invalid or expired reset token.');
    //     }

    //     // find which table user belongs to
    //     $tables = ['users', 'service_provider', 'customer_basic_info'];
    //     foreach ($tables as $table) {
    //         if (DB::table($table)->where('email', $request->email)->exists()) {
    //             DB::table($table)
    //                 ->where('email', $request->email)
    //                 ->update(['password' => Hash::make($request->password)]);
    //             break;
    //         }
    //     }

    //     DB::table('password_resets')->where('email', $request->email)->delete();

    //     return redirect()->route('login')->with('success', 'Password has been reset successfully.');
    // }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        // Find token record
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            // ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->with('error', 'Invalid or expired reset token.');
        }

        // Determine table based on role stored (if you added role column)
        $role = $reset->role ?? 'staff';
    
        $table = match ($role) {
            'staff' => 'users',
            'vendor' => 'service_provider',
            'customer' => 'customer_basic_info',
            default => 'users',
        };
    
        // Update password
        DB::table($table)->where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);
    //  dd($table);
        // Delete used token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset successfully.');
    }

    public function logout() {
        session()->forget('user');
        return redirect('/');
    }
}
