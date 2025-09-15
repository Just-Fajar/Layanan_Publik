@extends('esport.layouts.app')
@section('content')
<div class="row g-4">
  <div class="col-12">
    <h3 class="mb-2">{{ $news->title }}</h3>
    <div class="text-muted small mb-3">{{ $news->category }} • {{ $news->created_at->format('d M Y') }}</div>
    @if($news->image)
      <img class="img-fluid rounded mb-3" src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}">
    @endif
    <div>{!! nl2br(e($news->content)) !!}</div>
  </div>
</div>
@endsection
