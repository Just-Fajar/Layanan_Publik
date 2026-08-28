@extends('esport.layouts.app')

@section('title', 'Daftar Turnamen Esports - M-GEN Kabupaten Madiun')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-cyan/10 border border-brand-cyan/30 text-brand-cyan text-xs font-heading font-bold uppercase tracking-wider mb-2">
            <i class="fa-solid fa-trophy"></i>
            <span>Kompetisi Resmi</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-white tracking-tight">
            Daftar Turnamen Esports
        </h1>
        <p class="text-slate-400 text-sm mt-1">
            Pilih turnamen dan daftarkan skuad terbaik Anda untuk bersaing di tingkat kabupaten.
        </p>
    </div>

    <!-- Search & Filter Bar -->
    <div class="gaming-card rounded-2xl p-5 mb-10 shadow-lg" data-aos="fade-up">
        <form method="GET" action="{{ route('esport.tournaments.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search Query -->
            <div class="sm:col-span-4 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari judul turnamen atau lokasi..." class="w-full pl-9 pr-4 py-2.5 bg-dark-900 border border-dark-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-cyan transition">
            </div>

            <!-- Game Input/Select -->
            <div class="sm:col-span-3">
                <input type="text" name="game" value="{{ $filters['game'] ?? '' }}" placeholder="Nama game (contoh: MLBB, PUBG)" class="w-full px-4 py-2.5 bg-dark-900 border border-dark-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-cyan transition">
            </div>

            <!-- Status Select -->
            <div class="sm:col-span-3">
                <select name="status" class="w-full px-4 py-2.5 bg-dark-900 border border-dark-700 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-brand-cyan transition">
                    <option value="">Semua Status</option>
                    @foreach(['upcoming' => 'Upcoming (Akan Datang)', 'ongoing' => 'Ongoing (Sedang Berjalan)', 'finished' => 'Finished (Selesai)'] as $sKey => $sLabel)
                        <option value="{{ $sKey }}" @selected(($filters['status'] ?? '') === $sKey)>{{ $sLabel }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div class="sm:col-span-2">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-sm font-heading font-bold text-dark-950 bg-brand-cyan hover:bg-brand-cyan-hover transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tournament Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @forelse($tournaments as $t)
            <article class="gaming-card rounded-2xl overflow-hidden flex flex-col justify-between group" data-aos="fade-up">
                <div>
                    <!-- Image Poster Container -->
                    <div class="relative aspect-video bg-dark-950 overflow-hidden">
                        @if($t->image_url ?? $t->image)
                            <img src="{{ $t->image_url ?? asset('storage/'.$t->image) }}" alt="{{ $t->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-dark-850 to-dark-800 text-slate-600">
                                <i class="fa-solid fa-trophy text-4xl opacity-30"></i>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-heading font-bold uppercase backdrop-blur-md border {{ $t->status === 'ongoing' ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30' : ($t->status === 'upcoming' ? 'bg-cyan-500/20 text-cyan-400 border-cyan-500/30' : 'bg-slate-700/50 text-slate-300 border-slate-600/50') }}">
                                <i class="fa-solid fa-circle text-[7px] mr-1.5 {{ $t->status === 'ongoing' ? 'animate-pulse' : '' }}"></i>
                                {{ ucfirst($t->status) }}
                            </span>
                        </div>

                        <!-- Game Badge -->
                        <div class="absolute bottom-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-heading font-bold bg-dark-950/80 backdrop-blur-md text-white border border-white/10">
                                <i class="fa-solid fa-gamepad mr-1.5 text-brand-cyan"></i>
                                {{ $t->game }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <div class="flex items-center gap-3 text-xs text-slate-400 mb-2">
                            <div class="flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar text-brand-cyan"></i>
                                <span>{{ $t->date ? \Carbon\Carbon::parse($t->date)->format('d M Y') : 'Jadwal Segera' }}</span>
                            </div>
                            @if($t->location)
                                <div class="flex items-center gap-1.5 truncate max-w-[150px]" title="{{ $t->location }}">
                                    <i class="fa-solid fa-location-dot text-red-400"></i>
                                    <span class="truncate">{{ $t->location }}</span>
                                </div>
                            @endif
                        </div>

                        <h3 class="font-heading font-bold text-white text-lg leading-snug mb-2 group-hover:text-brand-cyan transition">
                            <a href="{{ route('esport.tournaments.show', $t) }}">
                                {{ $t->title }}
                            </a>
                        </h3>

                        <p class="text-slate-400 text-xs sm:text-sm line-clamp-2 leading-relaxed">
                            {{ Str::limit($t->description, 100) }}
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <a href="{{ route('esport.tournaments.show', $t) }}" class="w-full py-2.5 px-4 rounded-xl text-xs font-heading font-bold text-center border border-dark-700 bg-dark-850 text-white hover:border-brand-cyan hover:bg-brand-cyan hover:text-dark-950 transition flex items-center justify-center gap-2">
                        <span>Lihat Detail Turnamen</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full gaming-card rounded-2xl p-12 text-center">
                <i class="fa-solid fa-trophy text-4xl text-slate-600 mb-3 block"></i>
                <h4 class="font-heading font-bold text-white text-base">Tidak Ada Turnamen Ditemukan</h4>
                <p class="text-slate-500 text-xs mt-1">Coba gunakan kata kunci pencarian atau filter yang berbeda.</p>
                <a href="{{ route('esport.tournaments.index') }}" class="inline-flex items-center gap-2 px-4 py-2 mt-4 rounded-xl bg-dark-700 text-white text-xs font-heading font-bold hover:bg-dark-600 transition">
                    Reset Filter
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        {{ $tournaments->links() }}
    </div>
</section>
@endsection
