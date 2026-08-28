@extends('esport.layouts.app')

@section('title', $tournament->title . ' - M-GEN Esport')

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb & Back -->
    <div class="mb-6">
        <a href="{{ route('esport.tournaments.index') }}" class="inline-flex items-center gap-2 text-sm font-heading font-semibold text-slate-400 hover:text-brand-cyan transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Turnamen</span>
        </a>
    </div>

    <div class="gaming-card rounded-3xl overflow-hidden shadow-2xl">
        <!-- Tournament Poster -->
        @if($tournament->image)
            <div class="relative w-full aspect-[21/9] bg-dark-950 overflow-hidden">
                <img src="{{ asset('storage/'.$tournament->image) }}" alt="{{ $tournament->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6 sm:p-10">
            <!-- Badges -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="px-3 py-1 rounded-lg text-xs font-heading font-bold bg-brand-cyan/20 text-brand-cyan border border-brand-cyan/30 uppercase">
                    <i class="fa-solid fa-gamepad mr-1"></i> {{ $tournament->game }}
                </span>
                <span class="px-3 py-1 rounded-lg text-xs font-heading font-bold uppercase {{ $tournament->status === 'ongoing' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($tournament->status === 'upcoming' ? 'bg-cyan-500/20 text-cyan-400 border border-cyan-500/30' : 'bg-slate-700/50 text-slate-300 border border-slate-600/50') }}">
                    <i class="fa-solid fa-circle text-[7px] mr-1"></i> {{ ucfirst($tournament->status) }}
                </span>
            </div>

            <!-- Tournament Title -->
            <h1 class="text-2xl sm:text-4xl font-heading font-black text-white tracking-tight mb-6 leading-snug">
                {{ $tournament->title }}
            </h1>

            <!-- Meta Information Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-5 rounded-2xl bg-dark-900 border border-dark-700 mb-8">
                <!-- Date -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-dark-800 border border-dark-700 flex items-center justify-center text-brand-cyan shrink-0">
                        <i class="fa-regular fa-calendar text-base"></i>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-semibold text-slate-500 uppercase tracking-wider">Tanggal Main</div>
                        <div class="text-sm font-heading font-bold text-white">
                            {{ $tournament->date ? \Carbon\Carbon::parse($tournament->date)->format('d M Y') : 'Segera Diumumkan' }}
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-dark-800 border border-dark-700 flex items-center justify-center text-red-400 shrink-0">
                        <i class="fa-solid fa-location-dot text-base"></i>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-semibold text-slate-500 uppercase tracking-wider">Lokasi / Venue</div>
                        <div class="text-sm font-heading font-bold text-white">
                            {{ $tournament->location ?? 'Online / Main Venue' }}
                        </div>
                    </div>
                </div>

                <!-- Organizer Contact -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-dark-800 border border-dark-700 flex items-center justify-center text-brand-purple shrink-0">
                        <i class="fa-solid fa-headset text-base"></i>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-semibold text-slate-500 uppercase tracking-wider">Kontak Panitia</div>
                        <div class="text-sm font-heading font-bold text-white">
                            {{ $tournament->organizer_contact ?? 'Panitia M-GEN' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description & Rules -->
            <div class="mb-10">
                <h3 class="text-lg font-heading font-bold text-white pb-3 border-b border-dark-700 mb-4">
                    Deskripsi & Ketentuan Turnamen
                </h3>
                <div class="text-slate-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                    {{ $tournament->description }}
                </div>
            </div>

            <!-- Registration CTA Banner -->
            <div class="p-6 sm:p-8 rounded-2xl bg-gradient-to-r from-dark-850 to-dark-800 border border-dark-700 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="font-heading font-bold text-white text-lg mb-1">
                        Siap Bersaing Memperebutkan Gelar Juara?
                    </h4>
                    <p class="text-slate-400 text-sm">
                        Daftarkan tim Anda sekarang untuk mengikuti bracket pertandingan resmi M-GEN.
                    </p>
                </div>

                <div class="shrink-0">
                    @auth
                        <form method="POST" action="{{ route('esport.user.tournaments.register', $tournament) }}">
                            @csrf
                            <button type="submit" class="px-6 py-3 rounded-xl bg-brand-cyan hover:bg-brand-cyan-hover text-dark-950 font-heading font-bold text-sm shadow-lg shadow-cyan-500/20 transition flex items-center gap-2">
                                <i class="fa-solid fa-gamepad"></i>
                                <span>Daftarkan Tim Saya</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('esport.auth.login') }}" class="px-6 py-3 rounded-xl bg-brand-cyan hover:bg-brand-cyan-hover text-dark-950 font-heading font-bold text-sm shadow-lg shadow-cyan-500/20 transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            <span>Masuk untuk Mendaftar</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
