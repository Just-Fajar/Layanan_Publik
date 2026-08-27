@extends('calendar.layouts.app')

@section('title', $event->title . ' - Kalender Event Kabupaten Madiun')

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb & Back -->
    <div class="mb-6">
        <a href="{{ route('calendar.index') }}" class="inline-flex items-center gap-2 text-sm font-heading font-semibold text-slate-500 hover:text-brand-600 transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Agenda</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Event Poster -->
        @if($event->image_url)
            <div class="relative w-full aspect-[21/9] bg-slate-900 overflow-hidden">
                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6 sm:p-10">
            <!-- Badges -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="px-3 py-1 rounded-lg text-xs font-heading font-semibold bg-brand-50 text-brand-700 border border-brand-200">
                    {{ $event->category_label ?? $event->category }}
                </span>
                <span class="px-3 py-1 rounded-lg text-xs font-heading font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    {{ ucfirst($event->status) }}
                </span>
                @if($event->quota)
                    <span class="px-3 py-1 rounded-lg text-xs font-heading font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        <i class="fa-solid fa-users mr-1"></i> Kuota: {{ $event->quota }} Peserta
                    </span>
                @endif
            </div>

            <!-- Event Title -->
            <h1 class="text-2xl sm:text-4xl font-heading font-extrabold text-slate-900 tracking-tight mb-6 leading-snug">
                {{ $event->title }}
            </h1>

            <!-- Schedule & Location Meta Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200 mb-8">
                <!-- Start Time -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-brand-600 shrink-0">
                        <i class="fa-regular fa-calendar text-base"></i>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-semibold text-slate-400 uppercase tracking-wider">Mulai Kegiatan</div>
                        <div class="text-sm font-heading font-bold text-slate-800">
                            {{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '-' }} WIB
                        </div>
                    </div>
                </div>

                <!-- End Time -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-brand-600 shrink-0">
                        <i class="fa-regular fa-calendar-check text-base"></i>
                    </div>
                    <div>
                        <div class="text-xs font-heading font-semibold text-slate-400 uppercase tracking-wider">Selesai Kegiatan</div>
                        <div class="text-sm font-heading font-bold text-slate-800">
                            {{ $event->end_date ? $event->end_date->format('d M Y, H:i') : '-' }} WIB
                        </div>
                    </div>
                </div>

                <!-- Location -->
                @if($event->location)
                    <div class="flex items-start gap-3 sm:col-span-2 lg:col-span-1">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-red-500 shrink-0">
                            <i class="fa-solid fa-location-dot text-base"></i>
                        </div>
                        <div>
                            <div class="text-xs font-heading font-semibold text-slate-400 uppercase tracking-wider">Lokasi / Tempat</div>
                            <div class="text-sm font-heading font-bold text-slate-800">
                                {{ $event->location }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div class="prose max-w-none mb-10">
                <h3 class="text-lg font-heading font-bold text-slate-900 pb-3 border-b border-slate-100 mb-4">
                    Deskripsi Kegiatan
                </h3>
                <div class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                    {{ $event->description }}
                </div>
            </div>

            <!-- Registration Action Card -->
            <div class="p-6 sm:p-8 rounded-2xl bg-gradient-to-r from-brand-50 to-indigo-50 border border-brand-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="font-heading font-bold text-slate-900 text-lg mb-1">
                        Tertarik Mengikuti Kegiatan Ini?
                    </h4>
                    <p class="text-slate-600 text-sm">
                        Daftarkan diri Anda untuk mendapatkan e-Tiket dan akses kegiatan resmi daerah.
                    </p>
                </div>

                <div class="shrink-0">
                    @auth
                        <form method="POST" action="{{ route('calendar.user.events.register', $event) }}">
                            @csrf
                            <button type="submit" class="px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-heading font-bold text-sm shadow-md shadow-brand-500/20 transition flex items-center gap-2">
                                <i class="fa-solid fa-ticket"></i>
                                <span>Daftar Event Ini</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('calendar.auth.login') }}" class="px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-heading font-bold text-sm shadow-md shadow-brand-500/20 transition flex items-center gap-2">
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
