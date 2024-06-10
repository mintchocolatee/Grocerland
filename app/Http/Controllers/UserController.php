<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login()
    {
        // Pass the authenticated user's name to the view if available
        $userName = Auth::check() ? Auth::user()->name : null;
        return view('pages.login', compact('userName'));
    }

    public function register()
    {
        return view('pages.register');
    }

    public function resetPassword()
    {
        return view('pages.reset');
    }

    public function handleRegister(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->email_verification_token = Str::random(60);
            $user->save();
    
            // Uncomment if you want to send an email verification link
            // Mail::send('pages.email.verify', ['token' => $user->email_verification_token], function ($message) use ($request) {
            //     $message->to($request->email);
            //     $message->subject('Verify Email Address');
            // });
    
            // Store a success message in the session
            Session::flash('success_message', 'Your account has been registered successfully.');
    
            // Redirect to the registration page
            return redirect()->route('user.register');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Check if the email validation failed
            if ($e->validator->errors()->has('email')) {
                Session::flash('error', 'The email has already been taken.');
            } else {
                Session::flash('error', 'There was an error with your registration. Please try again.');
            }
    
            // Redirect back with input
            return redirect()->route('user.register')->withErrors($e->validator)->withInput();
        }
    }

    // public function verifyEmail($token)
    // {
    //     $user = User::where('email_verification_token', $token)->firstOrFail();
    //     $user->email_verified_at = now();
    //     $user->email_verification_token = null;
    //     $user->save();

    //     return redirect()->route('user.login')->with('status', 'Your email has been verified!');
    // }

    public function handleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('products.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function handleResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $user->password = Hash::make(request('password'));
        $user->save();

        // Mail::send('pages.email.reset', ['token' => $user->password_reset_token], function ($message) use ($request) {
        //     $message->to($request->email);
        //     $message->subject('Reset Password Notification');
        // });
        Session::flash('success_message', 'Your password has been reset successfully.');

        return redirect()->route('user.resetPassword');
    }

    // public function verifyResetPassword($token)
    // {
    //     $user = User::where('password_reset_token', $token)->firstOrFail();
    //     $user->password_reset_token = null;
    //     $user->password = Hash::make(request('password'));
    //     $user->save();

    //     return redirect()->route('user.login')->with('status', 'Your password has been reset!');
    // }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }
}
