<?php

namespace App\Http\Controllers;

use App\Mail\KodeProsesPublikasiMail;
use App\Models\Liputan;
use App\Models\Promosi;
use App\Models\ProsesPermohonan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\VerifikasiPublikasiMail;
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

    public function lacak($lacak = null)
    {
        if ($lacak) {
            $data = [
                'lacak' => $lacak,
            ];
        } else {
            $data = [
                'lacak' => null,
            ];
        }
        return view('pemohon.lacak.lacak', $data);
    }

    public function liputan()
    {
        $unit = Unit::with('subUnits')->get();
        $subUnit = [];
        foreach ($unit as $u) {
            foreach ($u->subUnits as $sub) {
                $subUnit[$u->id_unit][] = [
                    'id_sub_unit' => $sub->id_sub_unit,
                    'nama_sub_unit' => $sub->nama_sub_unit,
                ];
            }
        }
        $data = [
            'unit' => $unit,
            'subUnit' => $subUnit,
        ];
        return view('pemohon.publikasi.liputan', $data);
    }

    public function promosi()
    {
        $unit = Unit::with('subUnits')->get();
        $subUnit = [];
        foreach ($unit as $u) {
            foreach ($u->subUnits as $sub) {
                $subUnit[$u->id_unit][] = [
                    'id_sub_unit' => $sub->id_sub_unit,
                    'nama_sub_unit' => $sub->nama_sub_unit,
                ];
            }
        }
        $data = [
            'unit' => $unit,
            'subUnit' => $subUnit,
        ];
        return view('pemohon.publikasi.promosi', $data);
    }

    public function verifikasi($token)
    {
        // Cari apakah publikasi atau permohonan dengan token ini
        $split = explode('-', $token);

        try {
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

                    $emailController = new EmailController();
                    $emailController->kodeProsesPublikasi('Promosi', $promosi->judul, $promosi->id_proses_permohonan ?? $key);
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

                    $emailController = new EmailController();
                    $emailController->kodeProsesPublikasi('Liputan', $liputan->judul, $liputan->id_proses_permohonan ?? $key);
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
        } catch (\Exception $e) {
            $data = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            return view('pemohon.verifikasi')->with('data', $data);
        }
    }
}
