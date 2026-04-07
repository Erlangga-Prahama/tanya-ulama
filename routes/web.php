<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Route::livewire('/posts/index', 'pages::post.index')->name('posts.index');
    Route::livewire('/posts/create', 'pages::post.create')->name('posts.create');
    Route::livewire('/posts/{id}', 'pages::post.show')->name('post.show');
});

require __DIR__.'/auth.php';
