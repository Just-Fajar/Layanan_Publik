<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.user-login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.user-register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|ends_with:@gmail.com',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            return redirect()->route('homepage')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|ends_with:@gmail.com|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('homepage')->with('success', 'Registrasi berhasil!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }
}
