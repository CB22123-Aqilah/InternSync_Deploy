<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $userRole = session('role', 'guest'); // default to guest if not set

        if ($userRole !== $role) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
