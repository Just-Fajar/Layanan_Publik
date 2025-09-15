@extends('buku_tamu.welcome') {{-- atau layouts umummu; jika tidak ada, ganti ke layouts.app --}}
@section('content')
<div class="p-4 p-md-5 mb-4 bg-light rounded-3">
  <div class="container">
    <h2 class="fw-bold mb-2">Info Tournament Madiun Esport</h2>
    <p class="text-muted">Portal resmi Diskominfo Madiun: jadwal turnamen & berita esports.</p>
    <a href="{{ route('esport.tournaments.index') }}" class="btn btn-primary btn-sm">Lihat Tournaments</a>
  </div>
</div>

<h5 class="mb-3">Latest Tournaments</h5>
<div class="row g-3 mb-4">
  @forelse($latestTournaments as $t)
    <div class="col-md-4">
      <div class="card h-100">
        @if($t->image)<img class="card-img-top" src="{{ asset('storage/'.$t->image) }}" alt="{{ $t->title }}">@endif
        <div class="card-body">
          <h6 class="card-title mb-1">{{ $t->title }}</h6>
          <div class="small text-muted mb-2">{{ $t->game }} • {{ $t->status }}</div>
          <a href="{{ route('esport.tournaments.show',$t) }}" class="btn btn-outline-primary btn-sm">Detail</a>
        </div>
      </div>
    </div>
  @empty
    <div class="col">Belum ada tournament.</div>
  @endforelse
</div>

<h5 class="mb-3">Recent News</h5>
<div class="row g-3">
  @forelse($latestNews as $n)
    <div class="col-md-4">
      <div class="card h-100">
        @if($n->image)<img class="card-img-top" src="{{ asset('storage/'.$n->image) }}" alt="{{ $n->title }}">@endif
        <div class="card-body">
          <h6 class="card-title mb-1">{{ $n->title }}</h6>
          <div class="small text-muted mb-2">{{ $n->category }}</div>
          <a href="{{ route('esport.news.show',$n) }}" class="btn btn-outline-secondary btn-sm">Baca</a>
        </div>
      </div>
    </div>
  @empty
    <div class="col">Belum ada berita.</div>
  @endforelse
</div>
@endsection
