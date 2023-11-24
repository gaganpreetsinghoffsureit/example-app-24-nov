<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureApiEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        if (!Auth::user() || !@Auth::user()->email_verified_at) {
            return ResponseHelper::error(__("email-not-verified"), null, 403);
        }

        return $next($request);
    }
}
