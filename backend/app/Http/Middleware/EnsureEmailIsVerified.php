<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check if user's email is verified
            if (!$user->email_verified_at || !$user->verified) {
                // Logout the user
                Auth::logout();
                
                // Redirect to login with error message
                return redirect()->route('login')
                    ->with('error', 'Please verify your email before accessing this page.');
            }
        }

        return $next($request);
    }
}