@extends('esport.layouts.app')

@section('content')
<div class="relative">

    {{-- Konten --}}
    <section class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Info Kontak --}}
            <div class="bg-white rounded-2xl shadow-md p-8 ring-1 ring-slate-100">
                <h2 class="text-2xl font-bold mb-4 text-slate-800">Informasi Kontak</h2>
                <p class="text-slate-600 mb-6">
                    Punya pertanyaan seputar turnamen, event, atau ingin menjadi sponsor? 
                    Tim kami dengan senang hati membantu Anda.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <div class="p-3 bg-orange-100 text-orange-600 rounded-lg">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span class="text-slate-700">diskominfo@madiunkab.go.id</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="p-3 bg-orange-100 text-orange-600 rounded-lg">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <span class="text-slate-700">(+62) 351-123-456</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="p-3 bg-orange-100 text-orange-600 rounded-lg">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span class="text-slate-700">
                            <br>
                            Jl. Mastrip No.23, Mojorejo, Kec. Taman, Kota Madiun, Jawa Timur 63139<br>
                            .
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</div>
@endsection
