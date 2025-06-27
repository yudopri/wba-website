<?php

// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->user() || !auth()->user()->hasRole($role)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}


