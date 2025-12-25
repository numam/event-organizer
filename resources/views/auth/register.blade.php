<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Event Organizer') }} – Register</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
  class="min-h-screen font-primary antialiased
  bg-[radial-gradient(ellipse_at_top_left,_rgba(139,92,246,0.18),_transparent_50%),radial-gradient(ellipse_at_bottom_right,_rgba(99,102,241,0.18),_transparent_50%),linear-gradient(to_br,_#faf5ff,_#eef2ff)]">

  <!-- BACKGROUND BLUR ACCENT -->
  <div class="fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-40 -left-40 w-[28rem] h-[28rem] bg-purple-400/20 rounded-full blur-3xl"></div>
    <div class="absolute top-1/3 -right-40 w-[28rem] h-[28rem] bg-indigo-400/20 rounded-full blur-3xl"></div>
  </div>

  <div class="min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

      <!-- LEFT CONTENT -->
      <div class="hidden md:block">
        <span class="text-sm tracking-widest text-purple-600 font-semibold">
          PREMIUM EVENT ORGANIZER
        </span>

        <h1 class="mt-4 text-4xl font-bold text-gray-900 leading-tight">
          Start Creating <br>
          <span class="text-purple-600">Extraordinary Events</span>
        </h1>

        <p class="mt-4 text-gray-600 max-w-md">
          Join our premium platform to manage events with elegance,
          precision, and seamless experience.
        </p>
      </div>

      <!-- REGISTER CARD -->
      <div class="bg-white/90 backdrop-blur rounded-2xl shadow-xl p-8 sm:p-10">

        <div class="mb-8">
          <h2 class="text-2xl font-bold text-gray-900">
            Create Account
          </h2>
          <p class="text-gray-500 mt-1">
            Sign up to get started
          </p>
        </div>

        <!-- ERROR MESSAGE -->
        @if ($errors->any())
          <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-600">
            <ul class="list-disc list-inside space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('web.register') }}" class="space-y-5">
          @csrf

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Full Name
            </label>
            <input
              type="text"
              name="name"
              value="{{ old('name') }}"
              required
              class="w-full rounded-xl border border-gray-400 focus:border-purple-500 focus:ring-purple-500 py-2 px-3"
              placeholder="Your name"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Email Address
            </label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              required
              class="w-full rounded-xl border border-gray-400 focus:border-purple-500 focus:ring-purple-500 py-2 px-3"
              placeholder="you@email.com"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Password
            </label>
            <input
              type="password"
              name="password"
              required
              class="w-full rounded-xl border border-gray-400 focus:border-purple-500 focus:ring-purple-500 py-2 px-3"
              placeholder="••••••••"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Confirm Password
            </label>
            <input
              type="password"
              name="password_confirmation"
              required
              class="w-full rounded-xl border border-gray-400 focus:border-purple-500 focus:ring-purple-500 py-2 px-3"
              placeholder="••••••••"
            >
          </div>

          <button
            type="submit"
            class="w-full mt-4 rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 px-4 py-3 text-white font-semibold hover:opacity-90 transition">
            Create Account
          </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
          Already have an account?
          <a href="{{ route('login') }}" class="text-purple-600 font-medium hover:underline">
            Login
          </a>
        </p>

      </div>
    </div>
  </div>

</body>
</html>
