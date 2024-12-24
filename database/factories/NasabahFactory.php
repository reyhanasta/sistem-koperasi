<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nasabah>
 */
class NasabahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
'name' => $this->faker->name,
            'ktp' => $this->faker->unique()->numerify('################'), // 16 digit KTP number
            'gender' => $this->faker->randomElement(['male', 'female']),
            'phone' => $this->faker->phoneNumber,
            'ktp_image_path' => $this->faker->imageUrl(),
            'address' => $this->faker->address,
            'date_of_birth' => $this->faker->date(),
            'closure_date' => null,        ];
    }
}
