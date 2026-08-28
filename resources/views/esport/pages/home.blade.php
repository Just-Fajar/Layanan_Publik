@extends('esport.layouts.app')

@section('title', 'M-GEN Esport - Arena Kompetisi & Komunitas Gamers Kabupaten Madiun')

@section('content')
<!-- Hero Section -->
<section class="relative pt-12 pb-20 border-b border-dark-800 bg-gradient-to-b from-dark-950 via-dark-900 to-dark-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Left Content -->
            <div class="lg:col-span-7 space-y-6" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-cyan/10 border border-brand-cyan/30 text-brand-cyan text-xs font-heading font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-gamepad"></i>
                    <span>Official Hub Esport Diskominfo Kabupaten Madiun</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-heading font-black text-white tracking-tight leading-tight">
                    Bangun Skuad, Raih Prestasi di Arena <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-cyan via-brand-purple to-pink-500">M-GEN</span>
                </h1>

                <p class="text-slate-400 text-base sm:text-lg leading-relaxed max-w-xl">
                    Pusat kompetisi esports resmi, pendaftaran turnamen berkala, dan pembinaan atlet game kompetitif bagi seluruh generasi muda Kabupaten Madiun.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('esport.tournaments.index') }}" class="px-6 py-3.5 rounded-xl font-heading font-bold text-sm text-dark-950 bg-brand-cyan hover:bg-brand-cyan-hover shadow-lg shadow-cyan-500/20 transition flex items-center gap-2">
                        <i class="fa-solid fa-trophy"></i>
                        <span>Jelajahi Turnamen</span>
                    </a>

                    <a href="{{ route('esport.news.index') }}" class="px-6 py-3.5 rounded-xl font-heading font-bold text-sm text-slate-300 bg-dark-850 border border-dark-700 hover:text-white hover:border-brand-cyan transition flex items-center gap-2">
                        <i class="fa-solid fa-newspaper"></i>
                        <span>Kabar Esports</span>
                    </a>
                </div>

                <!-- Stats Counters -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-dark-800 max-w-md">
                    <div>
                        <div class="text-2xl font-heading font-extrabold text-white">5+</div>
                        <div class="text-xs text-slate-500">Cabang Game</div>
                    </div>
                    <div>
                        <div class="text-2xl font-heading font-extrabold text-brand-cyan">Resmi</div>
                        <div class="text-xs text-slate-500">Pemerintah Daerah</div>
                    </div>
                    <div>
                        <div class="text-2xl font-heading font-extrabold text-brand-purple">100%</div>
                        <div class="text-xs text-slate-500">Gratis / Fairplay</div>
                    </div>
                </div>
            </div>

            <!-- Hero Right Visual Box -->
            <div class="lg:col-span-5 text-center" data-aos="fade-left" data-aos-delay="100">
                <div class="relative inline-block w-full max-w-md">
                    <div class="rounded-3xl bg-gradient-to-tr from-dark-850 to-dark-800 border border-dark-700 p-8 sm:p-10 shadow-2xl relative overflow-hidden group">
                        <div class="absolute -top-20 -right-20 w-40 h-40 bg-brand-cyan/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-brand-purple/10 rounded-full blur-3xl"></div>
                        
                        <img src="{{ asset('images/logo-mgen.png') }}" alt="M-GEN Esports" class="mx-auto max-h-56 w-auto object-contain drop-shadow-[0_15px_25px_rgba(0,0,0,0.6)] group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="mt-6 pt-6 border-t border-dark-700/80">
                            <div class="text-sm font-heading font-bold text-white uppercase tracking-wider">Madiun Generation</div>
                            <div class="text-xs text-slate-400 mt-1">Mendorong Ekosistem Gaming Sehat & Berprestasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Game Categories -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-b border-dark-800">
    <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
        <span class="text-xs font-heading font-bold text-brand-cyan uppercase tracking-widest">Game Populer</span>
        <h2 class="text-2xl sm:text-3xl font-heading font-extrabold text-white mt-1">Cabang Game Kompetitif</h2>
        <p class="text-slate-400 text-sm mt-2">Turnamen M-GEN mempertandingkan beragam game esports favorit mobile dan PC.</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
        <div class="gaming-card rounded-2xl p-5 text-center" data-aos="fade-up" data-aos-delay="50">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20 flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="font-heading font-bold text-white text-base">Mobile Legends</h3>
            <p class="text-slate-500 text-xs mt-1">MOBA 5v5 Tournament</p>
        </div>

        <div class="gaming-card rounded-2xl p-5 text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-crosshairs"></i>
            </div>
            <h3 class="font-heading font-bold text-white text-base">PUBG Mobile</h3>
            <p class="text-slate-500 text-xs mt-1">Battle Royale Squad</p>
        </div>

        <div class="gaming-card rounded-2xl p-5 text-center" data-aos="fade-up" data-aos-delay="150">
            <div class="w-12 h-12 rounded-xl bg-red-500/10 text-red-400 border border-red-500/20 flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-fire"></i>
            </div>
            <h3 class="font-heading font-bold text-white text-base">Free Fire</h3>
            <p class="text-slate-500 text-xs mt-1">Survival Shooter</p>
        </div>

        <div class="gaming-card rounded-2xl p-5 text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-gamepad"></i>
            </div>
            <h3 class="font-heading font-bold text-white text-base">Valorant & FC</h3>
            <p class="text-slate-500 text-xs mt-1">Tactical FPS & Sports</p>
        </div>
    </div>
</section>

<!-- Latest Tournaments Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-b border-dark-800">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10" data-aos="fade-up">
        <div>
            <span class="text-xs font-heading font-bold text-brand-cyan uppercase tracking-widest">Jadwal Turnamen</span>
            <h2 class="text-2xl sm:text-3xl font-heading font-extrabold text-white mt-1">Turnamen Terbaru</h2>
        </div>
        <a href="{{ route('esport.tournaments.index') }}" class="text-xs font-heading font-bold text-brand-cyan hover:text-brand-cyan-hover flex items-center gap-1.5 transition">
            <span>Lihat Semua Turnamen</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
        @forelse($featuredTournaments as $t)
            <article class="gaming-card rounded-2xl overflow-hidden flex flex-col justify-between group" data-aos="fade-up">
                <div>
                    <!-- Image Poster Container -->
                    <div class="relative aspect-video bg-dark-950 overflow-hidden">
                        @if($t->image)
                            <img src="{{ asset('storage/'.$t->image) }}" alt="{{ $t->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                        <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                            <i class="fa-regular fa-calendar text-brand-cyan"></i>
                            <span>{{ $t->date ? \Carbon\Carbon::parse($t->date)->format('d M Y') : 'Jadwal Segera' }}</span>
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
                <h4 class="font-heading font-bold text-white text-base">Belum Ada Turnamen Aktif</h4>
                <p class="text-slate-500 text-xs mt-1">Nantikan jadwal turnamen resmi M-GEN berikutnya di halaman ini.</p>
            </div>
        @endforelse
    </div>
</section>

<!-- Latest News Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10" data-aos="fade-up">
        <div>
            <span class="text-xs font-heading font-bold text-brand-purple uppercase tracking-widest">Informasi & Update</span>
            <h2 class="text-2xl sm:text-3xl font-heading font-extrabold text-white mt-1">Kabar Esports Terkini</h2>
        </div>
        <a href="{{ route('esport.news.index') }}" class="text-xs font-heading font-bold text-brand-purple hover:text-purple-400 flex items-center gap-1.5 transition">
            <span>Lihat Semua Berita</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
        @forelse($latestNews as $n)
            <article class="gaming-card rounded-2xl overflow-hidden flex flex-col justify-between group" data-aos="fade-up">
                <div>
                    <div class="relative aspect-video bg-dark-950 overflow-hidden">
                        @if($n->image)
                            <img src="{{ asset('storage/'.$n->image) }}" alt="{{ $n->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                            {{ Str::limit(strip_tags($n->content), 100) }}
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
                <h4 class="font-heading font-bold text-white text-base">Belum Ada Berita</h4>
                <p class="text-slate-500 text-xs mt-1">Kabar dan artikel komunitas esports akan tampil di sini.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
