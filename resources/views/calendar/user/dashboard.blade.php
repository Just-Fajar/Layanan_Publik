@extends('calendar.layouts.app')

@section('title', 'Dashboard - Calendar Event')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Registrations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Registrations</p>
                        <h3 class="text-3xl font-bold text-gray-800">
                            {{ auth()->user()->eventRegistrations()->count() }}
                        </h3>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Registered Events -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Registered</p>
                        <h3 class="text-3xl font-bold text-green-600">
                            {{ auth()->user()->eventRegistrations()->where('status', 'registered')->count() }}
                        </h3>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Attended Events -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Attended</p>
                        <h3 class="text-3xl font-bold text-purple-600">
                            {{ auth()->user()->eventRegistrations()->where('status', 'attended')->count() }}
                        </h3>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-full">
                        <i class="fas fa-user-check text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Event Registrations</h2>
            
            @php
                $recentRegistrations = auth()->user()->eventRegistrations()
                    ->with('event')
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp

            @if($recentRegistrations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentRegistrations as $registration)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $registration->event->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($registration->event->event_date)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $registration->event->location }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($registration->status === 'registered')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Registered
                                            </span>
                                        @elseif($registration->status === 'attended')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Attended
                                            </span>
                                        @elseif($registration->status === 'cancelled')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- View All Link -->
                <div class="mt-4 text-center">
                    <a href="{{ route('calendar.user.events.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View all registrations <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <i class="fas fa-calendar-times text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Registrations Yet</h3>
                    <p class="text-gray-500 mb-6">You haven't registered for any events yet.</p>
                    <a href="{{ route('calendar.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                        Browse Events
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <a href="{{ route('calendar.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <i class="fas fa-calendar-alt text-blue-600 text-3xl mb-3"></i>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Browse Events</h3>
                <p class="text-gray-600 text-sm">Discover upcoming events</p>
            </a>

            <a href="{{ route('calendar.user.profile.edit') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <i class="fas fa-user-edit text-green-600 text-3xl mb-3"></i>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Edit Profile</h3>
                <p class="text-gray-600 text-sm">Update your information</p>
            </a>

            <a href="{{ route('calendar.news') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <i class="fas fa-newspaper text-purple-600 text-3xl mb-3"></i>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Latest News</h3>
                <p class="text-gray-600 text-sm">Stay updated with news</p>
            </a>
        </div>
    </div>
</div>
@endsection
