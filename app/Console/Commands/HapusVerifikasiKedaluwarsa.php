<?php

namespace App\Console\Commands;

use App\Models\Liputan;
use App\Models\Promosi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class HapusVerifikasiKedaluwarsa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:hapus-verifikasi-kadaluwarsa';

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
            ->where('created_at', '>', now()->subMinutes(15))
            ->get();

        // Hapus File yang sudah kedaluwarsa
        if ($liputan_invalid->isNotEmpty()) {
            $liputan_invalid->each(function ($liputan) {
                if ($liputan->file_liputan) {
                    Storage::disk('local')->deleteDirectory('liputan/' . $liputan->id_verifikasi_publikasi);
                }
            });

            foreach ($liputan_invalid as $liputan) {
                $liputan->delete();
            }
        }

        // Hapus data promosi invalid
        $promosi_invalid = Promosi::where('status_verifikasi', 'Tidak Terverifikasi')
            ->where('created_at', '>', now()->subMinutes(15))
            ->get();

        // Hapus File yang sudah kedaluwarsa
        if ($promosi_invalid->isNotEmpty()) {
            $promosi_invalid->each(function ($promosi) {
                if ($promosi->file_stories || $promosi->file_poster || $promosi->file_video) {
                    Storage::disk('local')->deleteDirectory('promosi/' . $promosi->id_verifikasi_publikasi);
                }
            });

            foreach ($promosi_invalid as $promosi) {
                $promosi->delete();
            }
        }
    }
}
