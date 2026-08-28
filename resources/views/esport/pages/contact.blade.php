@extends('esport.layouts.app')

@section('title', 'Kontak Panitia - M-GEN Esport')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="mb-10 text-center max-w-2xl mx-auto" data-aos="fade-up">
        <span class="inline-flex items-center gap-2 text-xs font-heading font-bold uppercase tracking-widest text-brand-cyan bg-brand-cyan/10 border border-brand-cyan/30 rounded-full px-3 py-1 mb-3">
            <i class="fa-solid fa-headset"></i> Layanan Informasi
        </span>
        <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-white tracking-tight">
            Hubungi Panitia & Tim M-GEN
        </h1>
        <p class="text-slate-400 text-sm mt-2">
            Punya pertanyaan seputar turnamen, kemitraan komunitas, atau kendala pendaftaran? Tim kami siap membantu.
        </p>
    </div>

    <!-- Contact Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="gaming-card rounded-2xl p-6 text-center" data-aos="fade-up" data-aos-delay="50">
            <div class="w-12 h-12 rounded-xl bg-brand-cyan/10 text-brand-cyan border border-brand-cyan/20 flex items-center justify-center mx-auto mb-4 text-xl">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <h3 class="font-heading font-bold text-white text-base mb-1">Email Resmi</h3>
            <p class="text-slate-400 text-xs mb-3">Kirimkan pertanyaan atau proposal kemitraan.</p>
            <a href="mailto:diskominfo@madiunkab.go.id" class="text-xs font-heading font-bold text-brand-cyan hover:underline">
                diskominfo@madiunkab.go.id
            </a>
        </div>

        <div class="gaming-card rounded-2xl p-6 text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="w-12 h-12 rounded-xl bg-brand-purple/10 text-brand-purple border border-brand-purple/20 flex items-center justify-center mx-auto mb-4 text-xl">
                <i class="fa-solid fa-phone"></i>
            </div>
            <h3 class="font-heading font-bold text-white text-base mb-1">Telepon Kantor</h3>
            <p class="text-slate-400 text-xs mb-3">Layanan jam operasional kerja dinas.</p>
            <span class="text-xs font-heading font-bold text-slate-200">
                (0351) 462927
            </span>
        </div>

        <div class="gaming-card rounded-2xl p-6 text-center" data-aos="fade-up" data-aos-delay="150">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center mx-auto mb-4 text-xl">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <h3 class="font-heading font-bold text-white text-base mb-1">Sekretariat</h3>
            <p class="text-slate-400 text-xs mb-3">Dinas Komunikasi dan Informatika</p>
            <span class="text-xs text-slate-300">
                Jl. Mastrip No.23, Kota Madiun
            </span>
        </div>
    </div>

    <!-- Operating Hours Banner -->
    <div class="gaming-card rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-dark-850 border border-dark-700 flex items-center justify-center text-amber-400 text-xl shrink-0">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div>
                <h4 class="font-heading font-bold text-white text-sm sm:text-base">Jam Operasional Layanan Informasi</h4>
                <p class="text-slate-400 text-xs">Senin – Jumat: 08:00 – 15:30 WIB (Hari Libur & Tanggal Merah Tutup)</p>
            </div>
        </div>

        <a href="{{ route('esport.tournaments.index') }}" class="px-5 py-2.5 rounded-xl bg-brand-cyan hover:bg-brand-cyan-hover text-dark-950 font-heading font-bold text-xs transition shadow-sm shrink-0">
            Lihat Jadwal Turnamen
        </a>
    </div>
</div>
@endsection
