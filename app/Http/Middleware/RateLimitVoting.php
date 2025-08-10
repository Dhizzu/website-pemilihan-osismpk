<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class RateLimitVoting
{
    public function handle(Request $request, Closure $next)
    {
        // Rate limit vote submissions
        if ($request->is('voting/store')) {
            $key = 'vote:' . $request->ip();
            
            if (RateLimiter::tooManyAttempts($key, 5)) {
                return response()->json([
                    'error' => 'Too many requests. Please try again later.'
                ], 429);
            }
            
            RateLimiter::hit($key, 60); // 1 minute window
        }

        return $next($request);
    }
}
