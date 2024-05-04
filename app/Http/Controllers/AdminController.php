<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Reply;
use App\Models\Top10;
use App\Models\Movies;
use App\Models\Series;
use App\Models\Comment;
use App\Models\Popular;
use App\Models\Streaming;
use App\Mail\RegisterMail;
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
        if (!empty(Auth::check())) {
            return redirect()->route('admin.dashboard')->with('error', 'You are already logged in');
        }
        else {
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
            'email' => 'required|string|email|unique:users',
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
                Auth::logout();
                return redirect()->route('admin.home.login')->with('error', 'You are not an admin!!!');
            }
        }
        else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        Auth::logout();

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
}
