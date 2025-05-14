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
use Illuminate\Support\Facades\DB;

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

    public function lacak(Request $request)
    {
        $lacak = $request->input('kode_proses');

        if ($lacak) {
            $split = explode('-', $lacak);

            if ($split[0] === 'PROMOSI') {
                $promosi = DB::table('promosi')
                    ->where('promosi.id_proses_permohonan', '=', $lacak)
                    ->leftJoin('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')
                    ->leftJoin('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
                    ->leftJoin('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
                    ->select(
                        'promosi.id_promosi as id',
                        'promosi.google_id',
                        'promosi.id_proses_permohonan',
                        'promosi.tanggal',
                        'promosi.judul',
                        'promosi.nama_pemohon',
                        'proses_permohonan.status',
                        'proses_permohonan.tanggal_diajukan',
                        'proses_permohonan.tanggal_diterima',
                        'proses_permohonan.tanggal_diproses',
                        'proses_permohonan.tanggal_selesai',
                        'proses_permohonan.tanggal_batal',
                        'unit.nama_unit',
                        'sub_unit.nama_sub_unit',
                        'promosi.created_at'
                    )
                    ->first();

                if ($promosi) {
                    $promosi->jenis_publikasi = 'Promosi';
                    $isPemohon = Auth::user()->google_id == $promosi->google_id;

                    return view('pemohon.lacak.lacak-berhasil', ['publikasi' => $promosi, 'isPemohon' => $isPemohon]);
                } else {
                    return view('pemohon.lacak.lacak-gagal', ['id_proses_permohonan' => $lacak]);
                }
            } elseif ($split[0] === 'LIPUTAN') {
                $liputan = DB::table('liputan')
                    ->where('liputan.id_proses_permohonan', '=', $lacak)
                    ->leftJoin('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')
                    ->leftJoin('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
                    ->leftJoin('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
                    ->select(
                        'liputan.id_liputan as id',
                        'liputan.google_id',
                        'liputan.id_proses_permohonan',
                        'liputan.tanggal',
                        'liputan.judul',
                        'liputan.nama_pemohon',
                        'liputan.waktu',
                        'proses_permohonan.status',
                        'proses_permohonan.tanggal_diajukan',
                        'proses_permohonan.tanggal_diterima',
                        'proses_permohonan.tanggal_diproses',
                        'proses_permohonan.tanggal_selesai',
                        'proses_permohonan.tanggal_batal',
                        'unit.nama_unit',
                        'sub_unit.nama_sub_unit',
                        'liputan.created_at'
                    )
                    ->first();

                if ($liputan) {
                    $liputan->jenis_publikasi = 'Liputan';
                    $isPemohon = Auth::user()->google_id == $liputan->google_id;

                    return view('pemohon.lacak.lacak-berhasil', ['publikasi' => $liputan, 'isPemohon' => $isPemohon]);
                } else {
                    return view('pemohon.lacak.lacak-gagal', ['id_proses_permohonan' => $lacak]);
                }
            } else {
                return view('pemohon.lacak.lacak-gagal');
            }
        }

        return view('pemohon.lacak.lacak');
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
                $tanggalDiajukan= Promosi::where('id_verifikasi_publikasi', $token)->select('created_at')->first();

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
                            'tanggal_diajukan' => $tanggalDiajukan->created_at,
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
                $tanggalDiajukan= Liputan::where('id_verifikasi_publikasi', $token)->select('created_at')->first();

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
                            'tanggal_diajukan' => $tanggalDiajukan->created_at,
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
