<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Event Organizer') }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    <style>/*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */</style>
  @endif
</head>
<body class="font-primary antialiased">

  {{-- Navigation --}}
  <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <div class="text-2xl font-bold text-primary">EventPro</div>
        <div class="hidden md:flex space-x-8">
          <a href="#home" class="text-gray-700 hover:text-primary transition">Home</a>
          <a href="#about" class="text-gray-700 hover:text-primary transition">Tentang Kami</a>
          <a href="#services" class="text-gray-700 hover:text-primary transition">Layanan</a>
          <a href="#venues" class="text-gray-700 hover:text-primary transition">Venue</a>
          <a href="#pricing" class="text-gray-700 hover:text-primary transition">Harga</a>
          <a href="#testimonials" class="text-gray-700 hover:text-primary transition">Testimonial</a>
        </div>
        <a href="#contact" class="bg-primary text-white px-6 py-2 rounded-full hover:opacity-90 transition">
          Hubungi Kami
        </a>
      </div>
    </div>
  </nav>

  {{-- Hero Section --}}
 <section id="home" class="relative overflow-hidden bg-gradient-to-br from-[#faf9fc] via-white to-[#f3f0fa] pt-36 pb-28">

  <!-- Decorative Blurs -->
  <div class="absolute -top-40 -left-40 w-[520px] h-[520px] bg-purple-700/20 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 right-0 w-[420px] h-[420px] bg-indigo-500/10 rounded-full blur-3xl"></div>

  <div class="relative max-w-7xl mx-auto px-6">
    <div class="grid md:grid-cols-2 gap-20 items-center">

      <!-- LEFT CONTENT -->
      <div>
        <span class="inline-block mb-6 text-sm tracking-widest uppercase text-primary/80">
          Premium Event Organizer
        </span>

        <h1 class="text-5xl md:text-6xl font-semibold leading-tight text-gray-900">
          Make Your Dream
          <span
            class="block bg-gradient-to-r from-purple-700 via-primary to-indigo-600
                   bg-clip-text text-transparent font-bold"
          >
            Come True
          </span>
        </h1>

        <p class="mt-8 text-lg text-gray-600 leading-relaxed max-w-xl">
          We curate meaningful moments into timeless luxury experiences,
          crafted with elegance, precision, and a deep attention to detail.
        </p>

        <!-- CTA -->
        <div class="mt-12 flex items-center gap-8">
          <a
            href="#pricing"
            class="bg-gradient-to-r from-purple-700 to-primary
                   text-white px-10 py-4 rounded-full font-medium
                   shadow-2xl shadow-purple-700/30
                   hover:scale-105 transition"
          >
            Get Started
          </a>

          <a
            href="#about"
            class="text-gray-700 font-medium tracking-wide hover:text-primary transition"
          >
            Learn More →
          </a>
        </div>

        <!-- TRUST -->
        <div class="mt-14 flex items-center gap-10 text-sm text-gray-500">
          <div>
            <span class="block text-gray-900 font-semibold">120+</span>
            Events Managed
          </div>
          <div>
            <span class="block text-gray-900 font-semibold">4.9★</span>
            Client Rating
          </div>
          <div>
            <span class="block text-gray-900 font-semibold">10+ Years</span>
            Experience
          </div>
        </div>
      </div>

      <!-- RIGHT IMAGE -->
      <div class="relative">
        <!-- glow frame -->
        <div class="absolute -inset-6 bg-gradient-to-tr from-purple-700/20 to-indigo-600/10 rounded-[36px] blur-2xl"></div>

        <img
          src="https://i.pinimg.com/736x/5c/5a/d2/5c5ad2518021461a442eae1d3f48fdbc.jpg"
          alt="Luxury Event"
          class="relative rounded-[36px] shadow-2xl ring-1 ring-black/5 mx-auto"
        />
      </div>

    </div>
  </div>
</section>


  {{-- About Us --}}
  <section id="about" class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Tentang Kami</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Lebih dari 10 tahun pengalaman dalam menghadirkan event berkelas dunia
        </p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-primary/5 to-primary/10 hover:shadow-lg transition">
          <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-3">500+ Event</h3>
          <p class="text-gray-600">Berhasil diselenggarakan dengan sempurna</p>
        </div>
        <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-primary/5 to-primary/10 hover:shadow-lg transition">
          <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-3">50+ Team</h3>
          <p class="text-gray-600">Profesional berpengalaman siap membantu Anda</p>
        </div>
        <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-primary/5 to-primary/10 hover:shadow-lg transition">
          <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-3">98% Satisfied</h3>
          <p class="text-gray-600">Tingkat kepuasan klien yang luar biasa</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Services --}}
  <section id="services" class="py-20 px-4 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold mb-4">Layanan Kami</h2>
        <p class="text-xl text-gray-300 max-w-2xl mx-auto">
          Solusi lengkap untuk setiap kebutuhan event Anda
        </p>
      </div>
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
          $services = [
            ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'title' => 'Wedding', 'desc' => 'Pernikahan impian yang tak terlupakan'],
            ['icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Corporate', 'desc' => 'Event perusahaan yang profesional'],
            ['icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'title' => 'Birthday', 'desc' => 'Pesta ulang tahun yang meriah'],
            ['icon' => 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z', 'title' => 'Seminar', 'desc' => 'Seminar dan konferensi berkualitas']
          ];
        @endphp
        @foreach($services as $service)
        <div class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl hover:bg-white/20 hover:shadow-xl transition group border border-white/10">
          <div class="w-14 h-14 bg-primary/20 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition">
            <svg class="w-7 h-7 text-primary group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3">{{ $service['title'] }}</h3>
          <p class="text-gray-300">{{ $service['desc'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Venues --}}
  <section id="venues" class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Pilihan Venue</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Venue eksklusif dengan fasilitas lengkap untuk event Anda
        </p>
      </div>
      <div id="venuesGrid" class="grid md:grid-cols-3 gap-8">
        {{-- Loading state --}}
        <div class="col-span-full text-center py-12">
          <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
          <p class="mt-2 text-gray-600">Loading venues...</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Pricing --}}
  <section id="pricing" class="py-20 px-4 bg-gradient-to-br from-primary/10 via-white to-primary/5">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Paket Harga</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Pilih paket yang sesuai dengan kebutuhan dan budget Anda
        </p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        @php
          $packages = [
            ['name' => 'Silver', 'price' => '15.000.000', 'features' => ['Venue 6 jam', 'Dekorasi standar', 'Sound system', 'Catering 100 pax', 'Dokumentasi foto'], 'popular' => false],
            ['name' => 'Gold', 'price' => '25.000.000', 'features' => ['Venue 8 jam', 'Dekorasi premium', 'Sound & lighting', 'Catering 200 pax', 'Foto & video', 'MC profesional'], 'popular' => true],
            ['name' => 'Platinum', 'price' => '40.000.000', 'features' => ['Venue unlimited', 'Dekorasi luxury', 'Full entertainment', 'Catering unlimited', 'Cinematic video', 'Wedding organizer', 'Guest management'], 'popular' => false]
          ];
        @endphp
        @foreach($packages as $package)
        <div class="bg-white rounded-2xl p-8 @if($package['popular']) ring-4 ring-primary shadow-2xl transform scale-105 @else shadow-lg @endif relative">
          @if($package['popular'])
          <div class="absolute top-0 right-8 -translate-y-1/2">
            <span class="bg-primary text-white px-6 py-2 rounded-full text-sm font-semibold">Terpopuler</span>
          </div>
          @endif
          <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $package['name'] }}</h3>
          <div class="mb-6">
            <span class="text-4xl font-bold text-primary">Rp {{ $package['price'] }}</span>
            <span class="text-gray-600">/event</span>
          </div>
          <ul class="space-y-4 mb-8">
            @foreach($package['features'] as $feature)
            <li class="flex items-start">
              <svg class="w-6 h-6 text-primary mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              <span class="text-gray-700">{{ $feature }}</span>
            </li>
            @endforeach
          </ul>
          <a href="#contact" class="block w-full text-center @if($package['popular']) bg-primary text-white @else bg-gray-100 text-primary @endif px-6 py-4 rounded-full font-semibold hover:opacity-90 transition">
            Booking Sekarang
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Testimonials --}}
  <section id="testimonials" class="py-20 px-4 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Apa Kata Mereka</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Kepercayaan klien adalah prioritas utama kami
        </p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        @php
          $testimonials = [
            ['name' => 'Sarah & Daniel', 'event' => 'Wedding', 'text' => 'EventPro membuat hari pernikahan kami sempurna! Setiap detail diperhatikan dengan baik. Tim yang sangat profesional dan responsif. Highly recommended!', 'rating' => 5],
            ['name' => 'PT Maju Jaya', 'event' => 'Corporate Event', 'text' => 'Kami sangat puas dengan penyelenggaraan seminar tahunan kami. Profesional, tepat waktu, dan hasil melampaui ekspektasi. Terima kasih!', 'rating' => 5],
            ['name' => 'Budi Santoso', 'event' => 'Birthday Party', 'text' => 'Pesta ulang tahun anak saya luar biasa! Dekorasi cantik, hiburan seru, dan semua tamu terkesan. Worth every penny!', 'rating' => 5]
          ];
        @endphp
        @foreach($testimonials as $testimonial)
        <div class="bg-white p-8 rounded-2xl hover:shadow-xl transition border border-gray-100">
          <div class="flex mb-4">
            @for($i = 0; $i < $testimonial['rating']; $i++)
            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            @endfor
          </div>
          <p class="text-gray-700 mb-6 italic">"{{ $testimonial['text'] }}"</p>
          <div>
            <p class="font-bold text-gray-900">{{ $testimonial['name'] }}</p>
            <p class="text-sm text-primary">{{ $testimonial['event'] }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Footer --}}
  <footer id="contact" class="bg-gray-900 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto">
      <div class="grid md:grid-cols-4 gap-8 mb-12">
        <div class="md:col-span-2">
          <h3 class="text-3xl font-bold mb-4">EventPro</h3>
          <p class="text-gray-400 mb-6 max-w-md">
            Mitra terpercaya Anda dalam mewujudkan event impian. Dengan pengalaman lebih dari 10 tahun, kami siap memberikan layanan terbaik.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-primary transition">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-primary transition">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-primary transition">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
          </div>
        </div>
        <div>
          <h4 class="text-lg font-bold mb-4">Navigasi</h4>
          <ul class="space-y-2">
            <li><a href="#home" class="text-gray-400 hover:text-white transition">Home</a></li>
            <li><a href="#about" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
            <li><a href="#services" class="text-gray-400 hover:text-white transition">Layanan</a></li>
            <li><a href="#venues" class="text-gray-400 hover:text-white transition">Venue</a></li>
            <li><a href="#pricing" class="text-gray-400 hover:text-white transition">Harga</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-bold mb-4">Kontak</h4>
          <ul class="space-y-3">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-primary mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              <span class="text-gray-400">Jl. Merdeka No. 123<br>Jakarta Pusat, 10110</span>
            </li>
            <li class="flex items-center">
              <svg class="w-5 h-5 text-primary mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
              <span class="text-gray-400">+62 812-3456-7890</span>
            </li>
            <li class="flex items-center">
              <svg class="w-5 h-5 text-primary mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <span class="text-gray-400">info@eventpro.com</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
        <p>&copy; {{ date('Y') }} EventPro. All rights reserved. Made with ❤️ in Indonesia</p>
      </div>
    </div>
  </footer>

  <script>
    // Fetch venues dari API (public, tanpa auth)
    const API_URL = window.location.origin + '/api';

    async function loadVenues() {
      try {
        const response = await fetch(`${API_URL}/venues?limit=6`);  // Limit 6 buat grid 3 cols, adjust di backend kalau perlu

        if (!response.ok) throw new Error('Failed to fetch venues');
        const json = await response.json();
        const venues = json.data || json || [];

        const grid = document.getElementById('venuesGrid');

        if (!Array.isArray(venues) || venues.length === 0) {
          grid.innerHTML = '<div class="col-span-full text-center py-12"><p class="text-gray-600">No venues available</p></div>';
          return;
        }

        // Tampilkan max 6 venues
        const displayVenues = venues.slice(0, 6);
        grid.innerHTML = displayVenues.map(venue => `
          <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition group">
            <div class="h-64 relative overflow-hidden">
              ${venue.file_path ?
                `<img src="/storage/${venue.file_path}" alt="${venue.name}" class="w-full h-full object-cover" />` :
                `<div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                  <svg class="w-32 h-32 text-primary/30" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                  </svg>
                </div>`
              }
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">${venue.name}</h3>
              <p class="text-primary font-semibold mb-3">Kapasitas: ${venue.capacity} Orang</p>
              <p class="text-gray-600 mb-4">${venue.facilities || 'Fasilitas lengkap'}</p>
              <a href="#pricing" class="inline-block text-primary font-semibold hover:underline">
                Lihat Paket →
              </a>
            </div>
          </div>
        `).join('');
      } catch (error) {
        console.error('Error loading venues:', error);
        document.getElementById('venuesGrid').innerHTML = '<div class="col-span-full text-center py-12"><p class="text-red-500">Error loading venues. Please try again later.</p></div>';
      }
    }

    // Load saat DOM ready
    document.addEventListener('DOMContentLoaded', loadVenues);
  </script>

</body>
</html>
