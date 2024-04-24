<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Mail\RegisterMail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    //
    public static function dashboard() {
        return view('admin.dashboard');
    }

    public static function loginPage()
    {
        return view('admin.auth.login');
    }

    public static function registerPage()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admins',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $register_admin = new User([
            'admin_name' => $request->admin_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $register_admin->save();

        if ($register_admin->save()) {
            
            return redirect()->route('admin.home.login')->with('success', 'Admin registered successfully');
        }
        else {
            return view('admin.auth.register')->with('error', 'Failed to register admin');
        }
    }

    public function login(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            // log the admin in
            if (Auth::user()->isAdmin == 1) {
                return redirect()->route('admin.dashboard')->with('status', 'Login successful, welcome back');
            }
            else {
                return redirect()->back()->with('error', 'You are not an admin!!!');
            }
        }
        else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.home.login');
    }
}
