<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\fakultas;
use App\Models\User;
use App\Models\users_kemahasiswaan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan seeder untuk tabel Users
        $this->call(UserSeeder::class);
        // Menjalankan seeder untuk tabel Fakultas
        $this->call(FakultasSeeder::class);
        // Menjalankan seeder untuk tabel UsersKemahasiswaan
        $this->call(users_kemahasiswaanSeeder::class);
    }
}
