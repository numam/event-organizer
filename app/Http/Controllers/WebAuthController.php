<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class WebAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        // Store token in session for server-rendered pages to use
        session(['auth_token' => $token]);

        // Pass token to view, JavaScript will save to localStorage
        return view('auth.save-token', ['token' => $token, 'redirect' => '/dashboard']);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Try to get JWT token
        $token = auth('api')->attempt($credentials);

        if (!$token) {
            \Log::error('Login attempt failed', ['email' => $credentials['email']]);
            return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
        }

        \Log::info('Login successful, token generated', ['email' => $credentials['email']]);

        // Store token in session for server-rendered pages to use
        session(['auth_token' => $token]);

        // Pass token to view, JavaScript will save to localStorage
        return view('auth.save-token', ['token' => $token, 'redirect' => '/dashboard']);
    }

    public function dashboard()
    {
        return view('dashboard');
    }
    public function events()
    {
        return view('events.index');
    }
    public function venues()
    {
        return view('venues.index');
    }

    public function logout(Request $request)
    {
        // Clear server-side session token as well
        session()->forget('auth_token');
        return redirect('/');
    }
}
