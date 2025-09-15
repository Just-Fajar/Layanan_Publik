@extends('esport.layouts.app')
@section('content')
<h4 class="mb-3">Daftar Tournaments</h4>

<form method="GET" class="row g-2 mb-3">
  <div class="col-md-3"><input name="q" class="form-control" placeholder="Cari judul/lokasi" value="{{ $filters['q'] ?? '' }}"></div>
  <div class="col-md-3"><input name="game" class="form-control" placeholder="Game" value="{{ $filters['game'] ?? '' }}"></div>
  <div class="col-md-3">
    <select name="status" class="form-select">
      <option value="">Status</option>
      @foreach(['upcoming','ongoing','finished'] as $s)
        <option value="{{ $s }}" @selected(($filters['status']??'')===$s)>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3 d-grid"><button class="btn btn-primary">Filter</button></div>
</form>

<div class="row g-3">
  @forelse($tournaments as $t)
  <div class="col-md-4">
    <div class="card h-100">
      @if($t->image)<img class="card-img-top" src="{{ asset('storage/'.$t->image) }}" alt="{{ $t->title }}">@endif
      <div class="card-body">
        <h6 class="card-title mb-1">{{ $t->title }}</h6>
        <div class="small text-muted mb-2">{{ $t->game }} • {{ $t->status }} • {{ $t->date? \Carbon\Carbon::parse($t->date)->format('d M Y') : '-' }}</div>
        <p class="small text-muted">{{ Str::limit($t->description, 90) }}</p>
        <a href="{{ route('esport.tournaments.show',$t) }}" class="btn btn-outline-primary btn-sm">Detail</a>
      </div>
    </div>
  </div>
  @empty
  <div class="col"><em>Belum ada data.</em></div>
  @endforelse
</div>

<div class="mt-3">{{ $tournaments->links() }}</div>
@endsection
