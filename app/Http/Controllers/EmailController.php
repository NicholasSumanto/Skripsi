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

    public function verifikasiPublikasi($permohonan, $id_verifikasi_publikasi)
    {
        try {
            // Kirim Email
            Mail::to(Auth::user()->email)->send(new VerifikasiPublikasiMail(Auth::user()->name, "Publikasi $permohonan", $id_verifikasi_publikasi, Carbon::now()->translatedFormat('l, d F Y H:i:s')));
            return response()->json(['message' => 'Cek inbox atau folder spam email untuk verifikasi!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Pada Backend : ' . $e->getMessage()], 500);
        }
    }
}
