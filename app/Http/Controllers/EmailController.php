<?php

namespace App\Http\Controllers;

use App\Models\Liputan;
use App\Models\VerifikasiPublikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\VerifikasiPublikasiMail;
use App\Models\Promosi;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailController extends Controller
{
    private function buatKodeVerifikasi(string $tipe_publikasi): string
    {
        $prefix = strtoupper(substr($tipe_publikasi, 0, 5));

        $timestamp = now()->format('YmdHisv');
        $uuid = (string) Str::uuid();

        return $prefix . '-' . $timestamp . '-' . $uuid;
    }

    public function verifikasiPublikasi(Request $request)
    {
        // Validasi Input
        try {
            if (isset($request->permohonan) && ($request->permohonan == 'Liputan' || $request->permohonan == 'Promosi')) {
                // Buat Data Verifikasi Dummy
                $id_verifikasi_publikasi = $this->buatKodeVerifikasi($request->permohonan);

                if ($request->permohonan == 'Liputan') {
                    // Buat Data Liputan Dummy
                    Liputan::create([
                        'google_id' => Auth::user()->google_id,
                        'id_verifikasi_publikasi' => $id_verifikasi_publikasi,
                        'nama_pemohon' => Auth::user()->name,
                        'nomor_handphone' => '6969696969',
                        'wartawan' => 'Ya',
                        'tanggal' => now(),
                        'status_verifikasi' => 'Tidak Terverifikasi',
                        'output' => 'Dummy',
                    ]);
                } elseif ($request->permohonan == 'Promosi') {
                    // Buat Data Promosi Dummy
                    Promosi::create([
                        'google_id' => Auth::user()->google_id,
                        'id_verifikasi_publikasi' => $id_verifikasi_publikasi,
                        'nama_pemohon' => Auth::user()->name,
                        'nomor_handphone' => '6969696969',
                        'tanggal' => now(),
                        'status_verifikasi' => 'Tidak Terverifikasi',
                    ]);
                }

                // Kirim Email
                Mail::to(Auth::user()->email)->send(
                    new VerifikasiPublikasiMail(
                        Auth::user()->name,
                        "Publikasi $request->permohonan",
                        $id_verifikasi_publikasi,
                        Carbon::now()->translatedFormat('l, d F Y H:i:s'),
                    )
                );
                return response()->json(['message' => 'Cek inbox atau folder spam email untuk verifikasi!']);
            } else {
                return response()->json(['message' => 'permohonan di luar kendali!'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error Pada Backend : ' . $e->getMessage()], 500);
        }
    }
}
