<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PegawaiTest extends TestCase
{
    /** @test */
    public function it_can_add_pegawai()
    {
        $user = User::factory()->create();
        $pegawai = Pegawai::factory()->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('pegawais', [
            'id' => $pegawai->id,
            'user_id' => $user->id,
            'name' => $pegawai->name,
            'email' => $pegawai->email,
        ]);
    }
    /** @test */
    public function it_belongs_to_user()
    {
        $user = User::factory()->create();
        $pegawai = Pegawai::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $pegawai->user);
        $this->assertEquals($pegawai->user->id, $user->id);
    }

    /** @test */
    public function it_has_default_values()
    {
        $pegawai = Pegawai::factory()->create();

        $this->assertEquals(1000000, $pegawai->gaji);
        $this->assertEquals('kontrak', $pegawai->status);
    }

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $pegawai = Pegawai::factory()->create();
        $pegawai->delete();

        $this->assertSoftDeleted($pegawai);
    }

    /** @test */
    public function it_can_get_full_address()
    {
        $pegawai = Pegawai::factory()->create([
            'address' => '123 Main St',
            'phone' => '555-555-5555',
        ]);

        $this->assertEquals('123 Main St, 555-555-5555', $pegawai->full_address);
    }

    /** @test */
    public function it_is_created_with_staff_role()
    {
        $pegawai = Pegawai::factory()->create();
        $this->assertTrue($pegawai->user->hasRole('staff'));
    }

     /** @test */
    public function it_has_same_name_and_email_as_user()
    {
        $pegawai = Pegawai::factory()->create();
        $this->assertEquals($pegawai->name, $pegawai->user->name);
        $this->assertEquals($pegawai->email, $pegawai->user->email);
    }
}
