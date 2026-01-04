@extends('calendar.admin.layouts.app')

@section('title', 'Registration Details - Calendar Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('calendar.admin.registrations.index') }}" class="text-purple-600 hover:text-purple-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to Registrations
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Registration Details</h1>
        <p class="text-gray-600">Review registration and mark attendance</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Event Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Event Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Event Title</p>
                        <p class="font-medium text-gray-900">{{ $registration->event->title }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Date & Time</p>
                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($registration->event->event_date)->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Location</p>
                        <p class="font-medium text-gray-900">{{ $registration->event->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Capacity</p>
                        <p class="font-medium text-gray-900">{{ $registration->event->max_participants ?? 'Unlimited' }}</p>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Participant Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Name</p>
                        <p class="font-medium text-gray-900">{{ $registration->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Username</p>
                        <p class="font-medium text-gray-900">@{{ $registration->user->username }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-medium text-gray-900">{{ $registration->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Phone</p>
                        <p class="font-medium text-gray-900">{{ $registration->user->phone ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <a href="{{ route('calendar.admin.users.show', $registration->user->id) }}" class="text-purple-600 hover:text-purple-800 text-sm">
                        <i class="fas fa-user mr-1"></i> View Full Profile
                    </a>
                </div>
            </div>

            <!-- QR Code -->
            @if($registration->qr_code)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Registration QR Code</h2>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-6 flex justify-center">
                        <div class="bg-white p-4 rounded-lg shadow-lg">
                            {!! $registration->qr_code !!}
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 text-center mt-4">
                        <i class="fas fa-info-circle mr-1"></i> Scan this QR code to mark attendance
                    </p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Registration Status</h3>
                <div class="text-center mb-4">
                    @if($registration->status === 'registered')
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-800 font-medium">
                            <i class="fas fa-check-circle mr-2"></i> Registered
                        </div>
                    @elseif($registration->status === 'attended')
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 font-medium">
                            <i class="fas fa-user-check mr-2"></i> Attended
                        </div>
                    @else
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 font-medium">
                            <i class="fas fa-times-circle mr-2"></i> Cancelled
                        </div>
                    @endif
                </div>

                <div class="space-y-2 text-sm border-t pt-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Registration ID</span>
                        <span class="font-medium text-gray-800">{{ $registration->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Registration Date</span>
                        <span class="font-medium text-gray-800">{{ $registration->created_at->format('d M Y') }}</span>
                    </div>
                    @if($registration->attended_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Attended At</span>
                            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($registration->attended_at)->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">QR Code</span>
                        <span class="font-medium {{ $registration->qr_code ? 'text-green-600' : 'text-red-600' }}">
                            {{ $registration->qr_code ? 'Generated' : 'Not Generated' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($registration->status === 'registered')
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
                    
                    <!-- Mark as Attended Button -->
                    <form method="POST" action="{{ route('calendar.admin.registrations.attend', $registration->id) }}" class="mb-3">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Mark this registration as attended?')"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition">
                            <i class="fas fa-user-check mr-2"></i> Mark as Attended
                        </button>
                    </form>

                    <p class="text-xs text-gray-500 text-center">
                        <i class="fas fa-info-circle mr-1"></i> This action marks that the participant has attended the event
                    </p>
                </div>
            @elseif($registration->status === 'attended')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="text-center">
                        <i class="fas fa-check-circle text-blue-600 text-4xl mb-3"></i>
                        <h3 class="font-bold text-blue-800 mb-2">Attendance Marked</h3>
                        <p class="text-sm text-blue-700">
                            This participant has attended the event on
                            <br>
                            <strong>{{ \Carbon\Carbon::parse($registration->attended_at)->format('d M Y, H:i') }}</strong>
                        </p>
                    </div>
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                <h3 class="font-bold text-purple-800 mb-3">Quick Info</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-purple-700">Total Registrations</span>
                        <span class="font-bold text-purple-800">{{ $registration->event->registrations->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-purple-700">Attended</span>
                        <span class="font-bold text-purple-800">{{ $registration->event->registrations->where('status', 'attended')->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-purple-700">Attendance Rate</span>
                        <span class="font-bold text-purple-800">
                            {{ $registration->event->registrations->count() > 0 
                                ? round(($registration->event->registrations->where('status', 'attended')->count() / $registration->event->registrations->count()) * 100, 1) 
                                : 0 }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
