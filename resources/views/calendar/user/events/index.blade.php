@extends('calendar.layouts.app')

@section('title', 'My Event Registrations - Calendar Event')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">My Event Registrations</h1>
            <p class="text-gray-600">View and manage your event registrations</p>
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

        <!-- Filter Tabs -->
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <a href="{{ route('calendar.user.events.index') }}" 
                       class="px-6 py-4 text-sm font-medium {{ !request('status') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        All Registrations
                        <span class="ml-2 px-2 py-1 text-xs rounded-full {{ !request('status') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ auth()->user()->eventRegistrations()->count() }}
                        </span>
                    </a>
                    <a href="{{ route('calendar.user.events.index', ['status' => 'registered']) }}" 
                       class="px-6 py-4 text-sm font-medium {{ request('status') === 'registered' ? 'border-b-2 border-green-500 text-green-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Registered
                        <span class="ml-2 px-2 py-1 text-xs rounded-full {{ request('status') === 'registered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ auth()->user()->eventRegistrations()->where('status', 'registered')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('calendar.user.events.index', ['status' => 'attended']) }}" 
                       class="px-6 py-4 text-sm font-medium {{ request('status') === 'attended' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Attended
                        <span class="ml-2 px-2 py-1 text-xs rounded-full {{ request('status') === 'attended' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ auth()->user()->eventRegistrations()->where('status', 'attended')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('calendar.user.events.index', ['status' => 'cancelled']) }}" 
                       class="px-6 py-4 text-sm font-medium {{ request('status') === 'cancelled' ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Cancelled
                        <span class="ml-2 px-2 py-1 text-xs rounded-full {{ request('status') === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ auth()->user()->eventRegistrations()->where('status', 'cancelled')->count() }}
                        </span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Registrations List -->
        @php
            $query = auth()->user()->eventRegistrations()->with('event')->latest();
            if (request('status')) {
                $query->where('status', request('status'));
            }
            $registrations = $query->paginate(10);
        @endphp

        @if($registrations->count() > 0)
            <div class="space-y-4">
                @foreach($registrations as $registration)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="md:flex">
                            <!-- Event Image -->
                            <div class="md:w-1/4">
                                @if($registration->event->image)
                                    <img src="{{ asset('storage/' . $registration->event->image) }}" 
                                         alt="{{ $registration->event->title }}"
                                         class="w-full h-48 md:h-full object-cover">
                                @else
                                    <div class="w-full h-48 md:h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-white text-6xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Event Details -->
                            <div class="md:w-3/4 p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                                            {{ $registration->event->title }}
                                        </h3>
                                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                            <span><i class="fas fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($registration->event->event_date)->format('d M Y, H:i') }}</span>
                                            <span><i class="fas fa-map-marker-alt mr-2"></i>{{ $registration->event->location }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div>
                                        @if($registration->status === 'registered')
                                            <span class="px-4 py-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Registered
                                            </span>
                                        @elseif($registration->status === 'attended')
                                            <span class="px-4 py-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <i class="fas fa-user-check mr-1"></i> Attended
                                            </span>
                                        @elseif($registration->status === 'cancelled')
                                            <span class="px-4 py-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i> Cancelled
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Registration Info -->
                                <div class="border-t pt-4 mt-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Registered on:</span>
                                            <span class="font-medium text-gray-800">{{ $registration->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                        @if($registration->qr_code)
                                            <div>
                                                <span class="text-gray-600">QR Code:</span>
                                                <a href="{{ route('calendar.user.events.show', $registration->id) }}" class="font-medium text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-qrcode mr-1"></i> View QR Code
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('calendar.events.show', $registration->event->slug) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                        <i class="fas fa-eye mr-1"></i> View Event
                                    </a>

                                    @if($registration->status === 'registered')
                                        <form method="POST" 
                                              action="{{ route('calendar.user.events.cancel', $registration->id) }}" 
                                              onsubmit="return confirm('Are you sure you want to cancel this registration?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                                <i class="fas fa-times mr-1"></i> Cancel Registration
                                            </button>
                                        </form>
                                    @endif

                                    @if($registration->qr_code)
                                        <a href="{{ route('calendar.user.events.show', $registration->id) }}" 
                                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                            <i class="fas fa-qrcode mr-1"></i> Show QR Code
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $registrations->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-calendar-times text-gray-300 text-6xl mb-4"></i>
                @if(request('status'))
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">
                        No {{ ucfirst(request('status')) }} Registrations
                    </h3>
                    <p class="text-gray-500 mb-6">
                        You don't have any {{ request('status') }} event registrations.
                    </p>
                @else
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Registrations Yet</h3>
                    <p class="text-gray-500 mb-6">You haven't registered for any events yet.</p>
                @endif
                <a href="{{ route('calendar.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition inline-block">
                    <i class="fas fa-calendar-alt mr-2"></i> Browse Events
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
