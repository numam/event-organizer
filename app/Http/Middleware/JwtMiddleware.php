<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Cek token dari session dulu
        $token = session('jwt_token');

        // Jika tidak ada di session, cek dari cookie (Authorization header)
        if (!$token) {
            $token = $request->cookie('Authorization');
            if ($token && strpos($token, 'Bearer ') === 0) {
                $token = substr($token, 7); // Hapus 'Bearer ' prefix
            }
        }

        // Debug: Log token
        Log::info('JWT Middleware - Token source:', ['from' => $token ? 'session/cookie' : 'null']);

        if (!$token) {
            return redirect()->route('login')->withErrors(['error' => 'Please login first']);
        }

        try {
            // Set token dan validasi
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate($token);

            // Debug: Log user
            Log::info('JWT Middleware - User authenticated:', ['user_id' => $user ? $user->id : 'null']);

            if (!$user) {
                session()->forget(['jwt_token', 'auth_user']);
                return redirect()->route('login')->withErrors(['error' => 'Token invalid']);
            }

            // Cek role jika diperlukan
            if ($role && $user->role !== $role) {
                Log::warning('JWT Middleware - Role mismatch:', ['required' => $role, 'actual' => $user->role]);
                return redirect()->route('welcome')->withErrors(['error' => 'Unauthorized access']);
            }

            // Refresh user di session
            session(['auth_user' => $user]);

        } catch (JWTException $e) {
            Log::error('JWT Middleware - Exception:', ['message' => $e->getMessage()]);
            session()->forget(['jwt_token', 'auth_user']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired, please login again']);
        }

        return $next($request);
    }
}
