<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        // ❌ Not logged in → go to app login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // ❌ Logged in but not admin → forbidden
        if (! Auth::user()->is_admin) {
            abort(403, 'Admins only.');
        }

        return $next($request);
    }
}
