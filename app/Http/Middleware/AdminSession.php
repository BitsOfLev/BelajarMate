<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSession
{
    public function handle(Request $request, Closure $next)
    {
        // If this is an admin request, set admin-specific session config
        if ($request->is('admin*')) {
            config([
                'session.cookie' => 'admin_session',
                'session.table' => 'admin_sessions',
            ]);
        }

        return $next($request);
    }
}