@extends('esport.layouts.app')
@section('content')
<h4 class="mb-3">Berita & Pengumuman</h4>

<form method="GET" class="row g-2 mb-3">
  <div class="col-md-6"><input name="q" class="form-control" placeholder="Cari judul/konten" value="{{ $filters['q'] ?? '' }}"></div>
  <div class="col-md-4">
    <select name="category" class="form-select">
      <option value="">Semua Kategori</option>
      @foreach(['Tournament Info','Esport News','Pengumuman'] as $c)
        <option value="{{ $c }}" @selected(($filters['category']??'')===$c)>{{ $c }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2 d-grid"><button class="btn btn-secondary">Filter</button></div>
</form>

<div class="row g-3">
  @forelse($news as $n)
  <div class="col-md-4">
    <div class="card h-100">
      @if($n->image)<img class="card-img-top" src="{{ asset('storage/'.$n->image) }}" alt="{{ $n->title }}">@endif
      <div class="card-body">
        <h6 class="card-title mb-1">{{ $n->title }}</h6>
        <div class="small text-muted mb-2">{{ $n->category }}</div>
        <p class="small text-muted">{{ Str::limit(strip_tags($n->content), 100) }}</p>
        <a href="{{ route('esport.news.show',$n) }}" class="btn btn-outline-secondary btn-sm">Baca</a>
      </div>
    </div>
  </div>
  @empty
  <div class="col"><em>Belum ada berita.</em></div>
  @endforelse
</div>

<div class="mt-3">{{ $news->links() }}</div>
@endsection
