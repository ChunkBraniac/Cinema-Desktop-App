<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Comment;
use App\Models\Movies;
use App\Models\Reply;
use App\Models\Seasons;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AdminController
 *
 * This controller handles administrative tasks for the admin panel including
 * displaying the dashboard, login, registration, profile management, movie and
 * series management, and more.
 */
class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public static function dashboard()
    {
        $total_movies = Movies::all()->count();
        $total_series = Series::all()->count();

        $movies_today = Movies::where('created_at', Carbon::now()->format('Y-m-d'))->paginate(10);

        return view('admin.dashboard', compact('total_movies', 'total_series', 'movies_today'));
    }

    /**
     * Display the login page or redirect to dashboard if already logged in.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public static function loginPage()
    {
        if (! empty(Auth::check())) {
            return redirect()->route('admin.dashboard')->with('error', 'You are already logged in');
        } else {
            return view('admin.auth.login');
        }
    }

    /**
     * Display the registration page.
     *
     * @return \Illuminate\View\View
     */
    public static function registerPage()
    {
        return view('admin.auth.register');
    }

    /**
     * Display the profile page.
     *
     * @return \Illuminate\View\View
     */
    public static function profile()
    {
        return view('admin.components.profile');
    }

    /**
     * Display the movies management page.
     *
     * @return \Illuminate\View\View
     */
    public static function showMovies()
    {
        return view('admin.components.movies');
    }

    /**
     * Handle admin registration.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|unique:admins',
            'admin_password' => 'required|string|min:6|confirmed',
        ]);

        $register_admin = new Admin([
            'admin_name' => $request->admin_name,
            'admin_email' => $request->admin_email,
            'admin_password' => Hash::make($request->admin_password),
        ]);

        $register_admin->save();

        if ($register_admin->save()) {
            return redirect()->route('admin.home.login')->with('success', 'Admin registered successfully');
        } else {
            return view('admin.auth.register')->with('error', 'Failed to register admin');
        }
    }

    /**
     * Handle admin login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $remember = $request->has('remember');

        $credentials = $request->validate([
            'admin_email' => 'required|string|email',
            'admin_password' => 'required|string',
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

    /**
     * Handle admin logout.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.home.login')->with('stat', 'Logout successful');
    }

    /**
     * Display the movies page with paginated movies and series.
     *
     * @return \Illuminate\View\View
     */
    public function movies()
    {
        $allseries = Series::paginate(10);
        $allmovies = Movies::paginate(10);

        return view('admin.components.movies', compact('allmovies', 'allseries'));
    }

    /**
     * Display the comments page with paginated comments and replies.
     *
     * @return \Illuminate\View\View
     */
    public function displayComments()
    {
        $all_comments = Comment::paginate(10);
        $all_replies = Reply::paginate(10);

        return view('admin.components.comments', compact('all_comments', 'all_replies'));
    }

    /**
     * Handle password reset for the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'newpassword' => 'required|string|min:6',
        ]);

        $admin = Auth::guard('admin')->user();

        if (Hash::check($request->password, $admin->admin_password)) {
            $update = Admin::where('admin_name', $admin->admin_name)->first();

            $newpassword = Hash::make($request->newpassword);

            $update->admin_password = $newpassword;
            $update->save();

            return redirect()->route('admin.dashboard')->with('status', 'Password updated');
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'Password does not match');
        }
    }

    /**
     * Approve all pending movies.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveMovies()
    {
        Movies::where('status', 'pending')->update(['status' => 'approved']);

        return redirect()->route('admin.dashboard')->with('status', 'Movies approved');
    }

    /**
     * Approve all pending series.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveSeries()
    {
        Series::where('status', 'pending')->update(['status' => 'approved']);

        return redirect()->route('admin.dashboard')->with('status', 'Series approved');
    }

    /**
     * Display the pending series page.
     *
     * @return \Illuminate\View\View
     */
    public function showPendingSeries()
    {
        $pending_series = Series::where('status', '=', 'pending')->paginate(10);

        return view('admin.components.pending-series', compact('pending_series'));
    }

    /**
     * Display the pending movies page.
     *
     * @return \Illuminate\View\View
     */
    public function showPendingMovies()
    {
        $pending_movies = Movies::where('status', '=', 'pending')->paginate(10);

        return view('admin.components.pending-movies', compact('pending_movies'));
    }

    /**
     * Delete a series by its ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSeries($id)
    {
        $series = Series::find($id);

        $series->delete();

        $season = Seasons::where('movieId', $series->movieId);
        $season->delete();

        return redirect()->route('admin.all')->with('status', 'Series deleted');
    }

    /**
     * Delete a movie by its ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteMovie($id)
    {
        $movie = Movies::find($id);

        $movie->delete();

        return redirect()->route('admin.all')->with('status', 'Movie deleted');
    }

    /**
     * Search for movies and series based on a query.
     *
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $search = $request->input('query');

        $movies = Movies::where('full_name', 'like', '%'.$search.'%')->paginate(10);
        $series = Series::where('full_name', 'like', '%'.$search.'%')->paginate(10);

        $merge = $movies->concat($series);

        return view('admin.components.search', compact('merge'));
    }

    /**
     * Approve a specific series by its ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve_series($id)
    {
        Series::where('status', 'pending')->where('id', $id)->update(['status' => 'approved']);

        return redirect()->route('pending.series')->with('status', 'Series approved');
    }

    /**
     * Approve a specific movie by its ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve_movies($id)
    {
        Movies::where('status', 'pending')->where('id', $id)->update(['status' => 'approved']);

        return redirect()->route('pending.movies')->with('status', 'Movie approved');
    }

    /**
     * Display the edit movie page for a specific movie by its ID.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit_movie($id)
    {
        $movie = Movies::find($id);

        return view('admin.components.edit-movies', compact('movie'));
    }

    /**
     * Display the edit series page for a specific series by its ID.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit_series($id)
    {
        $series = Series::find($id);

        return view('admin.components.edit-series', compact('series'));
    }

    /**
     * Update the details of a specific movie.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_movie(Request $request, $id)
    {
        $movie = Movies::find($id);

        $movie->full_name = $request->input('edit_name');
        $movie->imageUrl = $request->input('edit_image');
        $movie->country = $request->input('edit_country');
        $movie->plotText = $request->input('edit_plotText');
        $movie->releaseDate = $request->input('edit_releaseDate');
        $movie->runtime = $request->input('edit_runtime');
        $movie->genres = $request->input('edit_genres');
        $movie->trailer = $request->input('edit_trailer');
        $movie->download_url = $request->input('edit_download_url');

        $movie->save();

        return redirect()->route('admin.dashboard')->with('status', 'Movie updated');
    }

    /**
     * Update the details of a specific series.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_series(Request $request, $id)
    {
        $series = Series::find($id);

        $series->full_name = $request->input('edit_name');
        $series->imageUrl = $request->input('edit_image');
        $series->country = $request->input('edit_country');
        $series->plotText = $request->input('edit_plotText');
        $series->releaseDate = $request->input('edit_releaseDate');
        $series->genres = $request->input('edit_genres');
        $series->trailer = $request->input('edit_trailer');

        $series->save();

        return redirect()->route('admin.dashboard')->with('status', 'Series updated');
    }
}
