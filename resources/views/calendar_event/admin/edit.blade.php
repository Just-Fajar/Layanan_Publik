@extends('layouts.admin')

@section('title', 'Edit Event - Admin Calendar')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-edit text-warning"></i> Edit Event: {{ $event->title }}</h2>
        <a href="{{ route('calendar.admin.events.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('calendar.admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Judul Event <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category', $event->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal & Waktu Selesai <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold">Lokasi Pelaksanaan</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Status Publikasi <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Deskripsi Event <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="5" required>{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Ganti Banner / Gambar Event</label>
                        @if($event->image_url)
                            <div class="mb-2">
                                <img src="{{ $event->image_url }}" alt="Event Banner" style="max-height: 120px;" class="rounded border">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="fas fa-save"></i> Perbarui Event
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
