<?php

namespace Tests\Feature;

use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_all_students(): void
    {
        Siswa::create([
            'nis' => '10001',
            'nama' => 'Test Siswa 1',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2008-01-01',
            'agama' => 'Islam',
            'alamat' => 'Jl. Test No. 1',
            'kelas' => 'X-RPL-1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'tahun_masuk' => '2024',
        ]);

        Siswa::create([
            'nis' => '10002',
            'nama' => 'Test Siswa 2',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2008-02-02',
            'agama' => 'Islam',
            'alamat' => 'Jl. Test No. 2',
            'kelas' => 'X-RPL-2',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'tahun_masuk' => '2024',
        ]);

        $this->assertEquals(2, Siswa::count());

        $response = $this->deleteJson('/api/siswas');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'total_deleted' => 2,
            ]);

        $this->assertEquals(0, Siswa::count());
    }
}
