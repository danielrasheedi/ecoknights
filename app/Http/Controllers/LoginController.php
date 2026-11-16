<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_Details;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display log in form
     */
    public function getLogin()
    {
        return view('authentication.log-in');
    }

    /**
     * Authenticate user credentials against the database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        // Validate input using Validator facade
        $v = Validator::make($request->all(), [
            'UserEmail' => ['required', 'email:rfc,filter', 'max:255'],
            'UserPassword' => ['required', 'string', 'max:64'],
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        // Find user by email
        $user = User_Details::where('UserEmail', $request->UserEmail)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->UserPassword, $user->UserPassword)) {
            return back()->with('error', 'Invalid credentials.')->withInput();
        }

        // Login successful - issue a new session ID to prevent session fixation
        $request->session()->regenerate();

        // Put minimal identity into the session
        $request->session()->put('user_id', $user->UserID);
        $request->session()->put('user_name', $user->UserFullName);
        $request->session()->put('user_role', $user->UserRole);

        // Redirect to intended URL or default home
        $intended = $request->session()->pull('intended', route('home'));
        return redirect($intended)->with('success', 'Welcome back.');
    }

    /**
     * Log out the user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogout(Request $request)
    {
        // Clear all session data
        $request->session()->flush();
        // Regenerate session ID for security
        $request->session()->regenerate(true);
        
        return redirect()->route('get-log-in')->with('success', 'You have been logged out.');
    }
}


