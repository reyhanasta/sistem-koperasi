<?php

namespace Database\Factories;

use App\Models\Nasabah;
use App\Models\Pegawai;
use App\Models\Pinjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pinjaman>
 */
class PinjamanFactory extends Factory
{
    protected $model = Pinjaman::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nasabah_id' => Nasabah::factory(),
            'id_pegawai' => Pegawai::factory(),
            'kode_pinjaman' => $this->faker->unique()->numerify('P######'),
            'tanggal_pengajuan' => $this->faker->date(),
            'tanggal_persetujuan' => $this->faker->optional()->date(),
            'jumlah_pinjaman' => $this->faker->randomFloat(2, 1000, 1000000),
            'jenis_usaha' => $this->faker->word(),
            'jangka_waktu' => $this->faker->numberBetween(1, 60),
            'bunga' => $this->faker->randomFloat(2, 0, 20),
            'status' => $this->faker->randomElement(['diajukan', 'berlangsung', 'disetujui', 'dicairkan', 'tertunggak', 'ditolak', 'lunas', 'dibatalkan', 'validasi']),
            'metode_pembayaran' => $this->faker->randomElement(['cash', 'transfer']),
            'tanggal_pelunasan' => $this->faker->optional()->date(),
            'total_pembayaran' => 100,
            'angsuran' => $this->faker->randomFloat(2, 100, 10000),
            'jumlah_angsuran' => $this->faker->numberBetween(1, 60),
            'sisa_pinjaman' => $this->faker->randomFloat(2, 0, 1000000),
            'catatan' => $this->faker->optional()->text(),
        ];
    }
}
