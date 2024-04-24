<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    //
    public static function adminPage() {
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
            'admin_email' => 'required|string|email|unique:admins',
            'admin_password' => 'required|string|min:6|confirmed'
        ]);

        $register_admin = new Admin([
            'admin_name' => $request->admin_name,
            'admin_email' => $request->admin_email,
            'admin_password' => Hash::make($request->admin_password),
            'email_verified_at' => $request['email_verified_at'],
            'remember_token' => Str::random(40),
            'status' => 'Not verified'
        ]);

        $register_admin->save();

        if ($register_admin->save()) {
            Mail::to($request->admin_email)->send(new RegisterMail($register_admin));
            
            return redirect()->route('admin.home.login')->with('success', 'Admin registered successfully');
        }
        else {
            return view('admin.auth.register')->with('error', 'Failed to register admin');
        }
    }
}
