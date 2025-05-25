<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProsesPermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Status yang akan digunakan
        $statuses = ['Diajukan', 'Diterima', 'Diproses', 'Selesai', 'Batal'];

        for ($i = 0; $i < 4; $i++) {
            foreach ($statuses as $index => $status) {
                $tanggalDiajukan = Carbon::now()->subDays(rand(1, 30));
                $tanggalDiterima = null;
                $tanggalDiproses = null;
                $tanggalSelesai = null;
                $tanggalBatal = null;

                if (in_array($status, ['Diterima', 'Diproses', 'Selesai'])) {
                    $tanggalDiterima = $tanggalDiajukan->copy()->addDays(rand(1, 5));
                }

                if (in_array($status, ['Diproses', 'Selesai'])) {
                    $tanggalDiproses = $tanggalDiterima->copy()->addDays(rand(1, 5));
                }

                if ($status === 'Selesai') {
                    $tanggalSelesai = $tanggalDiproses->copy()->addDays(rand(1, 5));
                }

                if ($status === 'Batal') {
                    $tanggalBatal = Carbon::now();
                }

                DB::table('proses_permohonan')->insert([
                    'id_proses_permohonan' =>  $index % 2 === 0 ? 'LIPUTAN-' . Str::random(9) : 'PROMOSI-' . Str::random(9),
                    'status' => $status,
                    'tanggal_diajukan' => $tanggalDiajukan->format('Y-m-d'),
                    'tanggal_diterima' => $tanggalDiterima?->format('Y-m-d'),
                    'tanggal_diproses' => $tanggalDiproses?->format('Y-m-d'),
                    'tanggal_selesai' => $tanggalSelesai?->format('Y-m-d'),
                    'tanggal_batal' => $tanggalBatal?->format('Y-m-d'),
                    'keterangan' => $status === 'Batal' ? fake()->sentence() : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
