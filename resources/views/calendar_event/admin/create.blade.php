@extends('layouts.admin')

@section('title', 'Tambah Event Baru - Admin Calendar')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-plus-circle text-primary"></i> Tambah Event Baru</h2>
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
            <form action="{{ route('calendar.admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="title" class="form-label fw-bold">Judul Event <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Sosialisasi SPBE Madiun">
                    </div>

                    <div class="col-md-4">
                        <label for="category" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="start_date" class="form-label fw-bold">Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label fw-bold">Tanggal & Waktu Selesai <span class="text-danger">*</span></label>
                        <input type="datetime-local" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    </div>

                    <div class="col-md-8">
                        <label for="location" class="form-label fw-bold">Lokasi Pelaksanaan</label>
                        <input type="text" id="location" name="location" class="form-control" value="{{ old('location') }}" placeholder="Contoh: Gedung GCIO Diskominfo">
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label fw-bold">Status Publikasi <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-bold">Deskripsi Event <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" rows="5" required placeholder="Deskripsi lengkap mengenai agenda kegiatan...">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label fw-bold">Banner / Gambar Event (Opsional)</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, WebP (Maks: 2MB)</small>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save"></i> Simpan Event
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
