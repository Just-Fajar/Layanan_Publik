@extends('calendar.layouts.app')

@section('title', 'Katalog Agenda & Kegiatan - Kalender Event Kabupaten Madiun')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-white via-slate-50 to-slate-100/60 pt-10 pb-12 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-xs font-heading font-semibold uppercase tracking-wider mb-4">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Agenda Resmi Kabupaten Madiun</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-extrabold text-slate-900 tracking-tight mb-4">
                Eksplorasi Kegiatan & Agenda Daerah
            </h1>
            <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                Temukan jadwal seminar, festival budaya, sosialisasi publik, serta kegiatan resmi pemerintah Kabupaten Madiun secara transparan dan mudah diakses.
            </p>
        </div>

        <!-- Search & Filter Card -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm max-w-4xl mx-auto">
            <form method="GET" action="{{ route('calendar.index') }}" class="flex flex-col md:flex-row gap-3">
                <!-- Search Input -->
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul agenda atau lokasi..." class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-2 focus:ring-brand-100 transition">
                </div>

                <!-- Category Select -->
                <div class="w-full md:w-56">
                    <select name="category" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-2 focus:ring-brand-100 transition">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-heading font-bold text-sm rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i>
                    <span>Terapkan</span>
                </button>
            </form>
        </div>

        <!-- View Switcher & Category Quick Pills -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 max-w-4xl mx-auto mt-6 pt-4 border-t border-slate-200">
            <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto py-1">
                <a href="{{ route('calendar.index') }}" class="px-3.5 py-1.5 rounded-full text-xs font-heading font-semibold transition whitespace-nowrap {{ !request('category') ? 'bg-slate-900 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                    Semua
                </a>
                @foreach(array_slice($categories, 0, 4) as $catKey => $catLabel)
                    <a href="{{ route('calendar.index', ['category' => $catKey]) }}" class="px-3.5 py-1.5 rounded-full text-xs font-heading font-semibold transition whitespace-nowrap {{ request('category') == $catKey ? 'bg-brand-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
                        {{ $catLabel }}
                    </a>
                @endforeach
            </div>

            <!-- Switcher to Month Calendar View -->
            <div class="flex items-center gap-1.5 bg-slate-200/70 p-1 rounded-xl">
                <a href="{{ route('calendar.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-heading font-bold bg-white text-brand-700 shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-grid-2"></i> Grid Card
                </a>
                <a href="{{ route('calendar.view') }}" class="px-3 py-1.5 rounded-lg text-xs font-heading font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1.5">
                    <i class="fa-regular fa-calendar"></i> Kalender Bulanan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($events as $event)
                <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:border-brand-300 transition-all duration-300 flex flex-col group">
                    <!-- Event Poster Container -->
                    <div class="relative aspect-video bg-slate-100 overflow-hidden">
                        @if($event->image_url)
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-brand-600 to-indigo-700 text-white">
                                <i class="fa-regular fa-calendar-days text-4xl opacity-40"></i>
                            </div>
                        @endif

                        <!-- Date Badge Top Left -->
                        @if($event->start_date)
                            <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-md rounded-xl px-3 py-1.5 shadow-md border border-white/60 text-center leading-none">
                                <span class="block font-heading font-extrabold text-slate-900 text-base">{{ $event->start_date->format('d') }}</span>
                                <span class="block text-[10px] font-heading font-bold uppercase text-brand-600 mt-0.5">{{ $event->start_date->format('M') }}</span>
                            </div>
                        @endif

                        <!-- Category Badge Top Right -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-heading font-semibold bg-slate-900/80 backdrop-blur-md text-white border border-white/20">
                                {{ $categories[$event->category] ?? $event->category }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex flex-col flex-grow justify-between">
                        <div>
                            <!-- Time & Location Meta -->
                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mb-3">
                                @if($event->start_date)
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-clock text-brand-600"></i>
                                        <span>{{ $event->start_date->format('H:i') }} WIB</span>
                                    </div>
                                @endif
                                @if($event->location)
                                    <div class="flex items-center gap-1.5 truncate max-w-[200px]" title="{{ $event->location }}">
                                        <i class="fa-solid fa-location-dot text-red-500"></i>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Title -->
                            <h3 class="font-heading font-bold text-slate-900 text-lg leading-snug mb-2 group-hover:text-brand-600 transition">
                                <a href="{{ route('calendar.show', $event) }}">
                                    {{ $event->title }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-slate-600 text-sm leading-relaxed mb-4 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit($event->description, 110) }}
                            </p>
                        </div>

                        <!-- Card Footer CTA -->
                        <div class="pt-4 border-t border-slate-100 mt-auto flex items-center justify-between">
                            <span class="text-xs font-heading font-bold {{ $event->is_upcoming ? 'text-emerald-600' : 'text-slate-500' }}">
                                <i class="fa-solid fa-circle text-[8px] mr-1"></i>
                                {{ $event->is_upcoming ? 'Mendatang' : 'Tersedia' }}
                            </span>

                            <a href="{{ route('calendar.show', $event) }}" class="inline-flex items-center gap-1.5 text-xs font-heading font-bold text-brand-600 hover:text-brand-700 group-hover:translate-x-1 transition-transform">
                                <span>Lihat Detail</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $events->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-lg mx-auto shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 border border-brand-200 text-brand-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-regular fa-calendar-xmark"></i>
            </div>
            <h3 class="font-heading font-bold text-slate-900 text-lg mb-2">Tidak Ada Event Ditemukan</h3>
            <p class="text-slate-500 text-sm mb-6">
                Belum ada agenda kegiatan yang sesuai dengan kriteria pencarian atau kategori yang Anda pilih.
            </p>
            <a href="{{ route('calendar.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-heading font-semibold text-sm transition">
                <i class="fa-solid fa-rotate-left"></i> Reset Filter
            </a>
        </div>
    @endif
</section>
@endsection
