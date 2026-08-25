<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        if ($request->is('esport/*') || $request->is('esport')) {
            return route('esport.auth.login');
        }

        if ($request->is('calendar/*') || $request->is('calendar')) {
            return route('calendar.auth.login');
        }

        if ($request->is('buku-tamu/admin/*') || $request->is('buku-tamu/admin')) {
            return route('admin.login');
        }

        return route('login');
    }
}
