<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{

    protected $model = Pegawai::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;

        return [
            'name' =>  $name,
            'profile_pict' => $this->faker->imageUrl(),
            'user_id' => User::factory()->create(['name' => $name])->assignRole('staff')->id,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'position' => $this->faker->jobTitle,
            'email' => $this->faker->unique()->safeEmail,
            // 'gaji' => $this->faker->numberBetween(1000000, 10000000),
            'gaji' => 1000000,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'email_verified_at' => now(),
            'join_date' => $this->faker->date(),
            'desc' => $this->faker->text,
            // 'status' => $this->faker->randomElement(['kontrak', 'tetap']),
            'status' => 'kontrak',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
