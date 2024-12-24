<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Nasabah;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NasabahTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_nasabah()
    {
        $nasabah = Nasabah::create([
            'name' => 'John Doe',
            'ktp' => '1234567890123456',
            'gender' => 'male',
            'phone' => '081234567890',
            'ktp_image_path' => 'path/to/ktp_image.jpg',
            'address' => '123 Main St',
            'date_of_birth' => '1990-01-01',
            'closure_date' => null,
        ]);

        $this->assertDatabaseHas('nasabahs', [
            'name' => 'John Doe',
            'ktp' => '1234567890123456',
            'gender' => 'male',
            'phone' => '081234567890',
            'ktp_image_path' => 'path/to/ktp_image.jpg',
            'address' => '123 Main St',
            'date_of_birth' => '1990-01-01',
            'closure_date' => null,
        ]);
    }

    /** @test */
    public function it_can_update_a_nasabah()
    {
        $nasabah = Nasabah::factory()->create();

        $nasabah->update([
            'name' => 'Jane Doe',
            'phone' => '0987654321',
        ]);

        $this->assertDatabaseHas('nasabahs', [
            'id' => $nasabah->id,
            'name' => 'Jane Doe',
            'phone' => '0987654321',
        ]);
    }

    /** @test */
    public function it_can_delete_a_nasabah()
    {
        $nasabah = Nasabah::factory()->create();

        $nasabah->delete();

        $this->assertSoftDeleted('nasabahs', [
            'id' => $nasabah->id,
        ]);
    }
}