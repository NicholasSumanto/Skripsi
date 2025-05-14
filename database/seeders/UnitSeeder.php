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
                'nama_unit' => 'Pusat',
                'deskripsi' => 'Unit yang mengelola kegiatan penelitian dan pengembangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Direktorat',
                'deskripsi' => 'Unit yang mengelola kegiatan di tingkat direktorat.',
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
                'nama_unit' => 'Unit',
                'deskripsi' => 'Unit yang mengatur kegiatan di tingkat universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Lembaga Kemahasiswaan',
                'deskripsi' => 'Unit yang mengelola kegiatan mahasiswa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Unit Kegiatan Mahasiswa',
                'deskripsi' => 'Unit yang mengelola unit kegiatan mahasiswa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Unit Kegiatan Kebudayaan',
                'deskripsi' => 'Unit Kegiatan Kebudayaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Unit Kegiatan Kerohanian',
                'deskripsi' => 'Unit Kegiatan Kerohanian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // unit fakultas
            [
                'nama_unit' => 'Fakultas Teologi',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang teologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Fakultas Arsitektur dan Desain',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang arsitektur dan desain.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Fakultas Bioteknologi',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang bioteknologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Fakultas Bisnis',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang bisnis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Fakultas Teknologi Informasi',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Fakultas Kedokteran',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang kedokteran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_unit' => 'Fakultas Kependidikan dan Humaniora',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
