@extends('esport.admin.layouts.app')

@section('title', 'Add Tournament - E-sport Admin')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <a href="{{ route('esport.admin.tournaments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back to Tournaments List
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Add New Tournament</h1>
        <p class="text-gray-600">Create a new competition for E-sport athletes</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl">
        <form action="{{ route('esport.admin.tournaments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tournament Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="game" class="block text-sm font-medium text-gray-700 mb-1">Game Category <span class="text-red-500">*</span></label>
                        <select id="game" name="game" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Game</option>
                            @foreach(config('esport.tournament.games') ?? config('esport.games') as $key => $label)
                                <option value="{{ $key }}" {{ old('game') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach(config('esport.tournament.statuses') ?? config('esport.tournament_statuses') as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'upcoming') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Event Date <span class="text-red-500">*</span></label>
                        <input type="date" id="date" name="date" value="{{ old('date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="time" id="time" name="time" value="{{ old('time') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="registration_deadline" class="block text-sm font-medium text-gray-700 mb-1">Registration Deadline</label>
                        <input type="date" id="registration_deadline" name="registration_deadline" value="{{ old('registration_deadline') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location / Venue</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="e.g. Online / GOR Wilis Madiun" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="prize_pool" class="block text-sm font-medium text-gray-700 mb-1">Prize Pool (Rp)</label>
                        <input type="number" id="prize_pool" name="prize_pool" value="{{ old('prize_pool') }}" min="0" step="1000" placeholder="e.g. 5000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">Max Teams / Participants</label>
                        <input type="number" id="max_participants" name="max_participants" value="{{ old('max_participants') }}" min="1" placeholder="e.g. 32" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Tournament Banner</label>
                        <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="rules" class="block text-sm font-medium text-gray-700 mb-1">Tournament Rules</label>
                    <textarea id="rules" name="rules" rows="4" placeholder="Format pertandingan, regulasi tim, dsb." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('rules') }}</textarea>
                </div>

                <div>
                    <label for="contact_info" class="block text-sm font-medium text-gray-700 mb-1">Contact Person / Info</label>
                    <input type="text" id="contact_info" name="contact_info" value="{{ old('contact_info') }}" placeholder="WhatsApp: 08123456789 (Admin)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('esport.admin.tournaments.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">Create Tournament</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
