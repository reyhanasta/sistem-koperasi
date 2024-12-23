<?php

namespace Database\Factories;

use App\Models\Simpanan;
use App\Models\BukuTabungan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Simpanan>
 */
class SimpananFactory extends Factory
{
    protected $model = Simpanan::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_rekening' => BukuTabungan::factory(),
            'nasabah_id' => \App\Models\Nasabah::factory(),
        ];
    }
}

