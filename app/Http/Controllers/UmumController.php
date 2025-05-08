<?php

namespace App\Http\Controllers;

use App\Models\Liputan;
use App\Models\Promosi;
use App\Models\ProsesPermohonan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UmumController extends Controller
{
    private function buatKodeprosesPermohonan(string $token)
    {
        $split = explode('-', $token);
        $tanggal = substr($split[1], 0, 8);
        $formattedDate = date('Ymd', strtotime($tanggal));

        if ($split[0] === "PROMO") {
            $key =  'PROMOSI-' . $formattedDate . '-' . $split[2];
        } elseif ($split[0] === "LIPUT") {
            $key =  'LIPUTAN-' . $formattedDate . '-' . $split[2];
        }
        return $key;
    }

    public function home()
    {
        return view('umum.home');
    }

    public function unduhan()
    {
        return view('umum.unduhan');
    }

    public function checkSession(Request $request)
    {
        return response()->json(['session' => session()->all()]);
    }

    public function verifikasi($token)
    {
        // Cari apakah publikasi atau permohonan dengan token ini
        $split = explode('-', $token);

        if ($split[0] === "PROMO") {
            $promosi = Promosi::where('id_verifikasi_publikasi', $token)->first();

            if ($promosi && $promosi->id_proses_permohonan) {
                $data = [
                    'status' => 'success',
                    'publikasi' => 'Promosi',
                    'id_proses_permohonan' => $promosi->id_proses_permohonan
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
                    'id_proses_permohonan' => $key
                ];
            }
            return view('umum.verifikasi')->with('data', $data);
        } else if ($split[0] === "LIPUT") {
            $liputan = Liputan::where('id_verifikasi_publikasi', $token)->first();

            if ($liputan && $liputan->id_proses_permohonan) {
                $data = [
                    'status' => 'success',
                    'publikasi' => 'Liputan',
                    'id_proses_permohonan' => $liputan->id_proses_permohonan
                ];
            } else {
                $key  = $this->buatKodeprosesPermohonan($token);

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
                    'id_proses_permohonan' => $key
                ];
            }
            return view('umum.verifikasi')->with('data', $data);
        } else {
            $data = [
                'status' => 'error',
            ];
            return view('umum.verifikasi')->with('data', $data);
        }
    }

    public function verifikasiHalaman()
    {
        return view('email.verifikasi-publikasi')->with([
            'namaPemohon' => 'Dummy Pemohon',
            'jenisPermohonan' => 'Dummy Permohonan',
            'urlVerifikasi' => 'Dummy Kode Verifikasi',
            'waktu' => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'urlLogo' => asset('img/Duta_Wacana.png')
        ]);
    }
}
