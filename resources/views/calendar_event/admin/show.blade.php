@extends('layouts.admin')

@section('title', 'Detail Event - Admin Calendar')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-info-circle text-primary"></i> Detail Event: {{ $event->title }}</h2>
        <div>
            <a href="{{ route('calendar.admin.events.edit', $event) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('calendar.admin.events.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="row">
                @if($event->image_url)
                    <div class="col-md-4 mb-3">
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="img-fluid rounded border shadow-sm">
                    </div>
                @endif
                <div class="{{ $event->image_url ? 'col-md-8' : 'col-12' }}">
                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $event->category_label ?? $event->category }}</span>
                        {!! $event->status_badge !!}
                    </div>
                    <h4>{{ $event->title }}</h4>
                    <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $event->location ?? '-' }}</p>
                    <p><strong>Mulai:</strong> {{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '-' }}</p>
                    <p><strong>Selesai:</strong> {{ $event->end_date ? $event->end_date->format('d M Y, H:i') : '-' }}</p>
                    <hr>
                    <h6>Deskripsi:</h6>
                    <p class="text-secondary" style="white-space: pre-line;">{{ $event->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
