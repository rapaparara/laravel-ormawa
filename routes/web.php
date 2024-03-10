<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', App\Livewire\Home\Index::class)->name('home');
Route::get('/fasilitas', App\Livewire\Home\Fasilitas::class)->name('home.fasilitas');
Route::get('/kegiatan', App\Livewire\Home\Kegiatan::class)->name('home.kegiatan');
Route::get('/login', App\Livewire\Login::class)->name('login');
