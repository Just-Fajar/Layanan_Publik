@extends('calendar.layouts.app')

@section('title', 'Event Registration QR Code')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('calendar.user.events.index') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i> Back to My Registrations
            </a>
        </div>

        <div class="max-w-2xl mx-auto">
            <!-- QR Code Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Event Registration QR Code</h1>
                    <p class="text-gray-600">Show this QR code at the event entrance</p>
                </div>

                <!-- Event Info -->
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <h2 class="font-bold text-gray-800 mb-2">{{ $registration->event->title }}</h2>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div><i class="fas fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($registration->event->event_date)->format('d F Y, H:i') }}</div>
                        <div><i class="fas fa-map-marker-alt mr-2"></i>{{ $registration->event->location }}</div>
                        <div>
                            <i class="fas fa-user mr-2"></i>{{ auth()->user()->name }}
                        </div>
                    </div>
                </div>

                <!-- QR Code Display -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg p-8 mb-6">
                    <div class="flex justify-center">
                        @if($registration->qr_code)
                            <div class="bg-white p-4 rounded-lg shadow-lg">
                                {!! $registration->qr_code !!}
                            </div>
                        @else
                            <div class="text-center text-gray-500">
                                <i class="fas fa-qrcode text-6xl mb-4"></i>
                                <p>QR Code not generated yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Registration Details -->
                <div class="border-t pt-6">
                    <h3 class="font-bold text-gray-800 mb-3">Registration Details</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Registration ID:</span>
                            <span class="font-medium text-gray-800">{{ $registration->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span>
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
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Registered on:</span>
                            <span class="font-medium text-gray-800">{{ $registration->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($registration->attended_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Attended at:</span>
                                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($registration->attended_at)->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('calendar.events.show', $registration->event->slug) }}" 
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-3 rounded-lg transition">
                        <i class="fas fa-eye mr-2"></i> View Event Details
                    </a>
                    @if($registration->qr_code)
                        <button onclick="window.print()" 
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition">
                            <i class="fas fa-print mr-2"></i> Print QR Code
                        </button>
                    @endif
                </div>
            </div>

            <!-- Important Notes -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Important Notes:</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Please show this QR code at the event entrance</li>
                                <li>You can print or save a screenshot of this page</li>
                                <li>Make sure your registration status is "Registered"</li>
                                <li>Arrive early to avoid queues</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .print-area, .print-area * {
        visibility: visible;
    }
    .print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
@endsection
