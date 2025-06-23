<?php

namespace App\Http\Controllers;

use App\Models\Liputan;
use App\Models\Promosi;
use App\Models\Unit;
use App\Models\SubUnit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Session;

class StaffController extends Controller
{
    // Fungsi bantu menghitung persentase dan status
    private function hitungPersentase($kemarin, $hariIni)
    {
        if ($kemarin == 0 && $hariIni == 0) {
            return ['persen' => 0, 'status' => 'sama'];
        } elseif ($kemarin == 0) {
            return ['persen' => 100, 'status' => 'bertambah'];
        }

        $selisih = $hariIni - $kemarin;
        $persen = ($selisih / $kemarin) * 100;

        if ($selisih > 0) {
            $status = 'bertambah';
        } elseif ($selisih < 0) {
            $status = 'berkurang';
        } else {
            $status = 'sama';
        }

        return ['persen' => round($persen, 1), 'status' => $status];
    }

    public function dashboard()
    {
        // Data card
        $pemohonCount = DB::table('pengguna')->count();
        $pemohonTodayCount = DB::table('pengguna')
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->count();
        $pemohonYesterday = DB::table('pengguna')
            ->whereDate('created_at', now()->subDay()->format('Y-m-d'))
            ->count();

        $promosiCount = Promosi::whereHas('ProsesPermohonan', function ($query) {
            $query->whereNotIn('status', ['Selesai', 'Batal']);
        })->count();
        $promosiTodayCount = Promosi::whereDate('created_at', now()->format('Y-m-d'))
            ->whereHas('ProsesPermohonan', function ($query) {
                $query->whereNotIn('status', ['Selesai', 'Batal']);
            })
            ->count();
        $promosiYesterday = Promosi::whereDate('created_at', now()->subDay()->format('Y-m-d'))
            ->whereHas('ProsesPermohonan', fn($q) => $q->whereNotIn('status', ['Selesai', 'Batal']))
            ->count();

        $liputanCount = Liputan::whereHas('ProsesPermohonan', function ($query) {
            $query->whereNotIn('status', ['Selesai', 'Batal']);
        })->count();
        $liputanTodayCount = Liputan::whereDate('created_at', now()->format('Y-m-d'))
            ->whereHas('ProsesPermohonan', function ($query) {
                $query->whereNotIn('status', ['Selesai', 'Batal']);
            })
            ->count();
        $liputanYesterday = Liputan::whereDate('created_at', now()->subDay()->format('Y-m-d'))
            ->whereHas('ProsesPermohonan', fn($q) => $q->whereNotIn('status', ['Selesai', 'Batal']))
            ->count();

        $riwayatPromosi = DB::table('promosi')
            ->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->count();
        $riwayatPromosiYesterday = DB::table('promosi')
            ->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereDate('promosi.updated_at', now()->subDay()->format('Y-m-d'))
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->count();
        $riwayatPromosiToday = DB::table('promosi')
            ->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereDate('promosi.updated_at', now()->format('Y-m-d'))
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->count();

        $riwayatLiputan = DB::table('liputan')
            ->join('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->count();
        $riwayatLiputanYesterday = DB::table('liputan')
            ->join('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereDate('liputan.updated_at', now()->subDay()->format('Y-m-d'))
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->count();
        $riwayatLiputanToday = DB::table('liputan')
            ->join('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereDate('liputan.updated_at', now()->format('Y-m-d'))
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->count();

        $riwayatCount = $riwayatPromosi + $riwayatLiputan;
        $riwayatYesterday = $riwayatPromosiYesterday + $riwayatLiputanYesterday;
        $riwayatToday = $riwayatPromosiToday + $riwayatLiputanToday;

        // Hitung persentase dan status
        $pemohonStat = $this->hitungPersentase($pemohonYesterday, $pemohonTodayCount);
        $promosiStat = $this->hitungPersentase($promosiYesterday, $promosiTodayCount);
        $liputanStat = $this->hitungPersentase($liputanYesterday, $liputanTodayCount);
        $riwayatStat = $this->hitungPersentase($riwayatYesterday, $riwayatToday);

        $cards = [
            [
                'title' => 'Total User',
                'iconColor' => 'purple',
                'count' => $pemohonCount,
                'stat' => $pemohonStat,
                'icon' => 'user',
            ],
            [
                'title' => 'Total Promosi',
                'iconColor' => 'blue',
                'count' => $promosiCount,
                'stat' => $promosiStat,
                'icon' => 'megaphone',
            ],
            [
                'title' => 'Total Liputan',
                'iconColor' => 'green',
                'count' => $liputanCount,
                'stat' => $liputanStat,
                'icon' => 'camera',
            ],
            [
                'title' => 'Permohonan Selesai',
                'iconColor' => 'teal',
                'count' => $riwayatCount,
                'stat' => $riwayatStat,
                'icon' => 'check-circle',
            ],
        ];


        return view('staff.dashboard', compact('cards'));
    }

    public function home(Request $request)
    {
        $sort = $request->input('sort', 'asc');
        $pub = $request->input('pub');
        $proses = $request->input('proses');
        $search = $request->input('search');

        $promosi = DB::table('promosi')
            ->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')
            ->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->where('proses_permohonan.status', '!=', 'Selesai')
            ->where('proses_permohonan.status', '!=', 'Batal')
            ->when($proses, function ($query, $proses) {
                return $query->where('proses_permohonan.status', $proses);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('promosi.judul', 'like', "%$search%")->orWhere('promosi.nama_pemohon', 'like', "%$search%");
                });
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
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('liputan.judul', 'like', "%$search%")->orWhere('liputan.nama_pemohon', 'like', "%$search%");
                });
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
        $perPage = 4;
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
            $publikasi = DB::table('promosi')->join('sub_unit', 'promosi.id_sub_unit', '=', 'sub_unit.id_sub_unit')->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->join('pengguna', 'promosi.google_id', '=', 'pengguna.google_id')->where('promosi.id_proses_permohonan', $id)->select('promosi.*', 'pengguna.email', 'sub_unit.nama_sub_unit', 'unit.nama_unit', 'proses_permohonan.status', 'proses_permohonan.tanggal_batal', 'proses_permohonan.keterangan', 'proses_permohonan.batal_is_pemohon', 'promosi.tautan_promosi as link_output')->first();

            return view('staff.detail-riwayat.detail-promosi', compact('publikasi'));
        } elseif ($split === 'LIPUTAN') {
            $publikasi = DB::table('liputan')->join('sub_unit', 'liputan.id_sub_unit', '=', 'sub_unit.id_sub_unit')->join('unit', 'sub_unit.id_unit', '=', 'unit.id_unit')->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')->join('pengguna', 'liputan.google_id', '=', 'pengguna.google_id')->where('liputan.id_proses_permohonan', $id)->select('liputan.*', 'pengguna.email', 'sub_unit.nama_sub_unit', 'unit.nama_unit', 'proses_permohonan.status', 'proses_permohonan.tanggal_batal', 'proses_permohonan.keterangan', 'proses_permohonan.batal_is_pemohon', 'liputan.tautan_liputan as link_output')->first();

            return view('staff.detail-riwayat.detail-liputan', compact('publikasi'));
        }
    }

    public function unit()
    {
        return view('staff.unit');
    }

    public function subunit($id_unit)
    {
        $unit = Unit::where('id_unit', $id_unit)->select('id_unit', 'nama_unit')->first();

        if (!$unit) {
            return redirect()->route('staff.unit');
        }

        $subUnits = SubUnit::where('id_unit', $id_unit)->get();

        return view('staff.subunit', compact('subUnits', 'unit'));
    }
}
