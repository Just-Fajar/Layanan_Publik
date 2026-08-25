<?php

namespace App\Http\Controllers\CalendarEvent\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin(): View
    {
        return view('calendar.auth.login');
    }

    /**
     * Handle login.
     */
    public function login(UserLoginRequest $request): RedirectResponse
    {
        $credentials = [
            'password' => $request->password,
        ];

        // Check if login is email or username
        $loginField = $request->input('username') ?? $request->input('login');

        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $loginField;
        } else {
            $credentials['username'] = $loginField;
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('calendar.user.dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'username' => 'Username/email atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Handle logout.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('calendar.index')
            ->with('success', 'Anda telah logout.');
    }
}
