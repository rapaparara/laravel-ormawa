<?php

namespace Database\Seeders;

use App\Models\fakultas;
use App\Models\User;
use App\Models\users_kemahasiswaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class users_kemahasiswaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        // Memasukkan entri koneksi antara pengguna dan fakultas secara langsung
        users_kemahasiswaan::insert([['user_id' => 1, 'fakultas_id' => 1], ['user_id' => 2, 'fakultas_id' => 2], ['user_id' => 3, 'fakultas_id' => 3], ['user_id' => 4, 'fakultas_id' => 4], ['user_id' => 5, 'fakultas_id' => 5]]);
    }
}
