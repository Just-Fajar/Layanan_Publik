@extends('esport.layouts.app')
@section('content')
<div class="row g-4">
  <div class="col-md-5">
    @if($tournament->image)
      <img class="img-fluid rounded" src="{{ asset('storage/'.$tournament->image) }}" alt="{{ $tournament->title }}">
    @endif
  </div>
  <div class="col-md-7">
    <h3 class="mb-1">{{ $tournament->title }}</h3>
    <div class="text-muted small mb-3">
      {{ $tournament->game }} • {{ ucfirst($tournament->status) }}
      @if($tournament->date) • {{ \Carbon\Carbon::parse($tournament->date)->format('d M Y') }} @endif
    </div>
    <p class="mb-2"><strong>Lokasi:</strong> {{ $tournament->location ?? '-' }}</p>
    <p class="mb-2"><strong>Kontak Penyelenggara:</strong> {{ $tournament->organizer_contact ?? '-' }}</p>
    <p class="mt-3">{{ nl2br(e($tournament->description)) }}</p>
  </div>
</div>
@endsection
