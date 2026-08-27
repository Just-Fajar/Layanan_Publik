<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Esport Section')</title>

  {{-- (Opsional) Bila di proyek ada Bootstrap, nonaktifkan preflight Tailwind agar tak bentrok --}}
  <script>
    window.tailwind = window.tailwind || {};
    tailwind.config = { corePlugins: { preflight: false } };
  </script>

  {{-- Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Ikon (Font Awesome) --}}
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        referrerpolicy="no-referrer"/>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Roboto', sans-serif;
  }
</style>

  {{-- Tempat view menyuntik CSS tambahan --}}
  @stack('styles')
</head>
<body class="bg-black text-white antialiased">

  <nav class="bg-black sticky top-0 z-40 border-b border-gray-800">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center py-4">
      <div class="flex items-center gap-4">
        <a href="{{ route('homepage') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg border border-gray-700 text-gray-400 hover:text-white hover:border-gray-500 text-xs font-semibold transition" title="Kembali ke Portal Utama Diskominfo">
          <i class="fa-solid fa-arrow-left"></i>
          <span>Portal Utama</span>
        </a>
        <a href="{{ route('esport.home') }}" class="text-xl font-bold text-white tracking-wider">M-GEN</a>
      </div>
      <div class="hidden sm:flex items-center gap-6">
        <a href="{{ route('esport.home') }}" class="text-white hover:text-gray-300">Home</a>
        <a href="{{ route('esport.tournaments.index') }}" class="text-white hover:text-gray-300">Tournaments</a>
        <a href="{{ route('esport.news.index') }}" class="text-white hover:text-gray-300">News</a>
        <a href="{{ route('esport.about') ?? '#' }}" class="text-white hover:text-gray-300">About</a>
        <a href="{{ route('esport.contact') ?? '#' }}" class="text-white hover:text-gray-300">Contact</a>
      </div>
    </div>
  </div>
</nav>


  <main>
    @yield('content')
  </main>

<footer class="bg-black border-t border-gray-800 mt-12">
  <div class="container mx-auto px-4 py-6 text-center text-white">
    &copy; {{ date('Y') }} DISKOMINFO KABUPATEN MADIUN. All rights reserved.
  </div>
</footer>

  {{-- Tempat view menyuntik JS tambahan --}}
  @stack('scripts')
</body>
</html>
