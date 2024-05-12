<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Reply;
use App\Models\Movies;
use App\Models\Series;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public static function dashboard()
    {
        return view('admin.dashboard');
    }

    public static function loginPage()
    {
        if (!empty(Auth::check())) {
            return redirect()->route('admin.dashboard')->with('error', 'You are already logged in');
        } else {
            return view('admin.auth.login');
        }
    }

    public static function registerPage()
    {
        return view('admin.auth.register');
    }

    public static function profile()
    {
        return view('admin.profile');
    }

    public static function showMovies()
    {
        return view('admin.movies');
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
            'admin_password' => Hash::make($request->admin_password)
        ]);

        $register_admin->save();

        if ($register_admin->save()) {

            return redirect()->route('admin.home.login')->with('success', 'Admin registered successfully');
        } else {
            return view('admin.auth.register')->with('error', 'Failed to register admin');
        }
    }

    public function login(Request $request)
    {
        $remember = $request->has('remember');

        $credentials = $request->validate([
            'admin_email' => 'required|string|email',
            'admin_password' => 'required|string'
        ]);

        if (Auth::guard('admin')->attempt(['admin_email' => $credentials['admin_email'], 'password' => $credentials['admin_password']], $remember)) {
            // Check if the authenticated user is an admin
            if (Auth::guard('admin')->user()->role == 'admin') {
                // Redirect to admin dashboard
                return redirect()->route('admin.dashboard')->with('status', 'Login successful, welcome back');
            } else {
                // Logout the user if not an admin
                Auth::guard('admin')->logout();
                return redirect()->route('admin.home.login')->with('error', 'You are not an admin!!!');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }


    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.home.login')->with('stat', 'Logout successful');
    }

    public function movies()
    {
        $allseries = Series::paginate(10);
        $allmovies = Movies::paginate(10);

        return view('admin.movies', compact('allmovies', 'allseries'));
    }

    public function displayComments()
    {
        $all_comments = Comment::paginate(10);
        $all_replies = Reply::paginate(10);

        return view('admin.components.comments', compact('all_comments', 'all_replies'));
    }

    public function reset(Request $request, $name)
    {
        $request->validate([
            'password' => 'required|string',
            'newpassword' => 'required|string|min:6',
        ]);

        $admin = Auth::guard('admin')->user();

        if (Hash::check($request->password, $admin->admin_password)) {
            $update = Admin::findOrFail($name);

            $newpassword = Hash::make($request->newpassword);

            $update->admin_password = $newpassword;
            $update->save();

            return redirect()->route('admin.dashboard')->with('success', 'Password updated');
        }
        else {
            return redirect()->route('admin.dashboard')->with('error', 'Password does not match');
        }
    }
}
