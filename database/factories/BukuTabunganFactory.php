<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BukuTabungan>
 */
class BukuTabunganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_rek' => $this->faker->unique()->numerify('2024####'),
            'nasabah_id' => \App\Models\Nasabah::factory(),
            'balance' => $this->faker->numberBetween(100000, 10000000),
            'status' => $this->faker->randomElement(['aktif', 'non-aktif']),
            'notes' => $this->faker->sentence(),
            'closed_date' => $this->faker->optional()->dateTime(),
        ];
    }
}
