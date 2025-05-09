<?php

namespace App\Console\Commands;

use App\Models\Liputan;
use App\Models\Promosi;
use Illuminate\Console\Command;

class HapusVerifikasiKedaluwarsa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:hapus-verifikasi-kadaluwarsa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus data permintaan publikasi yang belum terverifikasi dan sudah kedaluwarsa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Hapus data liputan invalid
        $liputan_invalid = Liputan::where('status_verifikasi', 'Tidak Terverifikasi')
            ->where('created_at', '<=', now()->subMinutes(15))
            ->get();

        foreach ($liputan_invalid as $liputan) {
            $liputan->delete();
        }

        // Hapus data promosi invalid
        $promosi_invalid = Promosi::where('status_verifikasi', 'Tidak Terverifikasi')
            ->where('created_at', '<=', now()->subMinutes(15))
            ->get();

        foreach ($promosi_invalid as $promosi) {
            $promosi->delete();
        }
    }
}
