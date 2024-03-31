<?php

namespace Database\Factories;

use App\Models\fakultas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\users_kemahasiswaan>
 */
class users_kemahasiswaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'user_id' => User::factory()->create()->id,
            'fakultas_id' => fakultas::factory()->create()->id,
        ];
    }
}
