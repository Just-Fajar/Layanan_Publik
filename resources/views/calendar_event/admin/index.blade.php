@extends('layouts.admin')

@section('title', 'Kelola Events - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-calendar-alt"></i> Kelola Events</h2>
            <p class="text-muted">Manajemen event dan kegiatan</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('calendar.admin.events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Event
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('calendar.admin.events.index') }}" class="row g-3">
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari event..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Events Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Event</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>
                                    <input type="checkbox" class="event-checkbox" value="{{ $event->id }}">
                                </td>
                                <td>
                                    <strong>{{ $event->title }}</strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> {{ $event->location ?? '-' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $categories[$event->category] ?? $event->category }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        {{ $event->start_date->format('d M Y, H:i') }}<br>
                                        s/d {{ $event->end_date->format('d M Y, H:i') }}
                                    </small>
                                </td>
                                <td>{!! $event->status_badge !!}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('calendar.admin.events.edit', $event) }}" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('calendar.admin.events.destroy', $event) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada event</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $events->links() }}
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card mt-3">
        <div class="card-body">
            <form method="POST" action="{{ route('calendar.admin.events.bulk') }}" id="bulkForm">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <select name="action" class="form-select" required>
                            <option value="">Pilih Aksi</option>
                            <option value="publish">Publish</option>
                            <option value="draft">Jadikan Draft</option>
                            <option value="delete">Hapus</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary" id="bulkActionBtn" disabled>
                            <i class="fas fa-tasks"></i> Jalankan Aksi
                        </button>
                        <span id="selectedCount" class="text-muted ms-2"></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Bulk selection
    const selectAllCheckbox = document.getElementById('selectAll');
    const eventCheckboxes = document.querySelectorAll('.event-checkbox');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const selectedCount = document.getElementById('selectedCount');
    const bulkForm = document.getElementById('bulkForm');

    selectAllCheckbox.addEventListener('change', function() {
        eventCheckboxes.forEach(cb => cb.checked = this.checked);
        updateBulkAction();
    });

    eventCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkAction);
    });

    function updateBulkAction() {
        const checked = Array.from(eventCheckboxes).filter(cb => cb.checked);
        bulkActionBtn.disabled = checked.length === 0;
        selectedCount.textContent = checked.length > 0 ? `${checked.length} dipilih` : '';
    }

    bulkForm.addEventListener('submit', function(e) {
        const checked = Array.from(eventCheckboxes).filter(cb => cb.checked);
        if (checked.length === 0) {
            e.preventDefault();
            alert('Pilih minimal satu event');
            return;
        }

        // Add hidden inputs for selected IDs
        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'event_ids[]';
            input.value = cb.value;
            bulkForm.appendChild(input);
        });

        const action = bulkForm.querySelector('select[name="action"]').value;
        if (action === 'delete') {
            return confirm(`Yakin ingin menghapus ${checked.length} event?`);
        }
    });
</script>
@endpush
@endsection
