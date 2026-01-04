@extends('esport.admin.layouts.app')

@section('title', 'Admin Login - E-sport Tournament')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-block bg-blue-600 p-4 rounded-full mb-4">
                <i class="fas fa-shield-alt text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Admin Login</h1>
            <p class="text-gray-400">E-sport Tournament Management</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg shadow-2xl p-8 border border-white border-opacity-20">
            @if (session('error'))
                <div class="bg-red-600 bg-opacity-90 text-white px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-600 bg-opacity-90 text-white px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('esport.admin.auth.login') }}">
                @csrf

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-white font-medium mb-2">
                        <i class="fas fa-user mr-2"></i> Username <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           value="{{ old('username') }}"
                           class="w-full px-4 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('username') border-red-500 @enderror" 
                           placeholder="Enter admin username"
                           required
                           autofocus>
                    @error('username')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-white font-medium mb-2">
                        <i class="fas fa-lock mr-2"></i> Password <span class="text-red-400">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           class="w-full px-4 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror" 
                           placeholder="Enter admin password"
                           required>
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input type="checkbox" 
                           name="remember" 
                           id="remember"
                           class="w-4 h-4 text-blue-600 bg-white bg-opacity-20 border-white border-opacity-30 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-white text-sm">
                        Remember me
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login to Admin Panel
                </button>
            </form>

            <!-- Security Notice -->
            <div class="mt-6 p-4 bg-yellow-500 bg-opacity-20 border border-yellow-500 border-opacity-30 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
                    <div class="text-sm text-gray-200">
                        <p class="font-medium mb-1">Admin Access Only</p>
                        <p class="text-xs text-gray-300">This area is restricted to authorized administrators only. All login attempts are logged.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('esport.index') }}" class="text-gray-300 hover:text-white transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to E-sport Home
            </a>
        </div>
    </div>
</div>
@endsection
