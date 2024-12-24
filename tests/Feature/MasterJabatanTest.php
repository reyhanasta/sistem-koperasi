<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\MasterJabatan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MasterJabatanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_master_jabatan()
    {
        $masterJabatan = MasterJabatan::create([
            'code' => 'MJ001',
            'name' => 'Manager',
        ]);

        $this->assertDatabaseHas('master_jabatans', [
            'code' => 'MJ001',
            'name' => 'Manager',
        ]);
    }

    /** @test */
    public function it_can_update_a_master_jabatan()
    {
        $masterJabatan = MasterJabatan::factory()->create();

        $masterJabatan->update([
            'name' => 'Senior Manager',
        ]);

        $this->assertDatabaseHas('master_jabatans', [
            'id' => $masterJabatan->id,
            'name' => 'Senior Manager',
        ]);
    }

    /** @test */
    public function it_can_delete_a_master_jabatan()
    {
        $masterJabatan = MasterJabatan::factory()->create();

        $masterJabatan->delete();

        $this->assertDatabaseMissing('master_jabatans', [
            'id' => $masterJabatan->id,
        ]);
    }
    
}
