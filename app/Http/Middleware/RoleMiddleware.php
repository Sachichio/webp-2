<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && (int) Auth::user()->role === (int) $role) {
            return $next($request);
        }

        return abort(403, 'Unauthorized action.');
    }

}
