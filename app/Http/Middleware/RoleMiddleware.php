<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        if (empty($roles)) {
            return $next($request);
        }

        // Check if user's role matches any of the allowed roles
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized access. You do not have the required permissions.');
    }
}
