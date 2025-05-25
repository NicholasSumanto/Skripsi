<?php

namespace App\Http\Controllers;

use App\Models\Liputan;
use App\Models\Promosi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function home(Request $request)
    {
        // Ambil parameter filter
        $sort = $request->input('sort', 'asc'); // default ke 'desc'
        $pub = $request->input('pub'); // 'liputan' atau 'promosi'
        $proses = $request->input('proses'); // 'diajukan', 'diterima', 'diproses'

        $promosi = DB::table('promosi')
            ->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->where('proses_permohonan.status', '!=', 'Selesai')
            ->where('proses_permohonan.status', '!=', 'Batal')
            ->when($proses, function ($query, $proses) {
                return $query->where('proses_permohonan.status', $proses); // pastikan kolom 'status' ada
            })
            ->select('promosi.id_promosi as id', 'promosi.id_proses_permohonan', 'promosi.tanggal', 'promosi.judul', 'promosi.nama_pemohon', 'proses_permohonan.status', 'proses_permohonan.tanggal_diajukan', 'proses_permohonan.tanggal_diterima', 'proses_permohonan.tanggal_diproses', 'proses_permohonan.tanggal_selesai', 'proses_permohonan.tanggal_batal', 'unit.nama_unit', 'sub_unit.nama_sub_unit', 'promosi.created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_proses_permohonan' => $item->id_proses_permohonan,
                    'tanggal' => $item->tanggal,
                    'judul' => $item->judul,
                    'nama_pemohon' => $item->nama_pemohon,
                    'jenis' => 'Publikasi Promosi',
                    'status' => $item->status,
                    'tanggal_diajukan' => $item->tanggal_diajukan,
                    'tanggal_diterima' => $item->tanggal_diterima ?? null,
                    'tanggal_diproses' => $item->tanggal_diproses ?? null,
                    'tanggal_selesai' => $item->tanggal_selesai ?? null,
                    'tanggal_batal' => $item->tanggal_batal ?? null,
                    'nama_unit' => $item->nama_unit,
                    'nama_sub_unit' => $item->nama_sub_unit,
                    'created_at' => $item->created_at,
                ];
            });

        $liputan = DB::table('liputan')
            ->join('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->where('proses_permohonan.status', '!=', 'Selesai')
            ->where('proses_permohonan.status', '!=', 'Batal')
            ->when($proses, function ($query, $proses) {
                return $query->where('proses_permohonan.status', $proses);
            })
            ->select('liputan.id_liputan as id', 'liputan.id_proses_permohonan', 'liputan.tanggal', 'liputan.judul', 'liputan.nama_pemohon', 'proses_permohonan.status', 'proses_permohonan.tanggal_diajukan', 'proses_permohonan.tanggal_diterima', 'proses_permohonan.tanggal_diproses', 'proses_permohonan.tanggal_selesai', 'proses_permohonan.tanggal_batal', 'unit.nama_unit', 'sub_unit.nama_sub_unit', 'liputan.created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_proses_permohonan' => $item->id_proses_permohonan,
                    'tanggal' => $item->tanggal,
                    'judul' => $item->judul,
                    'nama_pemohon' => $item->nama_pemohon,
                    'jenis' => 'Publikasi Liputan',
                    'status' => $item->status,
                    'tanggal_diajukan' => $item->tanggal_diajukan,
                    'tanggal_diterima' => $item->tanggal_diterima ?? null,
                    'tanggal_diproses' => $item->tanggal_diproses ?? null,
                    'tanggal_selesai' => $item->tanggal_selesai ?? null,
                    'tanggal_batal' => $item->tanggal_batal ?? null,
                    'nama_unit' => $item->nama_unit,
                    'nama_sub_unit' => $item->nama_sub_unit,
                    'created_at' => $item->created_at,
                ];
            });

        if ($pub === 'liputan') {
            $merged = $liputan;
        } elseif ($pub === 'promosi') {
            $merged = $promosi;
        } else {
            $merged = $promosi->merge($liputan);
        }

        $merged = $sort === 'asc' ? $merged->sortBy('tanggal') : $merged->sortByDesc('tanggal');

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 3;
        $currentItems = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $publikasi = new LengthAwarePaginator($currentItems, $merged->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('staff.home', compact('publikasi'));
    }

    public function riwayat()
    {
        return view('staff.riwayat');
    }

    public function detailPublikasi($id)
    {
        $split = explode('-', $id)[0];
        $publikasi = null;

        if ($split === 'PROMOSI') {
            $publikasi = DB::table('promosi')->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->join('pengguna', 'promosi.google_id', '=', 'pengguna.google_id')->where('promosi.id_proses_permohonan', $id)->select('promosi.*', 'pengguna.email', 'sub_unit.nama_sub_unit', 'unit.nama_unit', 'proses_permohonan.status')->first();

            return view('staff.detail.detail-promosi', compact('publikasi'));
        } elseif ($split === 'LIPUTAN') {
            $publikasi = DB::table('liputan')->join('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->join('pengguna', 'liputan.google_id', '=', 'pengguna.google_id')->where('liputan.id_proses_permohonan', $id)->select('liputan.*', 'pengguna.email', 'sub_unit.nama_sub_unit', 'unit.nama_unit', 'proses_permohonan.status')->first();

            return view('staff.detail.detail-liputan', compact('publikasi'));
        }
    }

    public function detailRiwayat($id)
    {
        $split = explode('-', $id)[0];
        $publikasi = null;

        if ($split === 'PROMOSI') {
            $publikasi = DB::table('promosi')
                ->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')
                ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
                ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
                ->join('pengguna', 'promosi.google_id', '=', 'pengguna.google_id')
                ->where('promosi.id_proses_permohonan', $id)
                ->select(
                    'promosi.*',
                    'pengguna.email',
                    'sub_unit.nama_sub_unit',
                    'unit.nama_unit',
                    'proses_permohonan.status',
                    'proses_permohonan.tanggal_batal',
                    'proses_permohonan.keterangan',
                    'proses_permohonan.batal_is_pemohon',
                    'promosi.tautan_promosi as link_output'
                )
                ->first();

            return view('staff.detail-riwayat.detail-promosi', compact('publikasi'));
        } elseif ($split === 'LIPUTAN') {
            $publikasi = DB::table('liputan')->join('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->join('pengguna', 'liputan.google_id', '=', 'pengguna.google_id')->where('liputan.id_proses_permohonan', $id)->select(
                'liputan.*',
                'pengguna.email',
                'sub_unit.nama_sub_unit',
                'unit.nama_unit',
                'proses_permohonan.status',
                'proses_permohonan.tanggal_batal',
                'proses_permohonan.keterangan',
                'proses_permohonan.batal_is_pemohon',
                'liputan.tautan_liputan as link_output'
            )->first();

            return view('staff.detail-riwayat.detail-liputan', compact('publikasi'));
        }
    }
}
