<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login()
    {
        return view('pages.login');
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

        // Mail::send('pages.email.verify', ['token' => $user->email_verification_token], function ($message) use ($request) {
        //     $message->to($request->email);
        //     $message->subject('Verify Email Address');
        // });

        // // Store a message in the session
        // Session::flash('verification_message', 'We have emailed your verification link!');

        // Redirect to login page
        return redirect()->route('user.login');
    }

    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->firstOrFail();
        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return redirect()->route('user.login')->with('status', 'Your email has been verified!');
    }

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
        $user->password_reset_token = Str::random(60);
        $user->save();

        Mail::send('pages.email.reset', ['token' => $user->password_reset_token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return redirect()->route('user.login')->with('status', 'We have emailed your password reset link!');
    }

    public function verifyResetPassword($token)
    {
        $user = User::where('password_reset_token', $token)->firstOrFail();
        $user->password_reset_token = null;
        $user->password = Hash::make(request('password'));
        $user->save();

        return redirect()->route('user.login')->with('status', 'Your password has been reset!');
    }
}
