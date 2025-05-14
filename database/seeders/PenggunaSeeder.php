<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan pengguna dengan role 'pemohon'
        DB::table('pengguna')->insert([
            'google_id' => Str::random(60),
            'email' => 'pemohon@example.com',
            'token' => Str::random(60),
            'name' => 'Pemohon User',
            'avatar' => 'default-avatar.png',
            'role' => 'pemohon',
            'remember_token' => Str::random(60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Menambahkan pengguna dengan role 'staff'
        DB::table('pengguna')->insert([
            'google_id' => Str::random(60),
            'email' => 'staff@example.com',
            'token' => Str::random(60),
            'name' => 'Staff User',
            'avatar' => 'staff-avatar.png',
            'role' => 'staff',
            'remember_token' => Str::random(60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Menambahkan pengguna lainnya (jika diperlukan)
        for ($i = 1; $i <= 3; $i++) {
            DB::table('pengguna')->insert([
                'google_id' => Str::random(60),
                'email' => fake()->unique()->safeEmail(),
                'token' => Str::random(60),
                'name' => fake()->name(),
                'avatar' => 'default-avatar.png',
                'role' => fake()->randomElement(['pemohon', 'staff']),
                'remember_token' => Str::random(60),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
