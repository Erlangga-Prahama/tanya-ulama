<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('/daftar-ustaz', 'admin::ustaz.index')->name('admin.ustaz-index');
    Route::livewire('/verifikasi-ustaz', 'admin::ustaz.verification')->name('admin.ustaz-verification');
    Route::livewire('/verifikasi-ustaz/{id}', 'admin::ustaz.verification-show')->name('admin.ustaz-verification-show');
    Route::livewire('/laporan', 'admin::report.index')->name('admin.reports');
    Route::livewire('/pelanggar', 'admin::report.offender')->name('admin.offender');
    Route::livewire('/laporan/{id}', 'admin::report.show')->name('admin.reports.show');
});
    


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Route::livewire('/posts/index', 'pages::post.index')->name('posts.index');
    Route::livewire('/posts/create', 'pages::post.create')->name('posts.create');
    Route::livewire('/posts/{id}', 'pages::post.show')->name('post.show');
    Route::livewire('/my-posts', 'pages::post.user-posts')->name('post.user-posts');
});

require __DIR__.'/auth.php';
