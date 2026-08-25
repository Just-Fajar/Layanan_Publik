<?php

namespace App\Http\Controllers\Esport\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin(): View
    {
        return view('esport.auth.login');
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

            if ($remember) {
                Cookie::queue('remember_web_' . sha1(User::class), Auth::user()->getRememberToken(), 60 * 24 * 365);
            }

            return redirect()->intended(route('esport.user.dashboard'))
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

        return redirect()->route('esport.home')
            ->with('success', 'Anda telah logout.');
    }
}
