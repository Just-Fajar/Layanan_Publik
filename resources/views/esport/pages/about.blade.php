@extends('esport.layouts.app')

@section('content')
<div class="relative">
    {{-- Hero Section --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-500 via-amber-500 to-rose-500 opacity-10"></div>
        <div class="container mx-auto px-4 py-16 relative">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-orange-600 bg-orange-50 rounded-full px-3 py-1">
                        Tentang Kami
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold mt-3 leading-tight text-slate-900">
                        M-GEN
                    </h1>
                    <p class="text-slate-600 mt-4 text-lg">
                        Divisi esports yang dikelola oleh <strong>Diskominfo Kabupaten Madiun</strong> untuk
                        mendorong ekosistem game kompetitif yang <em>inovatif</em>, <em>sportif</em>, dan <em>inklusif</em>.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <span class="px-3 py-1 text-sm bg-white rounded-full shadow border">Turnamen Rutin</span>
                        <span class="px-3 py-1 text-sm bg-white rounded-full shadow border">Komunitas Pemain</span>
                        <span class="px-3 py-1 text-sm bg-white rounded-full shadow border">Pembinaan & Talent</span>
                    </div>
                </div>

                {{-- Gambar/Hero Illustration --}}
                <div class="relative">
                    <div class="aspect-[4/3] rounded-2xl bg-gradient-to-tr from-slate-900 to-slate-700 flex items-center justify-center shadow-2xl ring-1 ring-black/5 p-8">
                        <img src="{{ asset('images/logo-mgen.png') }}" alt="M-GEN Kabupaten Madiun" class="max-h-56 max-w-full object-contain drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Misi & Visi --}}
    <section class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-orange-100 text-orange-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M13 3a9 9 0 100 18 9 9 0 000-18zm1 9l4 2-4 2-1 4-2-4-4-2 4-2 2-4 1 4z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold">Misi Kami</h2>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M3 12l2-2 5 5L19 6l2 2-11 11z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold">Nilai-Nilai</h2>
                </div>
            </div>
        </div>
    </section>

    {{-- Tentang Singkat --}}
    <section class="container mx-auto px-4 pb-16">
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-100 p-8">
            <h2 class="text-2xl font-bold mb-4">Siapa Kami?</h2>
            <p class="text-slate-600 leading-relaxed">
                M-GEN adalah wadah resmi bagi atlet, panitia, dan pencinta game di Kabupaten Madiun.
                Kami menghadirkan turnamen, program pembinaan, serta forum komunitas yang
                terbuka untuk semua kalangan. Dari pemula hingga profesional. Bersama Diskominfo, kami berkomitmen
                menghadirkan ekosistem esports yang sehat, edukatif, dan berkelanjutan.
            </p>
        </div>
    </section>
</div>
@endsection
