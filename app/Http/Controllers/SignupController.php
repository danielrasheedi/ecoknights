<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_Details;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    /**
     * Display sign up form
     */
    public function getSignup()
    {
        return view('authentication.sign-up');
    }

    /**
     * Store a newly created profile in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSignup(Request $request)
    {
        $validated = $request->validate([
            'UserID' => 'required|string|max:12|unique:user_details,UserID',
            'UserEmail' => 'required|email:rfc,filter|max:255|unique:user_details,UserEmail',
            'UserPassword' => 'required|string|min:8|max:64|confirmed',
        ]);
        
        // Hash the password before storing
        $validated['UserPassword'] = Hash::make($validated['UserPassword']);
        
        // Set default role for new users
        $validated['UserRole'] = 'Volunteer';
        
        User_Details::create($validated);
        
        return redirect()->route('get-sign-up')->with('success', 'Registration successful!');
    }
}