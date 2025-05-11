<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unit')->insert([
            [
                'nama_unit' => 'Kemahasiswaan',
                'deskripsi' => 'Unit yang mengelola kegiatan mahasiswa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Biro',
                'deskripsi' => 'Unit yang mengelola administrasi dan layanan umum.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Lembaga',
                'deskripsi' => 'Unit yang mengelola kegiatan penelitian dan pengabdian masyarakat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Fakultas',
                'deskripsi' => 'Unit yang mengelola kegiatan akademik di tingkat fakultas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Unit',
                'deskripsi' => 'Unit yang mengatur kegiatan di tingkat universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Pusat',
                'deskripsi' => 'Unit yang mengelola kegiatan penelitian dan pengembangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Sekretariat',
                'deskripsi' => 'Unit yang mengelola administrasi dan dokumentasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Direktorat',
                'deskripsi' => 'Unit yang mengelola kegiatan di tingkat direktorat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
