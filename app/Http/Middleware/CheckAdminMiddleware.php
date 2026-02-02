<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !empty($request->user()->bgaUser->is_admin)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You are not authorized to access this page.');
    }
}
