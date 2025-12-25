<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJWTFromSession
{
    public function handle(Request $request, Closure $next)
    {
        // Get JWT token from Authorization header or cookie
        $tokenFromHeader = $request->bearerToken();
        $tokenFromCookie = $request->cookie('jwt_token');
        $token = $tokenFromHeader ?? $tokenFromCookie;

        \Log::debug('VerifyJWT middleware check', [
            'path' => $request->path(),
            'has_header_token' => !empty($tokenFromHeader),
            'has_cookie_token' => !empty($tokenFromCookie),
            'token_exists' => !empty($token),
        ]);

        if (!$token) {
            \Log::warning('VerifyJWT: No token found, redirecting to login', ['path' => $request->path()]);
            return redirect('/login');
        }

        try {
            // Verify token
            $request->headers->set('Authorization', 'Bearer ' . $token);
            $user = JWTAuth::parseToken()->authenticate();
            auth('api')->setUser($user);

            \Log::debug('VerifyJWT: Token verified successfully', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            \Log::warning('VerifyJWT: Token verification failed', ['error' => $e->getMessage()]);
            return redirect('/login');
        }

        return $next($request);
    }
}
