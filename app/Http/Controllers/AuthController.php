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
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'login_as' => 'required|in:staff,vendor,customer'
    ]);

    $role = $request->login_as;

    /** ---------------------------------------------------
     * 🧱 STAFF LOGIN (Admin / Engineer / Calling / Others)
     * --------------------------------------------------- */
    if ($role === 'staff') {
        $admin = DB::table('users')->where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            // Role check based on login_as field in DB
            if ($admin->login_as == 1) {
                session(['admin' => $admin]);
                return redirect('/admin_dashboard');
            } elseif ($admin->login_as == 2) {
                session(['engineer' => $admin]);
                return redirect('/engineer_dashboard');
            } elseif ($admin->login_as == 5) {
                session(['calling' => $admin]);
                return redirect('/calling_dashboard');
            } else {
                return back()->with('error', 'Unauthorized staff role.');
            }
        }

        return back()->with('error', 'Invalid staff credentials.');
    }

    /** ---------------------------------------------------
     * 🧱 VENDOR LOGIN
     * --------------------------------------------------- */
    if ($role === 'vendor') {
        $vendor = DB::table('service_provider')->where('email', $request->email)->first();

        if ($vendor && Hash::check($request->password, $vendor->password)) {
            if ($vendor->login_as == 4) {
                session(['vendor_id' => $vendor->id]);

                // Step 1: Check agency_services
                $agencyExists = DB::table('agency_services')->where('user_id', $vendor->id)->exists();
                if (!$agencyExists) {
                    return redirect()->route('types_of_agency');
                }

                // Step 2: Check business_registrations
                $businessExists = DB::table('business_registrations')->where('user_id', $vendor->id)->exists();
                if (!$businessExists) {
                    return redirect()->route('about_business');
                }

                // Step 3: All good → go to vendor confirmation
                return redirect('/vendor_confiermetion');
            }

            return back()->with('error', 'Unauthorized role for vendor login.');
        }

        return back()->with('error', 'Invalid vendor credentials.');
    }

    /** ---------------------------------------------------
     * 🧱 CUSTOMER LOGIN
     * --------------------------------------------------- */
    if ($role === 'customer') {
        $user = DB::table('projects')->where('email', $request->email)->first();

        if ($user && $user->login_id == 3 && Hash::check($request->password, $user->password)) {
            $projects = DB::table('projects_details')
                        ->where('project_id', $user->id)
                        ->get();

            $totalProjects = $projects->count();

            session([
                'user' => $user,
                'totalProjects' => $totalProjects
            ]);

            return redirect('/customer_dashboard');
        }

        return back()->with('error', 'Invalid customer credentials.');
    }

    /** ---------------------------------------------------
     * ❌ DEFAULT FALLBACK
     * --------------------------------------------------- */
    return back()->with('error', 'Invalid credentials or unauthorized user.');
}

//     public function login(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//         'login_as' => 'required|in:vendor,customer'
//     ]);

//     $role = $request->login_as;

//     if ($role === 'vendor') {
//         // 🔹 Vendor Login
//         $vendor = DB::table('service_provider')->where('email', $request->email)->first();

//         if ($vendor && Hash::check($request->password, $vendor->password)) {
//             if ($vendor->login_as == 4) {
//                 session(['vendor_id' => $vendor->id]);

//                 // Step 1: Check agency_services
//                 $agencyExists = DB::table('agency_services')->where('user_id', $vendor->id)->exists();
//                 if (!$agencyExists) {
//                     return redirect()->route('types_of_agency');
//                 }

//                 // Step 2: Check business_registrations
//                 $businessExists = DB::table('business_registrations')->where('user_id', $vendor->id)->exists();
//                 if (!$businessExists) {
//                     return redirect()->route('about_business');
//                 }

//                 // Step 3: All good → go to vendor confirmation
//                 return redirect('/vendor_confiermetion');
//             }

//             return back()->with('error', 'Unauthorized role for vendor login.');
//         }

//     } elseif ($role === 'customer') {
//         // 🔹 Customer Login
//         $user = DB::table('projects')->where('email', $request->email)->first();

//         if ($user && $user->login_id == 3 && Hash::check($request->password, $user->password)) {

//             $projects = DB::table('projects_details')
//                             ->where('project_id', $user->id)
//                             ->get();

//             $totalProjects = $projects->count();

//             // ✅ Store user & project info in session
//             session([
//                 'user' => $user,
//                 'totalProjects' => $totalProjects
//             ]);

//             return redirect('/customer_dashboard');
//         }
//     }

//     // 🔹 Common Admin/Engineer/Calling Login (Optional)
//     $admin = DB::table('users')->where('email', $request->email)->first();
//     if ($admin && Hash::check($request->password, $admin->password)) {
//         if ($admin->login_as == 1) {
//             session(['admin' => $admin]);
//             return redirect('/admin_dashboard');
//         } elseif ($admin->login_as == 2) {
//             session(['engineer' => $admin]);
//             return redirect('/engineer_dashboard');
//         } elseif ($admin->login_as == 5) {
//             session(['calling' => $admin]);
//             return redirect('/calling_dashboard');
//         }
//     }

//     return back()->with('error', 'Invalid credentials or unauthorized user.');
// }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     // 🔹 Admin / Engineer Login
    //     $admin = DB::table('users')->where('email', $request->email)->first();
    //     if ($admin && Hash::check($request->password, $admin->password)) {
    //         if ($admin->login_as == 1) {
    //             session(['admin' => $admin]);
    //             return redirect('/admin_dashboard');
    //         } elseif ($admin->login_as == 2) {
    //             session(['engineer' => $admin]);
    //             return redirect('/engineer_dashboard');
    //         } elseif ($admin->login_as == 5) {
    //             session(['calling' => $admin]);
    //             return redirect('/calling_dashboard');
    //         }
    //         return back()->with('error', 'Unauthorized role.');
    //     }

       
    //     $vendor = DB::table('service_provider')->where('email', $request->email)->first();

    //     if ($vendor && Hash::check($request->password, $vendor->password)) {

    //         if ($vendor->login_as == 4) {
    //             session(['vendor_id' => $vendor->id]);

    //             // Step 1: Check agency_services
    //             $agencyExists = DB::table('agency_services')->where('user_id', $vendor->id)->exists();
    //             if (!$agencyExists) {
    //                 return redirect()->route('types_of_agency');
    //             }

    //             // Step 2: Check business_registrations
    //             $businessExists = DB::table('business_registrations')->where('user_id', $vendor->id)->exists();
    //             if (!$businessExists) {
    //                 return redirect()->route('about_business');
    //             }

                
    //             // Step 3: All good → go to vendor confirmation
    //             return redirect('/vendor_confiermetion');
    //         }

    //         return back()->with('error', 'Unauthorized role.');
    //     }


    //     // 🔹 Customer Login
    //     $user = DB::table('projects')->where('email', $request->email)->first();
    //     if ($user && $user->login_id == 3 && Hash::check($request->password, $user->password)) {

    //         $projects = DB::table('projects_details')
    //                         ->where('project_id', $user->id)
    //                         ->get();

    //         $totalProjects = $projects->count();

    //         // ✅ Store user & project info in session
    //         session([
    //             'user' => $user,
    //             'totalProjects' => $totalProjects
    //         ]);

    //         return redirect('/customer_dashboard');
    //     }


        

    //     return back()->with('error', 'Invalid credentials or unauthorized user.');
    // }

     public function logout() {
        session()->forget('user');
        return redirect('/');
    }
}
