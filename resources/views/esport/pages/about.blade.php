@extends('esport.layouts.app')

@section('title', 'Tentang M-GEN - Diskominfo Kabupaten Madiun')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero Section -->
    <section class="grid md:grid-cols-2 gap-12 items-center pb-16 border-b border-dark-800">
        <div data-aos="fade-up">
            <span class="inline-flex items-center gap-2 text-xs font-heading font-bold uppercase tracking-widest text-brand-cyan bg-brand-cyan/10 border border-brand-cyan/30 rounded-full px-3 py-1 mb-4">
                <i class="fa-solid fa-users"></i> Profil Divisi
            </span>
            <h1 class="text-3xl sm:text-5xl font-heading font-black text-white tracking-tight leading-tight">
                M-GEN <span class="text-slate-400 font-medium text-2xl sm:text-3xl block mt-1">(Madiun Generation)</span>
            </h1>
            <p class="text-slate-300 mt-4 text-base sm:text-lg leading-relaxed">
                Wadah resmi pembinaan esports di bawah naungan <strong>Dinas Komunikasi dan Informatika Kabupaten Madiun</strong> untuk membangun ekosistem game kompetitif yang <em>sportif</em>, <em>inklusif</em>, dan <em>berprestasi</em>.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <span class="px-3.5 py-1.5 text-xs font-heading font-bold bg-dark-850 text-white rounded-xl border border-dark-700">Turnamen Terjadwal</span>
                <span class="px-3.5 py-1.5 text-xs font-heading font-bold bg-dark-850 text-white rounded-xl border border-dark-700">Komunitas Gamers</span>
                <span class="px-3.5 py-1.5 text-xs font-heading font-bold bg-dark-850 text-white rounded-xl border border-dark-700">Pembinaan Talenta Digital</span>
            </div>
        </div>

        <!-- Hero Visual -->
        <div data-aos="fade-left" data-aos-delay="100">
            <div class="rounded-3xl bg-gradient-to-tr from-dark-850 to-dark-800 border border-dark-700 p-8 sm:p-12 shadow-2xl flex items-center justify-center relative overflow-hidden">
                <div class="absolute -top-16 -right-16 w-32 h-32 bg-brand-cyan/10 rounded-full blur-2xl"></div>
                <img src="{{ asset('images/logo-mgen.png') }}" alt="M-GEN Kabupaten Madiun" class="max-h-56 max-w-full object-contain drop-shadow-2xl">
            </div>
        </div>
    </section>

    <!-- Misi & Nilai-Nilai -->
    <section class="py-16 border-b border-dark-800">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="gaming-card rounded-2xl p-8 shadow-sm" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-brand-cyan/10 text-brand-cyan border border-brand-cyan/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h2 class="text-xl font-heading font-bold text-white">Misi Kami</h2>
                </div>
                <ul class="space-y-3 text-slate-300 text-sm leading-relaxed">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-brand-cyan text-xs mt-1"></i>
                        <span>Menyelenggarakan turnamen game kompetitif yang teratur, adil, dan transparan bagi generasi muda.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-brand-cyan text-xs mt-1"></i>
                        <span>Membimbing dan memfasilitasi bibit atlet esports daerah menuju tingkat regional dan nasional.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-brand-cyan text-xs mt-1"></i>
                        <span>Mengedukasi masyarakat tentang etika bermain game positif, seimbang, dan anti-toksisitas.</span>
                    </li>
                </ul>
            </div>

            <div class="gaming-card rounded-2xl p-8 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-medal"></i>
                    </div>
                    <h2 class="text-xl font-heading font-bold text-white">Nilai-Nilai Utama</h2>
                </div>
                <ul class="space-y-3 text-slate-300 text-sm leading-relaxed">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-star text-emerald-400 text-xs mt-1"></i>
                        <span><strong>Sportivitas & Fairplay:</strong> Menjunjung tinggi kejujuran tanpa kecurangan (cheat/exploit).</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-star text-emerald-400 text-xs mt-1"></i>
                        <span><strong>Kolaborasi:</strong> Membangun kerja tim yang solid dan komunikasi yang sehat.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-star text-emerald-400 text-xs mt-1"></i>
                        <span><strong>Pengembangan Diri:</strong> Mengasah daya pikir analitis, refleks, dan mental juara.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Ringkasan Siapa Kami -->
    <section class="pt-16" data-aos="fade-up">
        <div class="gaming-card rounded-3xl p-8 sm:p-12 shadow-sm">
            <h2 class="text-2xl font-heading font-bold text-white mb-4">Komitmen Pemerintah Daerah</h2>
            <p class="text-slate-300 leading-relaxed text-sm sm:text-base">
                M-GEN hadir sebagai bukti keseriusan Pemerintah Kabupaten Madiun melalui Dinas Komunikasi dan Informatika dalam merespons pertumbuhan industri kreatif dan olahraga elektronik (esports). Kami membuka ruang seluas-luasnya bagi para talenta muda untuk menunjukkan kemampuan terbaik mereka.
            </p>
        </div>
    </section>
</div>
@endsection
