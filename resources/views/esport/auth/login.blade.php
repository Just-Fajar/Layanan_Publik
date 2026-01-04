@extends('esport.layouts.app')

@section('title', 'Login - E-sport')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-900 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Welcome Back</h1>
                <p class="text-gray-400">Login to M-GEN E-sport</p>
            </div>

            <!-- Login Card -->
            <div class="bg-gray-800 rounded-lg shadow-2xl p-8 border border-gray-700">
                @if (session('success'))
                    <div class="bg-green-600 text-white px-4 py-3 rounded mb-6">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-600 text-white px-4 py-3 rounded mb-6">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('esport.auth.login') }}">
                    @csrf

                    <!-- Username or Email -->
                    <div class="mb-4">
                        <label for="login" class="block text-gray-300 font-medium mb-2">
                            Username or Email <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="login" 
                               name="login" 
                               value="{{ old('login') }}"
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('login') border-red-500 @enderror" 
                               placeholder="Enter your username or email"
                               required
                               autofocus>
                        @error('login')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-300 font-medium mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password"
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                               placeholder="Enter your password"
                               required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center text-gray-300">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500">
                            <span class="ml-2">Remember me</span>
                        </label>
                        {{-- Uncomment if you implement password reset
                        <a href="#" class="text-blue-400 hover:text-blue-300 text-sm">
                            Forgot password?
                        </a>
                        --}}
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </button>

                    <!-- Register Link -->
                    <div class="text-center mt-6">
                        <p class="text-gray-400">
                            Don't have an account? 
                            <a href="{{ route('esport.auth.register') }}" class="text-blue-400 hover:text-blue-300 font-medium">
                                Register now
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('esport.home') }}" class="text-gray-400 hover:text-white">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
