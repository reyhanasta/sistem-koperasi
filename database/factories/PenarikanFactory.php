<?php

namespace Database\Factories;

use App\Models\Nasabah;
use App\Models\BukuTabungan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penarikan>
 */
class PenarikanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_rekening' => BukuTabungan::factory(),
            'nasabah_id' => Nasabah::factory(),
            'amount' => $this->faker->numberBetween(1000, 1000000),
            'desc' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
