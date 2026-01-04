@extends('esport.layouts.app')

@section('title', 'Dashboard - E-sport')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-900 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-tachometer-alt mr-2"></i> My Dashboard
            </h1>
            <p class="text-gray-400">Welcome back, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Registrations -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-200 text-sm font-medium">Total Registrations</p>
                        <p class="text-white text-3xl font-bold mt-2">
                            {{ auth()->user()->tournamentRegistrations()->count() }}
                        </p>
                    </div>
                    <div class="bg-blue-500 bg-opacity-30 rounded-full p-4">
                        <i class="fas fa-gamepad text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Approved -->
            <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-200 text-sm font-medium">Approved</p>
                        <p class="text-white text-3xl font-bold mt-2">
                            {{ auth()->user()->tournamentRegistrations()->approved()->count() }}
                        </p>
                    </div>
                    <div class="bg-green-500 bg-opacity-30 rounded-full p-4">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-200 text-sm font-medium">Pending</p>
                        <p class="text-white text-3xl font-bold mt-2">
                            {{ auth()->user()->tournamentRegistrations()->pending()->count() }}
                        </p>
                    </div>
                    <div class="bg-yellow-500 bg-opacity-30 rounded-full p-4">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tournament Registrations -->
        <div class="bg-gray-800 rounded-lg shadow-lg border border-gray-700 mb-8">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold text-white">
                    <i class="fas fa-trophy mr-2"></i> Recent Tournament Registrations
                </h2>
            </div>
            <div class="p-6">
                @php
                    $registrations = auth()->user()->tournamentRegistrations()
                        ->with('tournament')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @if($registrations->count() > 0)
                    <div class="space-y-4">
                        @foreach($registrations as $registration)
                            <div class="bg-gray-700 rounded-lg p-4 hover:bg-gray-600 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-white font-bold">{{ $registration->tournament->name }}</h3>
                                        <p class="text-gray-400 text-sm mt-1">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Registered: {{ $registration->created_at->format('d M Y, H:i') }}
                                        </p>
                                        @if($registration->team_name)
                                            <p class="text-gray-400 text-sm">
                                                <i class="fas fa-users mr-1"></i>
                                                Team: {{ $registration->team_name }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        @if($registration->status === 'approved')
                                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm">
                                                <i class="fas fa-check mr-1"></i> Approved
                                            </span>
                                        @elseif($registration->status === 'pending')
                                            <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-sm">
                                                <i class="fas fa-clock mr-1"></i> Pending
                                            </span>
                                        @else
                                            <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                                                <i class="fas fa-times mr-1"></i> Rejected
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('esport.user.tournaments.index') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                            View All Registrations
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-600 text-5xl mb-4"></i>
                        <p class="text-gray-400 mb-4">You haven't registered for any tournaments yet.</p>
                        <a href="{{ route('esport.tournaments.index') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                            <i class="fas fa-gamepad mr-2"></i> Browse Tournaments
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('esport.tournaments.index') }}" 
               class="bg-gray-800 border border-gray-700 rounded-lg p-6 hover:border-blue-500 transition group">
                <i class="fas fa-trophy text-blue-500 text-3xl mb-3"></i>
                <h3 class="text-white font-bold mb-2 group-hover:text-blue-400">Browse Tournaments</h3>
                <p class="text-gray-400 text-sm">Explore available tournaments and register</p>
            </a>

            <a href="{{ route('esport.user.profile.edit') }}" 
               class="bg-gray-800 border border-gray-700 rounded-lg p-6 hover:border-green-500 transition group">
                <i class="fas fa-user-edit text-green-500 text-3xl mb-3"></i>
                <h3 class="text-white font-bold mb-2 group-hover:text-green-400">Edit Profile</h3>
                <p class="text-gray-400 text-sm">Update your personal information</p>
            </a>

            <a href="{{ route('esport.news.index') }}" 
               class="bg-gray-800 border border-gray-700 rounded-lg p-6 hover:border-yellow-500 transition group">
                <i class="fas fa-newspaper text-yellow-500 text-3xl mb-3"></i>
                <h3 class="text-white font-bold mb-2 group-hover:text-yellow-400">Latest News</h3>
                <p class="text-gray-400 text-sm">Stay updated with E-sport news</p>
            </a>
        </div>
    </div>
</div>
@endsection
