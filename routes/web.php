<?php

use App\Http\Controllers\logout;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsKemahasiswaan;
use App\Http\Middleware\IsMahasiswa;
use App\Http\Middleware\IsNotLogin;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->middleware(IsNotLogin::class)->group(function () {
          Route::get('/', App\Livewire\Home\Index::class)->name('home');
          Route::get('/fasilitas', App\Livewire\Home\Fasilitas::class)->name('home.fasilitas');
          Route::get('/kegiatan', App\Livewire\Home\Kegiatan::class)->name('home.kegiatan');
          Route::get('/login', App\Livewire\Login::class)->name('login');
});
Route::prefix('admin')->middleware(IsAdmin::class)->group(function () {
          Route::get('/', \App\Livewire\Admin\Index::class)->name('admin.index');
});
Route::prefix('kemahasiswaan')->middleware(IsKemahasiswaan::class)->group(function () {
          Route::get('/', \App\Livewire\Kemahasiswaan\Index::class)->name('kemahasiswaan.index');
});
Route::prefix('mahasiswa')->middleware(IsMahasiswa::class)->group(function () {
          Route::get('/', \App\Livewire\Mahasiswa\Index::class)->name('mahasiswa.index');
});

Route::get('/logout', [logout::class, 'logout'])->name('logout');