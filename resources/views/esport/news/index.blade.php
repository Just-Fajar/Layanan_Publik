@extends('esport.layouts.app')

@section('title', 'Berita & Pengumuman - M-GEN Esport')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-purple/10 border border-brand-purple/30 text-brand-purple text-xs font-heading font-bold uppercase tracking-wider mb-2">
            <i class="fa-solid fa-newspaper"></i>
            <span>Informasi & Pengumuman</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-white tracking-tight">
            Kabar Esports M-GEN
        </h1>
        <p class="text-slate-400 text-sm mt-1">
            Informasi terkini mengenai jadwal, hasil turnamen, serta aktivitas komunitas gamers Kabupaten Madiun.
        </p>
    </div>

    <!-- Filter Bar -->
    <div class="gaming-card rounded-2xl p-5 mb-10 shadow-lg" data-aos="fade-up">
        <form method="GET" action="{{ route('esport.news.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-7 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari judul berita atau konten..." class="w-full pl-9 pr-4 py-2.5 bg-dark-900 border border-dark-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-purple transition">
            </div>

            <div class="sm:col-span-3">
                <select name="category" class="w-full px-4 py-2.5 bg-dark-900 border border-dark-700 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-brand-purple transition">
                    <option value="">Semua Kategori</option>
                    @foreach(['Tournament Info', 'Esport News', 'Pengumuman'] as $c)
                        <option value="{{ $c }}" @selected(($filters['category'] ?? '') === $c)>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-sm font-heading font-bold text-white bg-brand-purple hover:bg-purple-600 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @forelse($news as $n)
            <article class="gaming-card rounded-2xl overflow-hidden flex flex-col justify-between group" data-aos="fade-up">
                <div>
                    <div class="relative aspect-video bg-dark-950 overflow-hidden">
                        @if($n->image_url ?? $n->image)
                            <img src="{{ $n->image_url ?? asset('storage/'.$n->image) }}" alt="{{ $n->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-dark-850 to-dark-800 text-slate-600">
                                <i class="fa-solid fa-newspaper text-4xl opacity-30"></i>
                            </div>
                        @endif

                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-heading font-bold bg-brand-purple/80 backdrop-blur-md text-white">
                                {{ $n->category }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-xs text-slate-500 mb-2">
                            {{ $n->created_at ? $n->created_at->format('d M Y') : '-' }}
                        </div>

                        <h3 class="font-heading font-bold text-white text-lg leading-snug mb-2 group-hover:text-brand-purple transition">
                            <a href="{{ route('esport.news.show', $n) }}">
                                {{ $n->title }}
                            </a>
                        </h3>

                        <p class="text-slate-400 text-xs sm:text-sm line-clamp-2 leading-relaxed">
                            {{ Str::limit(strip_tags($n->content), 110) }}
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <a href="{{ route('esport.news.show', $n) }}" class="inline-flex items-center gap-1.5 text-xs font-heading font-bold text-brand-purple hover:text-purple-300 transition">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full gaming-card rounded-2xl p-12 text-center">
                <i class="fa-solid fa-newspaper text-4xl text-slate-600 mb-3 block"></i>
                <h4 class="font-heading font-bold text-white text-base">Tidak Ada Berita Ditemukan</h4>
                <p class="text-slate-500 text-xs mt-1">Coba sesuaikan kata kunci atau filter pencarian Anda.</p>
                <a href="{{ route('esport.news.index') }}" class="inline-flex items-center gap-2 px-4 py-2 mt-4 rounded-xl bg-dark-700 text-white text-xs font-heading font-bold hover:bg-dark-600 transition">
                    Reset Filter
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        {{ $news->links() }}
    </div>
</section>
@endsection
