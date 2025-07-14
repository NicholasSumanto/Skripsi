<?php

namespace App\Http\Controllers;

use App\Models\Liputan;
use App\Models\Promosi;
use App\Models\Unit;
use App\Models\SubUnit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class StaffController extends Controller
{
    private function hitungPersentase($sekarang, $dipilih)
    {
        if ($sekarang == 0 && $dipilih == 0) {
            return ['persen' => 0, 'status' => 'sama'];
        } elseif ($sekarang == 0) {
            return ['persen' => 100, 'status' => 'bertambah'];
        }

        $selisih = $dipilih - $sekarang;
        $persen = ($selisih / $sekarang) * 100;

        if ($selisih > 0) {
            $status = 'bertambah';
        } elseif ($selisih < 0) {
            $status = 'berkurang';
        } else {
            $status = 'sama';
        }

        return ['persen' => round($persen, 1), 'status' => $status];
    }

    public function dashboard(Request $request)
    {
        $bulan = $request->input('bulan') ?? date('m');
        $tahun = $request->input('tahun') ?? date('Y');

        $bulanSekarang = date('m');
        $tahunSekarang = date('Y');

        // Hitung bulan sebelumnya
        $bulanSebelumnya = (int) $bulanSekarang - 1;
        $tahunSebelumnya = $tahunSekarang;
        if ($bulanSebelumnya < 1) {
            $bulanSebelumnya = 12;
            $tahunSebelumnya--;
        }
        $bulanSebelumnyaStr = str_pad($bulanSebelumnya, 2, '0', STR_PAD_LEFT);

        // Data pemohon
        $pemohonCount = DB::table('hitung_login')
            ->where('bulan_tahun', "$tahun-$bulan")
            ->count();

        $pemohonSekarang = DB::table('hitung_login')
            ->where('bulan_tahun', "$tahunSekarang-$bulanSekarang")
            ->count();

        $pemohonSebelumnya = DB::table('hitung_login')
            ->where('bulan_tahun', "$tahunSebelumnya-$bulanSebelumnyaStr")
            ->count();

        // Data promosi
        $promosiCount = Promosi::whereHas('ProsesPermohonan', fn($q) => $q->whereNotIn('status', ['Selesai', 'Batal']))
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $promosiSekarang = Promosi::whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->whereHas('ProsesPermohonan', fn($q) => $q->whereNotIn('status', ['Selesai', 'Batal']))
            ->count();

        $promosiSebelumnya = Promosi::whereMonth('created_at', $bulanSebelumnyaStr)
            ->whereYear('created_at', $tahunSebelumnya)
            ->whereHas('ProsesPermohonan', fn($q) => $q->whereNotIn('status', ['Selesai', 'Batal']))
            ->count();

        // Data liputan
        $liputanCount = Liputan::whereHas('ProsesPermohonan', fn($q) => $q->whereNotIn('status', ['Selesai', 'Batal']))
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $liputanSekarang = Liputan::whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->whereHas('ProsesPermohonan', fn($q) => $q->whereNotIn('status', ['Selesai', 'Batal']))
            ->count();

        $liputanSebelumnya = Liputan::whereMonth('created_at', $bulanSebelumnyaStr)
            ->whereYear('created_at', $tahunSebelumnya)
            ->whereHas('ProsesPermohonan', fn($q) => $q->whereNotIn('status', ['Selesai', 'Batal']))
            ->count();

        // Data riwayat promosi
        $riwayatPromosi = DB::table('promosi')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->whereMonth('promosi.updated_at', $bulan)
            ->whereYear('promosi.updated_at', $tahun)
            ->count();

        $riwayatPromosiNow = DB::table('promosi')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->whereMonth('promosi.updated_at', $bulanSekarang)
            ->whereYear('promosi.updated_at', $tahunSekarang)
            ->count();

        $riwayatPromosiLast = DB::table('promosi')
            ->join('proses_permohonan', 'promosi.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->whereMonth('promosi.updated_at', $bulanSebelumnyaStr)
            ->whereYear('promosi.updated_at', $tahunSebelumnya)
            ->count();

        // Data riwayat liputan
        $riwayatLiputan = DB::table('liputan')
            ->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->whereMonth('liputan.updated_at', $bulan)
            ->whereYear('liputan.updated_at', $tahun)
            ->count();

        $riwayatLiputanNow = DB::table('liputan')
            ->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->whereMonth('liputan.updated_at', $bulanSekarang)
            ->whereYear('liputan.updated_at', $tahunSekarang)
            ->count();

        $riwayatLiputanLast = DB::table('liputan')
            ->join('proses_permohonan', 'liputan.id_proses_permohonan', '=', 'proses_permohonan.id_proses_permohonan')
            ->whereIn('proses_permohonan.status', ['Selesai', 'Batal'])
            ->whereMonth('liputan.updated_at', $bulanSebelumnyaStr)
            ->whereYear('liputan.updated_at', $tahunSebelumnya)
            ->count();

        $riwayatCount = $riwayatPromosi + $riwayatLiputan;
        $riwayatNow = $riwayatPromosiNow + $riwayatLiputanNow;
        $riwayatLast = $riwayatPromosiLast + $riwayatLiputanLast;

        // Bandingkan dengan bulan sebelumnya JIKA bulan sekarang yang dipilih
        if ($bulan == $bulanSekarang && $tahun == $tahunSekarang) {
            $pemohonStat = $this->hitungPersentase($pemohonSebelumnya, $pemohonSekarang);
            $promosiStat = $this->hitungPersentase($promosiSebelumnya, $promosiSekarang);
            $liputanStat = $this->hitungPersentase($liputanSebelumnya, $liputanSekarang);
            $riwayatStat = $this->hitungPersentase($riwayatLast, $riwayatNow);
        } else {
            // Jika bulan lain yang dipilih, tetap bandingkan terhadap bulan sekarang
            $pemohonStat = $this->hitungPersentase($pemohonSekarang, $pemohonCount);
            $promosiStat = $this->hitungPersentase($promosiSekarang, $promosiCount);
            $liputanStat = $this->hitungPersentase($liputanSekarang, $liputanCount);
            $riwayatStat = $this->hitungPersentase($riwayatNow, $riwayatCount);
        }

        $cards = [
            [
                'title' => 'Pemohon Aktif',
                'iconColor' => 'purple',
                'count' => $pemohonCount,
                'stat' => $pemohonStat,
                'icon' => 'user',
            ],
            [
                'title' => 'Permohonan Promosi (Dalam Proses)',
                'iconColor' => 'blue',
                'count' => $promosiCount,
                'stat' => $promosiStat,
                'icon' => 'megaphone',
            ],
            [
                'title' => 'Permohonan Liputan (Dalam Proses)',
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

        return view('staff.dashboard', compact('cards', 'bulan', 'tahun'));
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

        switch ($sort) {
            case 'asc':
                $merged = $merged->sortBy('tanggal'); // tanggal pelaksanaan
                break;
            case 'desc':
                $merged = $merged->sortByDesc('tanggal'); // tanggal pelaksanaan
                break;
            case 'baru_diajukan':
                $merged = $merged->sortByDesc('created_at'); // waktu permohonan masuk
                break;
            case 'lama_diajukan':
                $merged = $merged->sortBy('created_at'); // waktu permohonan masuk
                break;
            default:
                $merged = $merged->sortByDesc('tanggal'); // default fallback
                break;
        }


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
