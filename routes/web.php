<?php

use App\Http\Controllers\logout;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsKemahasiswaan;
use App\Http\Middleware\IsMahasiswa;
use App\Http\Middleware\IsNotLogin;
use Illuminate\Support\Facades\Route;



Route::get('/fasilitas', App\Livewire\Home\Fasilitas::class)->name('home.fasilitas');
Route::get('/kegiatan', App\Livewire\Home\Kegiatan::class)->name('home.kegiatan');

Route::prefix('/')->middleware(IsNotLogin::class)->group(function () {
          Route::get('/', App\Livewire\Home\Index::class)->name('home');
          Route::get('/login', App\Livewire\Login::class)->name('login');
});
Route::prefix('admin')->middleware(IsAdmin::class)->group(function () {
          Route::get('/', \App\Livewire\Admin\Index::class)->name('admin.index');
          Route::get('/pengguna', \App\Livewire\Admin\Pengguna::class)->name('admin.pengguna');
          Route::get('/fakultas', \App\Livewire\Admin\Fakultas::class)->name('admin.fakultas');
          Route::get('/kemahasiswaan', \App\Livewire\Admin\Kemahasiswaan::class)->name('admin.kemahasiswaan');
          Route::get('/periode', \App\Livewire\Admin\Periode::class)->name('admin.periode');
});
Route::prefix('kemahasiswaan')->middleware(IsKemahasiswaan::class)->group(function () {
          Route::get('/', \App\Livewire\Kemahasiswaan\Index::class)->name('kemahasiswaan.index');
          Route::get('/ormawa', \App\Livewire\Kemahasiswaan\Ormawa::class)->name('kemahasiswaan.ormawa');
          Route::get('/pengguna', \App\Livewire\Kemahasiswaan\Pengguna::class)->name('kemahasiswaan.pengguna');
          Route::get('/fasilitas', \App\Livewire\Kemahasiswaan\Fasilitas::class)->name('kemahasiswaan.fasilitas');
          Route::get('/kepengurusan', \App\Livewire\Kemahasiswaan\Kepengurusan::class)->name('kemahasiswaan.kepengurusan');
});
Route::prefix('mahasiswa')->middleware(IsMahasiswa::class)->group(function () {
          Route::get('/', \App\Livewire\Mahasiswa\Index::class)->name('mahasiswa.index');
          Route::get('/fasilitas', \App\Livewire\Mahasiswa\Fasilitas::class)->name('mahasiswa.fasilitas');
          Route::get('/kepengurusan', \App\Livewire\Mahasiswa\Kepengurusan::class)->name('mahasiswa.kepengurusan');
});

Route::get('/logout', [logout::class, 'logout'])->name('logout');
