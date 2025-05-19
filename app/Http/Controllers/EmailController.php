<?php

namespace App\Http\Controllers;

use App\Mail\BatalPublikasi;
use Illuminate\Support\Facades\Auth;
use App\Mail\VerifikasiPublikasiMail;
use App\Mail\KodeProsesPublikasiMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailController extends Controller
{
    public function verifikasiPublikasi($permohonan, $judulPermohonan, $id_verifikasi_publikasi)
    {
        try {
            // Kirim Email
            Mail::to(Auth::user()->email)->send(new VerifikasiPublikasiMail(Auth::user()->name, "Publikasi $permohonan", $judulPermohonan, $id_verifikasi_publikasi, Carbon::now()->translatedFormat('l, d F Y H:i:s')));
            return response()->json(['message' => 'Cek inbox atau folder spam email untuk verifikasi!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Pada Backend : ' . $e->getMessage()], 500);
        }
    }

    public function kodeProsesPublikasi($permohonan, $judulPermohonan, $id_proses_permohonan)
    {
        try {
            // Kirim Email
            Mail::to(Auth::user()->email)->send(new KodeProsesPublikasiMail(Auth::user()->name, "Publikasi $permohonan", $judulPermohonan, $id_proses_permohonan));
            return response()->json(['message' => 'Cek inbox atau folder spam email untuk kode proses!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Pada Backend : ' . $e->getMessage()], 500);
        }
    }

    public function batalPublikasi($permohonan, $judulPermohonan, $id_proses_permohonan, $pesanBatal)
    {
        try {
            // Kirim Email
            Mail::to(Auth::user()->email)->send(new BatalPublikasi(Auth::user()->name, "Publikasi $permohonan", $judulPermohonan, $id_proses_permohonan, $pesanBatal));
            return response()->json(['message' => 'Cek inbox atau folder spam email untuk pembatalan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Pada Backend : ' . $e->getMessage()], 500);
        }
    }
}
