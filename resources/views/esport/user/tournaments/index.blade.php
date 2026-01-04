@extends('esport.layouts.app')

@section('title', 'My Tournaments - E-sport')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-900 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-trophy mr-2"></i> My Tournament Registrations
            </h1>
            <p class="text-gray-400">Manage your tournament registrations and view status</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('esport.user.tournaments.index') }}" 
               class="px-6 py-2 rounded-lg {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }} transition">
                All Registrations
            </a>
            <a href="{{ route('esport.user.tournaments.index', ['status' => 'pending']) }}" 
               class="px-6 py-2 rounded-lg {{ request('status') === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }} transition">
                <i class="fas fa-clock mr-1"></i> Pending
            </a>
            <a href="{{ route('esport.user.tournaments.index', ['status' => 'approved']) }}" 
               class="px-6 py-2 rounded-lg {{ request('status') === 'approved' ? 'bg-green-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }} transition">
                <i class="fas fa-check mr-1"></i> Approved
            </a>
            <a href="{{ route('esport.user.tournaments.index', ['status' => 'rejected']) }}" 
               class="px-6 py-2 rounded-lg {{ request('status') === 'rejected' ? 'bg-red-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' }} transition">
                <i class="fas fa-times mr-1"></i> Rejected
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-600 text-white px-6 py-4 rounded-lg mb-6">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-600 text-white px-6 py-4 rounded-lg mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @php
            $query = auth()->user()->tournamentRegistrations()->with('tournament');
            if (request('status')) {
                $query->where('status', request('status'));
            }
            $registrations = $query->latest()->paginate(10);
        @endphp

        @if($registrations->count() > 0)
            <!-- Registrations List -->
            <div class="space-y-4">
                @foreach($registrations as $registration)
                    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden hover:border-blue-500 transition">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <!-- Tournament Info -->
                                <div class="flex-1">
                                    <div class="flex items-start gap-4">
                                        @if($registration->tournament->image)
                                            <img src="{{ asset('storage/' . $registration->tournament->image) }}" 
                                                 alt="{{ $registration->tournament->name }}"
                                                 class="w-20 h-20 rounded-lg object-cover">
                                        @endif
                                        <div>
                                            <h3 class="text-xl font-bold text-white mb-2">
                                                {{ $registration->tournament->name }}
                                            </h3>
                                            <div class="space-y-1 text-sm text-gray-400">
                                                <p>
                                                    <i class="fas fa-calendar-alt mr-2"></i>
                                                    Registered: {{ $registration->created_at->format('d M Y, H:i') }}
                                                </p>
                                                @if($registration->team_name)
                                                    <p>
                                                        <i class="fas fa-users mr-2"></i>
                                                        Team: <span class="text-white">{{ $registration->team_name }}</span>
                                                    </p>
                                                @endif
                                                @if($registration->in_game_id)
                                                    <p>
                                                        <i class="fas fa-gamepad mr-2"></i>
                                                        In-Game ID: <span class="text-white">{{ $registration->in_game_id }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status & Actions -->
                                <div class="flex flex-col items-end gap-3">
                                    <!-- Status Badge -->
                                    @if($registration->status === 'approved')
                                        <span class="bg-green-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                                            <i class="fas fa-check mr-1"></i> Approved
                                        </span>
                                    @elseif($registration->status === 'pending')
                                        <span class="bg-yellow-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </span>
                                    @else
                                        <span class="bg-red-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                                            <i class="fas fa-times mr-1"></i> Rejected
                                        </span>
                                    @endif

                                    <!-- Actions -->
                                    @if($registration->status === 'pending')
                                        <form method="POST" action="{{ route('esport.user.tournaments.cancel', $registration->id) }}" 
                                              onsubmit="return confirm('Are you sure you want to cancel this registration?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                                <i class="fas fa-times mr-1"></i> Cancel Registration
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Rejection Reason -->
                            @if($registration->status === 'rejected' && $registration->rejection_reason)
                                <div class="mt-4 p-4 bg-red-900 bg-opacity-30 border border-red-600 rounded-lg">
                                    <p class="text-red-400 text-sm">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong>Rejection Reason:</strong> {{ $registration->rejection_reason }}
                                    </p>
                                </div>
                            @endif

                            <!-- Notes -->
                            @if($registration->notes)
                                <div class="mt-4 p-4 bg-gray-700 rounded-lg">
                                    <p class="text-gray-300 text-sm">
                                        <i class="fas fa-sticky-note mr-2"></i>
                                        <strong>Notes:</strong> {{ $registration->notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $registrations->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-12 text-center">
                <i class="fas fa-inbox text-gray-600 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-white mb-2">No Registrations Found</h3>
                <p class="text-gray-400 mb-6">
                    @if(request('status'))
                        You don't have any {{ request('status') }} registrations yet.
                    @else
                        You haven't registered for any tournaments yet.
                    @endif
                </p>
                <a href="{{ route('esport.tournaments.index') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition">
                    <i class="fas fa-trophy mr-2"></i> Browse Tournaments
                </a>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('esport.user.dashboard') }}" 
               class="inline-block text-gray-400 hover:text-white">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
