@extends('calendar.layouts.app')

@section('title', 'Jadwal Kalender Bulanan - Kalender Event Kabupaten Madiun')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header with Navigation -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 mb-8 border-b border-slate-200">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-xs font-heading font-semibold uppercase tracking-wider mb-2">
                <i class="fa-regular fa-calendar"></i> Kalender Agenda
            </div>
            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900">
                Agenda Bulan {{ \Carbon\Carbon::create($year, $month, 1)->locale('id')->isoFormat('MMMM Y') }}
            </h1>
        </div>

        <!-- Month Switcher & View Switcher Controls -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="inline-flex items-center rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
                <a href="{{ route('calendar.view', ['year' => $month == 1 ? $year - 1 : $year, 'month' => $month == 1 ? 12 : $month - 1]) }}" class="px-3 py-1.5 rounded-lg text-xs font-heading font-semibold text-slate-700 hover:bg-slate-100 transition flex items-center gap-1">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    <span>Bulan Lalu</span>
                </a>
                <div class="h-4 w-px bg-slate-200 mx-1"></div>
                <a href="{{ route('calendar.view', ['year' => $month == 12 ? $year + 1 : $year, 'month' => $month == 12 ? 1 : $month + 1]) }}" class="px-3 py-1.5 rounded-lg text-xs font-heading font-semibold text-slate-700 hover:bg-slate-100 transition flex items-center gap-1">
                    <span>Bulan Depan</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <a href="{{ route('calendar.index') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-brand-600 hover:border-brand-300 font-heading text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-grid-2"></i> Tampilan Grid
            </a>
        </div>
    </div>

    <!-- Month Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-brand-600 p-6 shadow-sm hover:shadow-lg hover:border-slate-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-heading font-semibold bg-brand-50 text-brand-700 border border-brand-100">
                            {{ $event->category_label ?? $event->category }}
                        </span>
                        @if($event->is_upcoming)
                            <span class="text-xs font-heading font-bold text-emerald-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle text-[7px]"></i> Mendatang
                            </span>
                        @endif
                    </div>

                    <h3 class="font-heading font-bold text-slate-900 text-lg mb-2">
                        <a href="{{ route('calendar.show', $event) }}" class="hover:text-brand-600 transition">
                            {{ $event->title }}
                        </a>
                    </h3>

                    <div class="space-y-1.5 text-xs text-slate-500 mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar text-brand-600 w-4"></i>
                            <span>{{ $event->start_date ? $event->start_date->format('d M Y, H:i') : '-' }} WIB</span>
                        </div>
                        @if($event->location)
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-red-500 w-4"></i>
                                <span>{{ $event->location }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <a href="{{ route('calendar.show', $event) }}" class="inline-flex items-center gap-1.5 text-xs font-heading font-bold text-brand-600 hover:text-brand-700">
                        <span>Lihat Detail Agenda</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <h3 class="font-heading font-bold text-slate-900 text-lg mb-1">Tidak Ada Kegiatan</h3>
                <p class="text-slate-500 text-sm mb-4">
                    Belum ada agenda kegiatan resmi yang dijadwalkan pada bulan ini.
                </p>
                <a href="{{ route('calendar.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white font-heading text-xs font-bold hover:bg-slate-800 transition">
                    Lihat Semua Agenda
                </a>
            </div>
        @endforelse
    </div>
</section>
@endsection
