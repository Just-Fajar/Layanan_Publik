<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show login page.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->to($this->getRedirectUrl(Auth::guard('admin')->user()));
        }

        return view('buku_tamu.admin.login');
    }

    /**
     * Handle an incoming admin login request.
     */
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'login' => ['nullable', 'string'],
            'password' => ['required', 'string'],
        ]);

        $identifier = $request->input('login') ?? $request->input('username') ?? $request->input('email');

        if (! $identifier) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username atau email wajib diisi.',
                ], 422);
            }

            return back()->withErrors(['login' => 'Username atau email wajib diisi.'])->withInput();
        }

        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $authData = [
            $field => $identifier,
            'password' => $request->input('password'),
        ];

        $remember = $request->boolean('remember');

        if (Auth::guard('admin')->attempt($authData, $remember)) {
            $request->session()->regenerate();

            $admin = Auth::guard('admin')->user();
            $redirectUrl = $this->getRedirectUrl($admin);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'data' => [
                        'redirect' => $redirectUrl,
                        'admin' => [
                            'id' => $admin->id,
                            'name' => $admin->name,
                            'email' => $admin->email,
                            'username' => $admin->username,
                            'role' => $admin->role,
                        ],
                    ],
                ]);
            }

            return redirect()->intended($redirectUrl)
                ->with('success', 'Selamat datang kembali, ' . $admin->name);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Username/email atau password salah.',
            ], 401);
        }

        return back()
            ->withInput($request->only('username', 'email', 'login', 'remember'))
            ->withErrors(['login' => 'Username/email atau password salah.']);
    }

    /**
     * Destroy an authenticated admin session.
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil.',
                'data' => [
                    'redirect' => route('admin.login'),
                ],
            ]);
        }

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Show dashboard page.
     */
    public function dashboard(): View
    {
        return view('buku_tamu.admin.dashboard');
    }

    /**
     * Show calendar page.
     */
    public function calendar(): View
    {
        return view('buku_tamu.admin.calendar');
    }

    /**
     * Determine redirect URL based on admin role.
     */
    protected function getRedirectUrl(Admin $admin): string
    {
        if ($admin->isSuperAdmin() || $admin->canAccessModule('buku_tamu')) {
            return route('admin.dashboard');
        }

        if ($admin->canAccessModule('esport')) {
            return route('esport.admin.tournaments.index');
        }

        if ($admin->canAccessModule('calendar')) {
            return route('admin.calendar');
        }

        return route('admin.dashboard');
    }
}
