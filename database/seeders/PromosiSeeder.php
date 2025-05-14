<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PromosiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $googleIds = DB::table('pengguna')->pluck('google_id')->toArray();
        $subUnitIds = DB::table('sub_unit')->pluck('id_sub_unit')->toArray();
        $prosesIds = DB::table('proses_permohonan')->pluck('id_proses_permohonan')->toArray();

        // menentukan apakah proses id untuk promosi atau liputan
        $prosesIds = array_filter($prosesIds, function ($id) {
            return str_starts_with($id, 'PROMOSI-');
        });

        for ($i = 1; $i <= 5; $i++) {
            $idSubUnit = fake()->randomElement($subUnitIds);
            $idProses = fake()->randomElement($prosesIds);
            $prosesIds = array_values(array_diff($prosesIds, [$idProses]));

            DB::table('promosi')->insert([
                'google_id' => fake()->randomElement($googleIds),
                'id_sub_unit' => $idSubUnit,
                'id_proses_permohonan' => $idProses,
                'id_verifikasi_publikasi' => 'PROMO-' . Str::random(54),
                'judul' => 'Judul Promosi ke-' . $i,
                'status_verifikasi' => fake()->randomElement(['Terverifikasi', 'Tidak Terverifikasi']),
                'nama_pemohon' => fake()->name(),
                'nomor_handphone' => fake()->phoneNumber(),
                'tempat' => fake()->city(),
                'tanggal' => fake()->date(),
                'output' => 'Output Promosi ke-' . $i,
                'file_stories' => 'stories_' . $i . '.jpg',
                'file_poster' => 'poster_' . $i . '.png',
                'file_video' => 'video_' . $i . '.mp4',
                'catatan' => fake()->optional()->sentence(),
                'tautan_promosi' => fake()->optional()->url(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
