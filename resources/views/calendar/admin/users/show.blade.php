@extends('calendar.admin.layouts.app')

@section('title', 'User Details - Calendar Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('calendar.admin.users.index') }}" class="text-purple-600 hover:text-purple-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to Users
        </a>
        <h1 class="text-3xl font-bold text-gray-800">User Details</h1>
        <p class="text-gray-600">View user information and activity</p>
    </div>

    <!-- User Information Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-center mb-6">
                    <div class="inline-block bg-purple-100 p-6 rounded-full mb-4">
                        <i class="fas fa-user text-purple-600 text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-600">@{{ $user->username }}</p>
                </div>

                <div class="border-t pt-4 space-y-3">
                    <div class="flex items-center text-sm">
                        <i class="fas fa-envelope text-gray-400 w-5"></i>
                        <span class="ml-3 text-gray-700">{{ $user->email }}</span>
                    </div>
                    @if($user->phone)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-phone text-gray-400 w-5"></i>
                            <span class="ml-3 text-gray-700">{{ $user->phone }}</span>
                        </div>
                    @endif
                    <div class="flex items-center text-sm">
                        <i class="fas fa-calendar text-gray-400 w-5"></i>
                        <span class="ml-3 text-gray-700">Joined {{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h3 class="font-bold text-gray-800 mb-4">Statistics</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Total Registrations</span>
                        <span class="font-bold text-gray-800">{{ $user->eventRegistrations->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Registered</span>
                        <span class="font-bold text-green-600">{{ $user->eventRegistrations->where('status', 'registered')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Attended</span>
                        <span class="font-bold text-blue-600">{{ $user->eventRegistrations->where('status', 'attended')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Cancelled</span>
                        <span class="font-bold text-red-600">{{ $user->eventRegistrations->where('status', 'cancelled')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration History -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Event Registration History</h3>
                
                @if($user->eventRegistrations->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->eventRegistrations as $registration)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $registration->event->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $registration->event->start_date ? $registration->event->start_date->format('d M Y, H:i') : '-' }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $registration->event->location }}
                                        </p>
                                    </div>
                                    @if($registration->status === 'registered')
                                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Registered</span>
                                    @elseif($registration->status === 'attended')
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Attended</span>
                                    @else
                                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">Cancelled</span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm mt-3 pt-3 border-t">
                                    <div>
                                        <span class="text-gray-600">Registered:</span>
                                        <span class="font-medium text-gray-800 ml-2">{{ $registration->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    @if($registration->attended_at)
                                        <div>
                                            <span class="text-gray-600">Attended:</span>
                                            <span class="font-medium text-gray-800 ml-2">{{ \Carbon\Carbon::parse($registration->attended_at)->format('d M Y, H:i') }}</span>
                                        </div>
                                    @endif
                                    @if($registration->qr_code)
                                        <div class="col-span-2">
                                            <span class="text-gray-600">QR Code:</span>
                                            <span class="font-medium text-green-600 ml-2"><i class="fas fa-check-circle"></i> Generated</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-4 block text-gray-300"></i>
                        <p>No event registrations yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
