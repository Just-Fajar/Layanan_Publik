@extends('calendar.layouts.app')

@section('title', 'Login - Calendar Event')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Welcome Back</h1>
                <p class="text-gray-300">Login to Calendar Event</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg shadow-2xl p-8 border border-white border-opacity-20">
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

                <form method="POST" action="{{ route('calendar.auth.login') }}">
                    @csrf

                    <!-- Username or Email -->
                    <div class="mb-4">
                        <label for="login" class="block text-white font-medium mb-2">
                            Username or Email <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               id="login" 
                               name="login" 
                               value="{{ old('login') }}"
                               class="w-full px-4 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('login') border-red-500 @enderror" 
                               placeholder="Enter your username or email"
                               required
                               autofocus>
                        @error('login')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-white font-medium mb-2">
                            Password <span class="text-red-400">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password"
                               class="w-full px-4 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror" 
                               placeholder="Enter your password"
                               required>
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center text-white">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 text-blue-600 bg-white bg-opacity-20 border-white border-opacity-30 rounded focus:ring-blue-500">
                            <span class="ml-2">Remember me</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </button>

                    <!-- Register Link -->
                    <div class="text-center mt-6">
                        <p class="text-white">
                            Don't have an account? 
                            <a href="{{ route('calendar.auth.register') }}" class="text-blue-300 hover:text-blue-200 font-medium">
                                Register now
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('calendar.index') }}" class="text-gray-300 hover:text-white">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Events
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
