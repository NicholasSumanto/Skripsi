<?php

namespace App\Http\Controllers;

use App\Mail\BatalPublikasi;
use Illuminate\Support\Facades\Auth;
use App\Mail\VerifikasiPublikasiMail;
use App\Mail\KodeProsesPublikasiMail;
use App\Mail\PerubahanOutput;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\StatusPublikasiMail;

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

    public function batalPublikasi($email, $nama, $permohonan, $judulPermohonan, $id_proses_permohonan, $pesanBatal, $keteranganBatal)
    {
        try {
            // Kirim Email
            Mail::to($email)->send(new BatalPublikasi($nama, "Publikasi $permohonan", $judulPermohonan, $id_proses_permohonan, $pesanBatal, $keteranganBatal));
            return response()->json(['message' => 'Cek inbox atau folder spam email untuk pembatalan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Pada Backend : ' . $e->getMessage()], 500);
        }
    }

    public function kirimEmailStatus($id_proses_permohonan)
    {
        try {
            $tipe = explode('-', $id_proses_permohonan)[0];
            $publikasi = null;

            if ($tipe === 'PROMOSI') {
                $publikasi = DB::table('promosi')->where('promosi.id_proses_permohonan', '=', $id_proses_permohonan)->leftJoin('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')->leftJoin('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->leftJoin('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->leftJoin('pengguna', 'promosi.google_id', '=', 'pengguna.google_id')->select('pengguna.email', 'promosi.id_promosi as id', 'promosi.google_id', 'promosi.nama_pemohon', 'promosi.id_proses_permohonan', 'promosi.tanggal', 'promosi.judul', 'promosi.tautan_promosi as link_output', 'proses_permohonan.status', 'proses_permohonan.tanggal_diajukan', 'proses_permohonan.tanggal_diterima', 'proses_permohonan.tanggal_diproses', 'proses_permohonan.tanggal_selesai', 'proses_permohonan.tanggal_batal', 'proses_permohonan.keterangan', 'proses_permohonan.batal_is_pemohon', 'unit.nama_unit', 'sub_unit.nama_sub_unit', 'promosi.created_at')->first();

                if ($publikasi) {
                    $publikasi->jenis_publikasi = 'Promosi';
                }
            } elseif ($tipe === 'LIPUTAN') {
                $publikasi = DB::table('liputan')->where('liputan.id_proses_permohonan', '=', $id_proses_permohonan)->leftJoin('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')->leftJoin('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->leftJoin('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->leftJoin('pengguna', 'liputan.google_id', '=', 'pengguna.google_id')->select('pengguna.email', 'liputan.id_liputan as id', 'liputan.google_id', 'liputan.nama_pemohon', 'liputan.id_proses_permohonan', 'liputan.tanggal', 'liputan.waktu', 'liputan.judul', 'liputan.tautan_liputan as link_output', 'proses_permohonan.status', 'proses_permohonan.tanggal_diajukan', 'proses_permohonan.tanggal_diterima', 'proses_permohonan.tanggal_diproses', 'proses_permohonan.tanggal_selesai', 'proses_permohonan.tanggal_batal', 'proses_permohonan.keterangan', 'proses_permohonan.batal_is_pemohon', 'unit.nama_unit', 'sub_unit.nama_sub_unit', 'liputan.created_at')->first();

                if ($publikasi) {
                    $publikasi->jenis_publikasi = 'Liputan';
                }
            }

            if ($publikasi) {
                Mail::to($publikasi->email)->send(new StatusPublikasiMail($publikasi));
                return response()->json(['message' => 'Status publikasi berhasil ' . $publikasi->status . '!']);
            } else {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan atau tidak valid.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Pada Backend : ' . $e->getMessage()], 500);
        }
    }

    public function kirimPerubahanOutput($id_proses_permohonan)
    {
        try {
            $tipe = explode('-', $id_proses_permohonan)[0];
            $publikasi = null;

            if ($tipe === 'PROMOSI') {
                $publikasi = DB::table('promosi')->where('promosi.id_proses_permohonan', '=', $id_proses_permohonan)->leftJoin('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')->leftJoin('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->leftJoin('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->leftJoin('pengguna', 'promosi.google_id', '=', 'pengguna.google_id')->select('pengguna.email', 'promosi.id_promosi as id', 'promosi.google_id', 'promosi.nama_pemohon', 'promosi.id_proses_permohonan', 'promosi.tanggal', 'promosi.judul', 'promosi.tautan_promosi as link_output', 'proses_permohonan.status', 'proses_permohonan.tanggal_diajukan', 'proses_permohonan.tanggal_diterima', 'proses_permohonan.tanggal_diproses', 'proses_permohonan.tanggal_selesai', 'proses_permohonan.tanggal_batal', 'proses_permohonan.batal_is_pemohon', 'unit.nama_unit', 'sub_unit.nama_sub_unit', 'promosi.created_at')->first();

                if ($publikasi) {
                    $publikasi->jenis_publikasi = 'Promosi';
                }
            } elseif ($tipe === 'LIPUTAN') {
                $publikasi = DB::table('liputan')->where('liputan.id_proses_permohonan', '=', $id_proses_permohonan)->leftJoin('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')->leftJoin('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->leftJoin('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->leftJoin('pengguna', 'liputan.google_id', '=', 'pengguna.google_id')->select('pengguna.email', 'liputan.id_liputan as id', 'liputan.google_id', 'liputan.nama_pemohon', 'liputan.id_proses_permohonan', 'liputan.tanggal', 'liputan.waktu', 'liputan.judul', 'liputan.tautan_liputan as link_output', 'proses_permohonan.status', 'proses_permohonan.tanggal_diajukan', 'proses_permohonan.tanggal_diterima', 'proses_permohonan.tanggal_diproses', 'proses_permohonan.tanggal_selesai', 'proses_permohonan.tanggal_batal', 'proses_permohonan.batal_is_pemohon', 'unit.nama_unit', 'sub_unit.nama_sub_unit', 'liputan.created_at')->first();

                if ($publikasi) {
                    $publikasi->jenis_publikasi = 'Liputan';
                }
            }

            if ($publikasi) {
                Mail::to($publikasi->email)->send(new PerubahanOutput($publikasi));
                return response()->json(['message' => 'Perubahan link output berhasil.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan atau tidak valid.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Pada Backend : ' . $e->getMessage()], 500);
        }
    }
}
