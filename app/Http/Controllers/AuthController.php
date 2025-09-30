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
            'password' => 'required'
        ]);

        // 🔹 Admin / Engineer Login
        $admin = DB::table('users')->where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            if ($admin->login_as == 1) {
                session(['admin' => $admin]);
                return redirect('/admin_dashboard');
            } elseif ($admin->login_as == 2) {
                session(['engineer' => $admin]);
                return redirect('/engineer_dashboard');
            }
            return back()->with('error', 'Unauthorized role.');
        }

        // 🔹 Vendor Login
        $vendor = DB::table('service_provider')->where('email', $request->email)->first();
        if ($vendor && Hash::check($request->password, $vendor->password)) {
            if ($vendor->login_as == 4) {
                session(['vendor_id' => $vendor->id]);
                return redirect('/vendor_confiermetion');
            }
            return back()->with('error', 'Unauthorized role.');
        }

        // 🔹 Customer Login
        $user = DB::table('projects')->where('email', $request->email)->first();
        if ($user && $user->login_id == 3 && Hash::check($request->password, $user->password)) {

            $projects = DB::table('projects_details')
                            ->where('project_id', $user->id)
                            ->get();

            $totalProjects = $projects->count();

            // ✅ Store user & project info in session
            session([
                'user' => $user,
                'totalProjects' => $totalProjects
            ]);

            return redirect('/customer_dashboard');
        }

        return back()->with('error', 'Invalid credentials or unauthorized user.');
    }

     public function logout() {
        session()->forget('user');
        return redirect('/');
    }
}
