<?php

namespace App\Http\Controllers\CalendarEvent\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin(): View
    {
        return view('calendar.admin.auth.login');
    }

    /**
     * Handle login.
     */
    public function login(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $remember = $request->boolean('remember');

        if (Auth::guard('calendar_admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('calendar.admin.dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::guard('calendar_admin')->user()->name . '!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Handle logout.
     */
    public function logout(): RedirectResponse
    {
        Auth::guard('calendar_admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('calendar.admin.login')
            ->with('success', 'Anda telah logout.');
    }
}
