@extends('esport.admin.layouts.app')

@section('title', 'Registration Management - E-sport Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Registration Management</h1>
        <p class="text-gray-600">Manage tournament registrations and approvals</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('esport.admin.registrations.index') }}" 
                   class="px-6 py-4 text-sm font-medium {{ !request('status') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    All Registrations
                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ !request('status') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ $total_count }}
                    </span>
                </a>
                <a href="{{ route('esport.admin.registrations.index', ['status' => 'pending']) }}" 
                   class="px-6 py-4 text-sm font-medium {{ request('status') === 'pending' ? 'border-b-2 border-yellow-500 text-yellow-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pending
                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ request('status') === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ $pending_count }}
                    </span>
                </a>
                <a href="{{ route('esport.admin.registrations.index', ['status' => 'approved']) }}" 
                   class="px-6 py-4 text-sm font-medium {{ request('status') === 'approved' ? 'border-b-2 border-green-500 text-green-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Approved
                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ request('status') === 'approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ $approved_count }}
                    </span>
                </a>
                <a href="{{ route('esport.admin.registrations.index', ['status' => 'rejected']) }}" 
                   class="px-6 py-4 text-sm font-medium {{ request('status') === 'rejected' ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Rejected
                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ request('status') === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ $rejected_count }}
                    </span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('esport.admin.registrations.index') }}" class="flex gap-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by user, tournament, team name..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-search mr-2"></i> Search
            </button>
            @if(request('search'))
                <a href="{{ route('esport.admin.registrations.index', ['status' => request('status')]) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-times mr-2"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Registrations Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tournament</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team/ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registrations as $registration)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $registration->user->username }}</div>
                                <div class="text-sm text-gray-500">{{ $registration->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $registration->tournament->name }}</div>
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($registration->tournament->start_date)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $registration->team_name ?? '-' }}</div>
                                <div class="text-sm text-gray-500">{{ $registration->in_game_id ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($registration->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                    </span>
                                @elseif($registration->status === 'approved')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Approved
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $registration->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('esport.admin.registrations.show', $registration->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                @if(request('search'))
                                    <i class="fas fa-search text-4xl mb-4 block text-gray-300"></i>
                                    <p>No registrations found matching "{{ request('search') }}"</p>
                                @elseif(request('status'))
                                    <i class="fas fa-clipboard-list text-4xl mb-4 block text-gray-300"></i>
                                    <p>No {{ request('status') }} registrations</p>
                                @else
                                    <i class="fas fa-clipboard-list text-4xl mb-4 block text-gray-300"></i>
                                    <p>No registrations yet</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($registrations->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $registrations->appends(['status' => request('status'), 'search' => request('search')])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
