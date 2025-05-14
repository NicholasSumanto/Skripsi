<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PenggunaSeeder::class,
            UnitSeeder::class,
            ProsesPermohonanSeeder::class,
            SubUnitSeeder::class,
            LiputanSeeder::class,
            PromosiSeeder::class,
        ]);
    }
}
