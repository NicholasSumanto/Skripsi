<?php

namespace App\Http\Controllers;

use App\Mail\KodeProsesPublikasiMail;
use App\Models\Liputan;
use App\Models\Promosi;
use App\Models\ProsesPermohonan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PemohonController extends Controller
{
    private function buatKodeprosesPermohonan(string $token)
    {
        $split = explode('-', $token);
        $tanggal = substr($split[1], 0, 8);
        $formattedDate = date('Ymd', strtotime($tanggal));

        if ($split[0] === 'PROMO') {
            $key = 'PROMOSI-' . $formattedDate . '-' . $split[2];
        } elseif ($split[0] === 'LIPUT') {
            $key = 'LIPUTAN-' . $formattedDate . '-' . $split[2];
        }
        return $key;
    }
    public function home()
    {
        return view('pemohon.home');
    }

    public function verifikasiTest()
    {
        return view('pemohon.verification-test');
    }

    public function agenda()
    {
        return view('pemohon.agenda');
    }

    public function liputan()
    {
        return view('pemohon.publikasi.liputan');
    }

    public function promosi()
    {
        return view('pemohon.publikasi.promosi');
    }


    public function verifikasi($token)
    {
        // Cari apakah publikasi atau permohonan dengan token ini
        $split = explode('-', $token);

        if ($split[0] === 'PROMO') {
            $promosi = Promosi::where('id_verifikasi_publikasi', $token)->first();

            if ($promosi) {
                if ($promosi->id_proses_permohonan) {
                    $data = [
                        'status' => 'success',
                        'publikasi' => 'Promosi',
                        'id_proses_permohonan' => $promosi->id_proses_permohonan,
                    ];
                } else {
                    $key = $this->buatKodeprosesPermohonan($token);
                    ProsesPermohonan::create([
                        'id_proses_permohonan' => $key,
                        'status' => 'Diterima',
                        'tanggal_diterima' => Carbon::now(),
                    ]);

                    $promosi->update([
                        'status_verifikasi' => 'Terverifikasi',
                        'id_proses_permohonan' => $key,
                    ]);

                    $data = [
                        'status' => 'success',
                        'publikasi' => 'Promosi',
                        'id_proses_permohonan' => $key,
                    ];
                }

                Mail::to(Auth::user()->email)->send(new KodeProsesPublikasiMail(Auth::user()->name, 'Publikasi Promosi', $promosi->id_proses_permohonan ?? $key));

            } else {
                $data = [
                    'status' => 'error',
                ];
            }

            return view('pemohon.verifikasi')->with('data', $data);
        } elseif ($split[0] === 'LIPUT') {
            $liputan = Liputan::where('id_verifikasi_publikasi', $token)->first();

            if ($liputan) {
                if ($liputan->id_proses_permohonan) {
                    $data = [
                        'status' => 'success',
                        'publikasi' => 'Liputan',
                        'id_proses_permohonan' => $liputan->id_proses_permohonan,
                    ];
                } else {
                    $key = $this->buatKodeprosesPermohonan($token);

                    ProsesPermohonan::create([
                        'id_proses_permohonan' => $key,
                        'status' => 'Diterima',
                        'tanggal_diterima' => Carbon::now(),
                    ]);

                    $liputan->update([
                        'status_verifikasi' => 'Terverifikasi',
                        'id_proses_permohonan' => $key,
                    ]);

                    $data = [
                        'status' => 'success',
                        'publikasi' => 'Liputan',
                        'id_proses_permohonan' => $key,
                    ];
                }

                Mail::to(Auth::user()->email)->send(new KodeProsesPublikasiMail(Auth::user()->name, 'Publikasi Promosi', $liputan->id_proses_permohonan ?? $key));

            } else {
                $data = [
                    'status' => 'error',
                ];
            }

            return view('pemohon.verifikasi')->with('data', $data);
        } else {
            $data = [
                'status' => 'error',
            ];
            return view('pemohon.verifikasi')->with('data', $data);
        }
    }
}
