@extends('esport.admin.layouts.app')

@section('title', 'Registration Details - E-sport Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('esport.admin.registrations.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Back to Registrations
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Registration Details</h1>
        <p class="text-gray-600">Review and manage registration</p>
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
            <!-- Tournament Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tournament Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Tournament Name</p>
                        <p class="font-medium text-gray-900">{{ $registration->tournament->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Date</p>
                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($registration->tournament->start_date)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Location</p>
                        <p class="font-medium text-gray-900">{{ $registration->tournament->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Slots</p>
                        <p class="font-medium text-gray-900">{{ $registration->tournament->max_participants ?? 'Unlimited' }}</p>
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
                        <p class="font-medium text-gray-900">{{ '@' . $registration->user->username }}</p>
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
                    <a href="{{ route('esport.admin.users.show', $registration->user->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-user mr-1"></i> View Full Profile
                    </a>
                </div>
            </div>

            <!-- Registration Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Registration Details</h2>
                <div class="space-y-4">
                    @if($registration->team_name)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Team Name</p>
                            <p class="font-medium text-gray-900">{{ $registration->team_name }}</p>
                        </div>
                    @endif

                    @if($registration->team_members)
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Team Members</p>
                            <div class="bg-gray-50 rounded-lg p-4">
                                @php
                                    $members = is_array($registration->team_members) 
                                        ? $registration->team_members 
                                        : json_decode($registration->team_members, true);
                                @endphp
                                @if($members)
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($members as $member)
                                            <li class="text-gray-800">{{ $member }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500">-</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($registration->in_game_id)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">In-Game ID</p>
                            <p class="font-medium text-gray-900">{{ $registration->in_game_id }}</p>
                        </div>
                    @endif

                    @if($registration->notes)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Additional Notes</p>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-800">{{ $registration->notes }}</p>
                            </div>
                        </div>
                    @endif

                    @if($registration->rejection_reason)
                        <div>
                            <p class="text-sm text-red-600 mb-1 font-medium">Rejection Reason</p>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <p class="text-red-800">{{ $registration->rejection_reason }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Registration Status</h3>
                <div class="text-center mb-4">
                    @if($registration->status === 'pending')
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 font-medium">
                            <i class="fas fa-clock mr-2"></i> Pending Review
                        </div>
                    @elseif($registration->status === 'approved')
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-800 font-medium">
                            <i class="fas fa-check-circle mr-2"></i> Approved
                        </div>
                    @else
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 font-medium">
                            <i class="fas fa-times-circle mr-2"></i> Rejected
                        </div>
                    @endif
                </div>

                <div class="space-y-2 text-sm border-t pt-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Registration Date</span>
                        <span class="font-medium text-gray-800">{{ $registration->created_at->format('d M Y') }}</span>
                    </div>
                    @if($registration->approved_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Approved Date</span>
                            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($registration->approved_at)->format('d M Y') }}</span>
                        </div>
                    @endif
                    @if($registration->rejected_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Rejected Date</span>
                            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($registration->rejected_at)->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if($registration->status === 'pending')
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
                    
                    <!-- Approve Button -->
                    <form method="POST" action="{{ route('esport.admin.registrations.approve', $registration->id) }}" class="mb-3">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to approve this registration?')"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition">
                            <i class="fas fa-check mr-2"></i> Approve Registration
                        </button>
                    </form>

                    <!-- Reject Button -->
                    <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition">
                        <i class="fas fa-times mr-2"></i> Reject Registration
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Reject Registration</h3>
        <form method="POST" action="{{ route('esport.admin.registrations.reject', $registration->id) }}">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-gray-700 font-medium mb-2">
                    Rejection Reason <span class="text-red-500">*</span>
                </label>
                <textarea id="rejection_reason" 
                          name="rejection_reason" 
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                          placeholder="Please provide a reason for rejection..."
                          required></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition">
                    Reject
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
