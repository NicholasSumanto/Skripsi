<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LiputanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil google_id dari pengguna, id_unit dari unit, dan id_sub_unit dari sub_unit
        $googleIds = DB::table('pengguna')->pluck('google_id')->toArray();
        $subUnitIds = DB::table('sub_unit')->pluck('id_sub_unit')->toArray();
        $prosesIds = DB::table('proses_permohonan')->pluck('id_proses_permohonan')->toArray();

        $prosesIds = array_filter($prosesIds, function ($id) {
            return str_starts_with($id, 'LIPUTAN-');
        });

        for ($i = 1; $i <= 5; $i++) {
            // Pilih id_unit secara acak
            // Pilih id_sub_unit yang berhubungan dengan id_unit
            $idSubUnit = fake()->randomElement($subUnitIds);
            $idProses = fake()->randomElement($prosesIds);
            $prosesIds = array_values(array_diff($prosesIds, [$idProses]));

            DB::table('liputan')->insert([
                'google_id' => fake()->randomElement($googleIds),
                'id_sub_unit' => $idSubUnit,  // Gunakan id_sub_unit yang sesuai dengan id_unit
                'id_proses_permohonan' => $idProses,
                'id_verifikasi_publikasi' => 'LIPUT-' . Str::random(54),
                'judul' => 'Judul Liputan ke-' . $i,
                'status_verifikasi' => fake()->randomElement(['Terverifikasi', 'Tidak Terverifikasi']),
                'nama_pemohon' => fake()->name(),
                'nomor_handphone' => fake()->phoneNumber(),
                'tempat' => fake()->city(),
                'tanggal' => fake()->date(),
                'waktu' => fake()->dateTime(),
                'wartawan' => fake()->randomElement(['Ya', 'Tidak']),
                'file_liputan' => 'file_liputan_' . $i . '.pdf',
                'output' => 'Output Liputan ke-' . $i,
                'catatan' => fake()->optional()->sentence(),
                'tautan_liputan' => fake()->optional()->url(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
