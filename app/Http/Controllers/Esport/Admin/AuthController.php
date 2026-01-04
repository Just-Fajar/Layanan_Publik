<?php

namespace App\Http\Controllers\Esport\Admin;

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
        return view('esport.admin.auth.login');
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

        if (Auth::guard('esport_admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('esport.admin.dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::guard('esport_admin')->user()->name . '!');
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
        Auth::guard('esport_admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('esport.admin.login')
            ->with('success', 'Anda telah logout.');
    }
}
