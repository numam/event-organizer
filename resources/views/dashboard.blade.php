@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-10">

    <!-- Header -->
    <header>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Dashboard
        </h1>
        <p class="mt-2 text-gray-500">
            Premium Event Organizer Platform
        </p>
    </header>

    <!-- Loading -->
    <div id="loading" class="text-gray-500">
        Loading dashboard...
    </div>

    <!-- Content -->
    <div id="content" class="hidden space-y-10">

        <!-- Welcome Card -->
        <section class="bg-white rounded-2xl shadow-lg p-8">
            <p class="text-sm text-gray-500">Welcome back</p>
            <h2 class="mt-1 text-2xl font-semibold text-gray-900">
                <span id="userName">User</span>
            </h2>
            <p class="mt-1 text-gray-500">
                <span id="userEmail">email@example.com</span>
            </p>
        </section>

        <!-- Stats -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm text-gray-500">Total Events</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">12</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm text-gray-500">Venues</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">5</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm text-gray-500">Upcoming Events</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">3</p>
            </div>

        </section>


    </div>

</div>

{{-- SCRIPT ASLI — TIDAK DIUBAH --}}
<script>
(function () {
    const token = localStorage.getItem('auth_token');
    const contentDiv = document.getElementById('content');
    const loadingDiv = document.getElementById('loading');
    const logoutBtn = document.getElementById('logoutBtn');

    function redirectToLogin() {
        localStorage.removeItem('auth_token');
        window.location.href = '/login';
    }

    if (!token) {
        redirectToLogin();
        return;
    }

    fetch('/api/auth/me', {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json',
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();
        return res.json();
    })
    .then(user => {
        document.getElementById('userName').textContent = user.name ?? 'User';
        document.getElementById('userEmail').textContent = user.email ?? '';
        loadingDiv.classList.add('hidden');
        contentDiv.classList.remove('hidden');
    })
    .catch(() => redirectToLogin());

    if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
            fetch('/api/auth/logout', {
                method: 'POST',
                headers: { 'Authorization': 'Bearer ' + token }
            }).finally(() => {
                localStorage.removeItem('auth_token');
                window.location.href = '/';
            });
        });
    }
})();
</script>

@endsection
