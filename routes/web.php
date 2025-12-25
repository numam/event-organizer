<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;

Route::get('/', function () {
    return view('welcome');
});

// Web (Blade) auth routes
Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->name('web.register');

Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('web.login');

Route::post('/logout', [WebAuthController::class, 'logout'])->name('web.logout');

Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/venues', [WebAuthController::class, 'venues'])->name('venues.index');
Route::get('/dashboard/venues/create', function() { return view('venues.create'); })->name('venues.create');
Route::get('/dashboard/venues/{slug}/edit', function($slug) { return view('venues.edit', compact('slug')); })->name('venues.edit');
Route::get('/dashboard/events', [WebAuthController::class, 'events'])->name('events.index');
Route::get('/dashboard/events/create', function() { return view('events.create'); })->name('events.create');
Route::get('/dashboard/events/{slug}/edit', function($slug) { return view('events.edit', compact('slug')); })->name('events.edit');
