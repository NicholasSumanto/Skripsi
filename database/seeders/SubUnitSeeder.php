<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = DB::table('unit')->pluck('id_unit', 'nama_unit');

        DB::table('sub_unit')->insert([
            // Sub-unit Kemahasiswaan
            [
                'id_unit' => $units['Kemahasiswaan'],
                'nama_sub_unit' => 'BPMU',
                'deskripsi' => 'Badan Perwakilan Mahasiswa Universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Kemahasiswaan'],
                'nama_sub_unit' => 'BEMU',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Kemahasiswaan'],
                'nama_sub_unit' => 'BEMT',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Kemahasiswaan'],
                'nama_sub_unit' => 'BEMU',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Teologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Biro
            [
                'id_unit' => $units['Biro'],
                'nama_sub_unit' => 'Biro I',
                'deskripsi' => 'Mengelola kebutuhan administrasi umum.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Biro'],
                'nama_sub_unit' => 'Biro II',
                'deskripsi' => 'Mengelola Keuangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Fakultas
            [
                'id_unit' => $units['Fakultas'],
                'nama_sub_unit' => 'Fakultas Teknologi Infomratika',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang teknik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas'],
                'nama_sub_unit' => 'Fakultas Ekonomi Bisnis',
                'deskripsi' => 'Menyelenggarakan pendidikan di bidang ekonomi dan bisnis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Pusat
            [
                'id_unit' => $units['Pusat'],
                'nama_sub_unit' => 'PUSPINdiKa',
                'deskripsi' => 'Melakukan kajian tentang isu gender.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Pusat'],
                'nama_sub_unit' => 'PPB',
                'deskripsi' => 'Mengembangkan inovasi dan teknologi baru.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
