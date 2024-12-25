<?php

namespace Database\Factories;

use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Angsuran>
 */
class AngsuranFactory extends Factory
{
    protected $model = Angsuran::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pinjaman' => Pinjaman::factory(),
            'tanggal_angsuran' => $this->faker->date(),
            'jumlah_angsuran' => $this->faker->randomFloat(2, 100000, 1000000),
            'status' => $this->faker->randomElement(['Lunas', 'Belum Lunas']),
        ];
    }
}
