<?php

namespace App\Http\Controllers\Esport\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show registration form.
     */
    public function showRegister(): View
    {
        return view('esport.auth.register');
    }

    /**
     * Handle registration.
     */
    public function register(UserRegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        // Auto-login after registration
        Auth::login($user);

        return redirect()->route('esport.user.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}
