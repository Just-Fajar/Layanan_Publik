@extends('esport.admin.layouts.app')

@section('title', 'Admin Dashboard - E-sport Tournament')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600">E-sport Tournament Management Overview</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Users</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $statistics['total_users'] }}</h3>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Tournaments -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Tournaments</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $statistics['total_tournaments'] }}</h3>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-trophy text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Registrations -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Registrations</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $statistics['total_registrations'] }}</h3>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <i class="fas fa-clipboard-list text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total News -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total News</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $statistics['total_news'] }}</h3>
                </div>
                <div class="bg-orange-100 p-4 rounded-full">
                    <i class="fas fa-newspaper text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Pending -->
        <div class="bg-yellow-50 rounded-lg shadow-md p-6 border border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-800 mb-1 font-medium">Pending Registrations</p>
                    <h3 class="text-3xl font-bold text-yellow-600">{{ $statistics['pending_registrations'] }}</h3>
                </div>
                <div class="bg-yellow-200 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-green-50 rounded-lg shadow-md p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-800 mb-1 font-medium">Approved Registrations</p>
                    <h3 class="text-3xl font-bold text-green-600">{{ $statistics['approved_registrations'] }}</h3>
                </div>
                <div class="bg-green-200 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Rejected -->
        <div class="bg-red-50 rounded-lg shadow-md p-6 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-800 mb-1 font-medium">Rejected Registrations</p>
                    <h3 class="text-3xl font-bold text-red-600">{{ $statistics['rejected_registrations'] }}</h3>
                </div>
                <div class="bg-red-200 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Registrations -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Recent Registrations</h2>
                <a href="{{ route('esport.admin.registrations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($recent_registrations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tournament</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recent_registrations as $registration)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $registration->user->username }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($registration->tournament->name, 25) }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($registration->status === 'pending')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($registration->status === 'approved')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No registrations yet</p>
            @endif
        </div>

        <!-- Active Tournaments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Active Tournaments</h2>
                <a href="{{ route('esport.admin.tournaments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($active_tournaments->count() > 0)
                <div class="space-y-3">
                    @foreach($active_tournaments as $tournament)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                            <h3 class="font-semibold text-gray-800 mb-2">{{ $tournament->name }}</h3>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($tournament->start_date)->format('d M Y') }}
                                </span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $tournament->registrations_count }} registrations
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No active tournaments</p>
            @endif
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Recent Users</h2>
            <a href="{{ route('esport.admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        @if($recent_users->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach($recent_users as $user)
                    <div class="border border-gray-200 rounded-lg p-4 text-center hover:border-blue-300 transition">
                        <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-user text-blue-600 text-xl"></i>
                        </div>
                        <h4 class="font-medium text-gray-800 text-sm mb-1">{{ $user->username }}</h4>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No users yet</p>
        @endif
    </div>
</div>
@endsection
