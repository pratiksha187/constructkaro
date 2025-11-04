<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

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

        /* ============================================================
        VENDOR LOGIN
        ============================================================ */
        // if ($role === 'vendor') {
        //     $vendor = DB::table('service_provider')->where('email', $request->email)->first();

        //     if ($vendor && Hash::check($request->password, $vendor->password)) {
        //         if ($vendor->login_as == 4) {
        //             session(['vendor_id' => $vendor->id]);

        //             // Step 1: Check agency_services
        //             $agencyExists = DB::table('agency_services')
        //                 ->where('user_id', $vendor->id)
        //                 ->exists();
        //             if (!$agencyExists) {
        //                 return redirect()->route('types_of_agency')
        //                     ->with('info', 'Please complete your agency information.');
        //             }

        //             // Step 2: Check business_registrations
        //             $businessExists = DB::table('business_registrations')
        //                 ->where('user_id', $vendor->id)
        //                 ->exists();
        //             if (!$businessExists) {
        //                 return redirect()->route('about_business')
        //                     ->with('info', 'Please complete your business registration.');
        //             }

        //             // Step 3: All good → Go to vendor confirmation
        //             return redirect('/vendor_confiermetion');
        //         }

        //         return back()->with('error', 'Unauthorized role for vendor login.');
        //     }

        //     return back()->with('error', 'Invalid vendor credentials.');
        // }
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

    public function logout() {
        session()->forget('user');
        return redirect('/');
    }
}
