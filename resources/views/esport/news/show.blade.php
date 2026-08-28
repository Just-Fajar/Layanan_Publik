@extends('esport.layouts.app')

@section('title', $news->title . ' - M-GEN Esport')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('esport.news.index') }}" class="inline-flex items-center gap-2 text-sm font-heading font-semibold text-slate-400 hover:text-brand-purple transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Berita</span>
        </a>
    </div>

    <article class="gaming-card rounded-3xl overflow-hidden shadow-2xl p-6 sm:p-10">
        <!-- Badges & Meta -->
        <div class="flex items-center gap-3 mb-4">
            <span class="px-3 py-1 rounded-lg text-xs font-heading font-bold bg-brand-purple/20 text-brand-purple border border-brand-purple/30">
                {{ $news->category }}
            </span>
            <span class="text-xs text-slate-500">
                <i class="fa-regular fa-clock mr-1"></i>
                {{ $news->created_at ? $news->created_at->format('d F Y, H:i') : '-' }} WIB
            </span>
        </div>

        <!-- Title -->
        <h1 class="text-2xl sm:text-4xl font-heading font-extrabold text-white tracking-tight leading-snug mb-6">
            {{ $news->title }}
        </h1>

        <!-- Image (if exists) -->
        @if($news->image_url ?? $news->image)
            <div class="mb-8 rounded-2xl overflow-hidden bg-dark-950 aspect-video">
                <img src="{{ $news->image_url ?? asset('storage/'.$news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Content Body -->
        <div class="prose prose-invert max-w-none text-slate-300 text-sm sm:text-base leading-relaxed whitespace-pre-line border-t border-dark-700 pt-6">
            {!! nl2br(e($news->content)) !!}
        </div>
    </article>
</section>
@endsection
