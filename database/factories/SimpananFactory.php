<?php
namespace Database\Factories;

use App\Models\Simpanan;
use App\Models\BukuTabungan;
use App\Models\Nasabah;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'nasabah_id' => Nasabah::factory(),
            'pegawai_id' => Pegawai::factory(),
            'kode_simpanan' => 'KS' . $this->faker->unique()->numerify('######'),
            'type' => $this->faker->randomElement(['deposit', 'withdrawal']),
            'nominal' => $this->faker->numberBetween(100000, 10000000),
            'saldo_akhir' => $this->faker->numberBetween(100000, 10000000),
            'desc' => $this->faker->sentence(),
        ];
    }
}

