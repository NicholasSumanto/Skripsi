<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Promosi;
use App\Models\ProsesPermohonan;
use App\Models\Unit;
use Google\Service\BigtableAdmin\Split;
use Illuminate\Http\Request;
use App\Models\Liputan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class ApiController extends Controller
{
    private function buatKodeVerifikasi(string $tipe_publikasi): string
    {
        $prefix = strtoupper(substr($tipe_publikasi, 0, 5));

        $timestamp = now()->format('YmdHisv');
        $uuid = (string) Str::uuid();

        return $prefix . '-' . $timestamp . '-' . $uuid;
    }

    // Simpon Data Form
    public function postLiputan(Request $request)
    {
        // Pastikan pengguna sudah terautentikasi
        if (!Auth::check()) {
            return response()->json(['error' => 'Pengguna tidak terautentikasi.'], 401);
        }

        // Cek apakah pengguna masih memiliki kuota permohonan publikasi liputan tidak terverifikasi (10)
        $kuota = Liputan::where('google_id', Auth::user()->google_id)
            ->where('status_verifikasi', 'Tidak Terverifikasi')
            ->count();
        if ($kuota >= 10) {
            return response()->json(
                [
                    'error' => 'Kuota permohonan publikasi liputan tidak terverifikasi sudah mencapai batas maksimum (10).',
                ],
                400,
            );
        }

        // Cek apakah pengguna masih memiliki kuota permohonan publikasi liputan terverifikasi (4)
        $kuotaTerverifikasi = Liputan::where('google_id', Auth::user()->google_id)
            ->where('status_verifikasi', 'Terverifikasi')
            ->count();
        if ($kuotaTerverifikasi >= 4) {
            return response()->json(
                [
                    'error' => 'Kuota permohonan publikasi liputan terverifikasi sudah mencapai batas maksimum (4). Tunggu hingga staff menyelesaikan verifikasi.',
                ],
                400,
            );
        }

        // Validasi data yang diterima dari form
        $validatedData = $request->validate(
            [
                'judul' => 'required|string|max:255',
                'id_sub_unit' => 'required|integer|exists:sub_unit,id_sub_unit',
                'nama_pemohon' => 'required|string|max:255',
                'nomor_handphone' => 'required|string|max:255',
                'tempat' => 'required|string',
                'tanggal' => 'required|date',
                'waktu' => 'required|date_format:H:i',
                'wartawan' => 'required|in:Ya,Tidak',
                'file_liputan' => 'required|array',
                'file_liputan.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z|max:15360',
                'output' => 'required|array',
                'output.*' => 'required|string|in:artikel,foto,video',
                'catatan' => 'nullable|string',
            ],
            [
                'judul.string' => 'Judul harus berupa teks.',
                'id_sub_unit.integer' => 'ID Sub Unit harus berupa angka.',
                'id_sub_unit.exists' => 'ID Sub Unit tidak ditemukan.',
                'nama_pemohon.required' => 'Nama pemohon wajib diisi.',
                'nama_pemohon.string' => 'Nama pemohon harus berupa teks.',
                'nomor_handphone.required' => 'Nomor handphone wajib diisi.',
                'nomor_handphone.string' => 'Nomor handphone harus berupa teks.',
                'tempat.string' => 'Tempat harus berupa teks.',
                'tanggal.date' => 'Tanggal tidak valid.',
                'waktu.date_format' => 'Waktu harus dalam format Y-m-d H:i:s.',
                'wartawan.required' => 'Wartawan wajib dipilih.',
                'wartawan.in' => 'Pilihan wartawan tidak valid.',
                'file_liputan.file' => 'File liputan harus berupa file.',
                'file_liputan.mimes' => 'File liputan harus berupa file dengan format jpg, jpeg, png, atau pdf.',
                'file_liputan.*.mimes' => 'File liputan harus berupa file dengan format jpg, jpeg, png, atau pdf.',
                'file_liputan.*.max' => 'Setiap file tidak boleh lebih dari 15 MB.',
                'output.required' => 'Output wajib diisi.',
                'output.array' => 'Output harus berupa array.',
                'output.*.required' => 'Setiap output wajib diisi.',
                'output.*.string' => 'Setiap output harus berupa teks.',
                'output.*.in' => 'Setiap output harus berupa artikel, foto, atau video.',
                'catatan.string' => 'Catatan harus berupa teks.',
            ],
        );

        $uploadedFiles = [];
        $kode = $this->buatKodeVerifikasi('Liputan');

        try {
            $liputan = Liputan::create([
                'google_id' => Auth::user()->google_id,
                'id_verifikasi_publikasi' => $kode,
                'status_verifikasi' => 'Tidak Terverifikasi',
                'id_sub_unit' => $validatedData['id_sub_unit'],
                'judul' => $validatedData['judul'],
                'nama_pemohon' => $validatedData['nama_pemohon'],
                'nomor_handphone' => $validatedData['nomor_handphone'],
                'tempat' => $validatedData['tempat'],
                'tanggal' => $validatedData['tanggal'],
                'waktu' => $validatedData['tanggal'] . ' ' . $validatedData['waktu'] . ':00',
                'wartawan' => $validatedData['wartawan'],
                'file_liputan' => json_encode([]), // Placeholder for files
                'output' => json_encode($validatedData['output']),
                'catatan' => $validatedData['catatan'],
            ]);

            if ($request->hasFile('file_liputan')) {
                foreach ($request->file('file_liputan') as $file) {
                    $uniqueFileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs('liputan/' . $kode, $file, $uniqueFileName);
                    $uploadedFiles[] = $uniqueFileName;
                }

                $liputan->update([
                    'file_liputan' => json_encode($uploadedFiles),
                ]);
            }

            $emailController = new EmailController();
            $response = $emailController->verifikasiPublikasi('Liputan', $validatedData['judul'], $kode);

            if ($response->getStatusCode() !== 200) {
                return $response;
            }

            $emailMessage = $response->getData()->message;

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'email_message' => $emailMessage,
                'redirect_url' => route('pemohon.home'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function postPromosi(Request $request)
    {
        // Pastikan pengguna sudah terautentikasi
        if (!Auth::check()) {
            return response()->json(['error' => 'Pengguna tidak terautentikasi.'], 401);
        }

        // Cek apakah pengguna masih memiliki kuota permohonan publikasi liputan tidak terverifikasi (10)
        $kuota = Promosi::where('google_id', Auth::user()->google_id)
            ->where('status_verifikasi', 'Tidak Terverifikasi')
            ->count();
        if ($kuota >= 10) {
            return response()->json(
                [
                    'error' => 'Kuota permohonan publikasi promosi tidak terverifikasi sudah mencapai batas maksimum (10).',
                ],
                400,
            );
        }

        // Cek apakah pengguna masih memiliki kuota permohonan publikasi liputan terverifikasi (4)
        $kuotaTerverifikasi = Promosi::where('google_id', Auth::user()->google_id)
            ->where('status_verifikasi', 'Terverifikasi')
            ->count();
        if ($kuotaTerverifikasi >= 4) {
            return response()->json(
                [
                    'error' => 'Kuota permohonan publikasi promosi terverifikasi sudah mencapai batas maksimum (4). Tunggu hingga staff menyelesaikan verifikasi.',
                ],
                400,
            );
        }

        // Validasi input
        $validatedData = $request->validate(
            [
                'judul' => 'required|string|max:255',
                'id_sub_unit' => 'required|integer|exists:sub_unit,id_sub_unit',
                'nama_pemohon' => 'required|string|max:255',
                'nomor_handphone' => 'required|string|max:255',
                'tempat' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'file_liputan' => 'nullable|array',
                'file_stories.*' => 'file|mimes:jpg,jpeg,png,mp4|max:15360',
                'file_poster' => 'nullable|array',
                'file_poster.*' => 'file|mimes:jpg,jpeg,png,mp4|max:15360',
                'file_video' => 'nullable|array',
                'file_video.*' => 'file|mimes:mp4|max:15360',
                'catatan' => 'nullable|string',
            ],
            [
                'judul.required' => 'Judul wajib diisi.',
                'judul.string' => 'Judul harus berupa teks.',
                'id_sub_unit.integer' => 'ID Sub Unit harus berupa angka.',
                'id_sub_unit.exists' => 'ID Sub Unit tidak ditemukan.',
                'nama_pemohon.required' => 'Nama pemohon wajib diisi.',
                'nama_pemohon.string' => 'Nama pemohon harus berupa teks.',
                'nomor_handphone.required' => 'Nomor handphone wajib diisi.',
                'nomor_handphone.string' => 'Nomor handphone harus berupa teks.',
                'tempat.string' => 'Tempat harus berupa teks.',
                'tanggal.date' => 'Tanggal tidak valid.',
                'file_stories.mimes' => 'File liputan harus berupa file dengan format jpg, jpeg, png, atau mp4.',
                'file_stories.*.mimes' => 'File liputan harus berupa file dengan format jpg, jpeg, png, atau mp4.',
                'file_stories.max' => 'File Instagram Stories tidak boleh lebih dari 15MB.',
                'file_poster.mimes' => 'File liputan harus berupa file dengan format jpg, jpeg, png, atau mp4.',
                'file_poster.*.mimes' => 'File liputan harus berupa file dengan format jpg, jpeg, png, atau mp4.',
                'file_poster.max' => 'File Instagram Post tidak boleh lebih dari 15MB.',
                'file_video.mimes' => 'File liputan harus berupa file dengan format mp4.',
                'file_video.*.mimes' => 'File liputan harus berupa file dengan format mp4.',
                'file_video.max' => 'File Videotron tidak boleh lebih dari 15MB.',
            ],
        );

        // Validasi minimal 1 file harus ada
        if (!$request->hasFile('file_stories') && !$request->hasFile('file_poster') && !$request->hasFile('file_video')) {
            return response()->json(
                [
                    'error' => 'Minimal satu materi promosi (stories, post, atau video) harus diunggah.',
                ],
                400,
            );
        }

        $kode = $this->buatKodeVerifikasi('Promosi');

        $storiesFiles = [];
        $posterFiles = [];
        $videoFiles = [];

        try {
            // Simpan entri promosi
            $promosi = Promosi::create([
                'google_id' => Auth::user()->google_id,
                'id_verifikasi_publikasi' => $kode,
                'status_verifikasi' => 'Tidak Terverifikasi',
                'id_sub_unit' => $validatedData['id_sub_unit'],
                'judul' => $validatedData['judul'],
                'nama_pemohon' => $validatedData['nama_pemohon'],
                'nomor_handphone' => $validatedData['nomor_handphone'],
                'tempat' => $validatedData['tempat'],
                'tanggal' => $validatedData['tanggal'],
                'catatan' => $validatedData['catatan'],
                'file_stories' => json_encode([]),
                'file_poster' => json_encode([]),
                'file_video' => json_encode([]),
            ]);

            if ($request->hasFile('file_stories')) {
                foreach ($request->file('file_stories') as $file) {
                    $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs("promosi/{$kode}/file_stories", $file, $fileName);
                    $storiesFiles[] = $fileName;
                }
            }

            if ($request->hasFile('file_poster')) {
                foreach ($request->file('file_poster') as $file) {
                    $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs("promosi/{$kode}/file_poster", $file, $fileName);
                    $posterFiles[] = $fileName;
                }
            }

            if ($request->hasFile('file_video')) {
                foreach ($request->file('file_video') as $file) {
                    $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    Storage::putFileAs("promosi/{$kode}/file_video", $file, $fileName);
                    $videoFiles[] = $fileName;
                }
            }

            $promosi->update([
                'file_stories' => json_encode($storiesFiles),
                'file_poster' => json_encode($posterFiles),
                'file_video' => json_encode($videoFiles),
            ]);

            $emailController = new EmailController();
            $response = $emailController->verifikasiPublikasi('Promosi', $validatedData['judul'], $kode);

            if ($response->getStatusCode() !== 200) {
                return $response;
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'email_message' => $response->getData()->message,
                'redirect_url' => route('pemohon.home'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // Ambil data unit dan sub-unit untuk dropdown
    public function getSubUnits(Request $request)
    {
        $id_unit = $request->input('id_unit');

        // Validasi ID unit
        if (!$id_unit) {
            return response()->json(['error' => 'ID unit tidak valid.'], 400);
        }
        // Ambil sub-unit berdasarkan ID unit
        $unit = Unit::with('subUnits')->find($id_unit);
        $subUnits = [];

        if ($unit) {
            $subUnits = $unit->subUnits->map(function ($sub) {
                return [
                    'id_sub_unit' => $sub->id_sub_unit,
                    'nama_sub_unit' => $sub->nama_sub_unit,
                ];
            });
        } else {
            return response()->json(['error' => 'Unit tidak ditemukan.'], 404);
        }

        return response()->json($subUnits);
    }

    public function deletePublikasi(Request $request)
    {
        // Pastikan pengguna sudah terautentikasi
        if (!Auth::check()) {
            return response()->json(['error' => 'Pengguna tidak terautentikasi.'], 401);
        }

        // Validasi apakah pengguna yang membuat publikasi
        $id_proses_permohonan = $request->validate(
            [
                'id_proses_permohonan' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $existsInPromosi = DB::table('promosi')->where('id_proses_permohonan', $value)->exists();
                        $existsInLiputan = DB::table('liputan')->where('id_proses_permohonan', $value)->exists();

                        if (!($existsInPromosi || $existsInLiputan)) {
                            $fail('Kode proses publikasi tidak ditemukan.');
                        }
                    },
                ],
            ],
            [
                'id_proses_permohonan.required' => 'Kode proses publikasi wajib diisi.',
                'id_proses_permohonan.string' => 'Kode proses publikasi harus berupa teks.',
            ],
        );

        try {
            $split = explode('-', $id_proses_permohonan['id_proses_permohonan']);
            $tipe = $split[0];
            $pesanBatal = null;

            if ($tipe == 'LIPUTAN') {
                $batalkan_liputan = Liputan::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();
                if ($batalkan_liputan) {
                    if (Auth::user()->google_id != $batalkan_liputan->google_id && Auth::user()->role != 'staff') {
                        return response()->json(['error' => 'Anda tidak memiliki izin untuk membatalkan publikasi ini.'], 403);
                    }

                    $batalkan_proses_permohonan = ProsesPermohonan::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();
                    $liputean = Liputan::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();
                    $pemohon = Pengguna::where('google_id', $liputean->google_id)->first();

                    if ($batalkan_liputan->file_liputan) {
                        Storage::disk('local')->deleteDirectory('liputan/' . $batalkan_liputan->id_verifikasi_publikasi);
                    }

                    $batalkan_proses_permohonan->update([
                        'status' => 'Batal',
                        'tanggal_batal' => Carbon::now(),
                    ]);

                    if (Auth::user()->role == 'staff') {
                        $batalkan_proses_permohonan->update([
                            'batal_is_pemohon' => false,
                        ]);
                        $pesanBatal = 'dibatalkan oleh staff';
                    } else {
                        $batalkan_proses_permohonan->update([
                            'batal_is_pemohon' => true,
                        ]);
                        $pesanBatal = 'telah dibatalkan';
                    }

                    $emailController = new EmailController();
                    $response = $emailController->batalPublikasi($pemohon->email, $pemohon->name, 'Liputan', $batalkan_liputan->judul, $id_proses_permohonan['id_proses_permohonan'], $pesanBatal);

                    if ($response->getStatusCode() !== 200) {
                        return $response;
                    }

                    $response = $emailController->kirimEmailStatus($id_proses_permohonan['id_proses_permohonan']);
                    if ($response->getStatusCode() !== 200) {
                        return $response;
                    }

                    return response()->json(['message' => 'Permohonan publikasi berhasil dibatalkan.']);
                } else {
                    return response()->json(['error' => 'Kode Lacak Permintaan Publikasi Tidak Dapat Ditemukan.'], 404);
                }
            } elseif ($tipe == 'PROMOSI') {
                $batalkan_promosi = Promosi::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();
                if ($batalkan_promosi) {
                    if (Auth::user()->google_id != $batalkan_promosi->google_id && Auth::user()->role != 'staff') {
                        return response()->json(['error' => 'Anda tidak memiliki izin untuk membatalkan publikasi ini.'], 403);
                    }

                    $batalkan_proses_permohonan = ProsesPermohonan::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();
                    $promosi = Promosi::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();
                    $pemohon = Pengguna::where('google_id', $promosi->google_id)->first();

                    if ($batalkan_promosi->file_stories || $batalkan_promosi->file_poster || $batalkan_promosi->file_video) {
                        Storage::disk('local')->deleteDirectory('promosi/' . $batalkan_promosi->id_verifikasi_publikasi);
                    }

                    $batalkan_proses_permohonan->update([
                        'status' => 'Batal',
                        'tanggal_batal' => Carbon::now(),
                    ]);

                    if (Auth::user()->role == 'staff') {
                        $batalkan_proses_permohonan->update([
                            'batal_is_pemohon' => false,
                        ]);
                        $pesanBatal = 'dibatalkan oleh staff';
                    } else {
                        $batalkan_proses_permohonan->update([
                            'batal_is_pemohon' => true,
                        ]);
                        $pesanBatal = 'telah dibatalkan';
                    }

                    $emailController = new EmailController();
                    $response = $emailController->batalPublikasi($pemohon->email, $pemohon->name, 'Promosi', $batalkan_promosi->judul, $id_proses_permohonan['id_proses_permohonan'], $pesanBatal);

                    if ($response->getStatusCode() !== 200) {
                        return $response;
                    }

                    $response = $emailController->kirimEmailStatus($id_proses_permohonan['id_proses_permohonan']);
                    if ($response->getStatusCode() !== 200) {
                        return $response;
                    }

                    return response()->json(['message' => 'Permohonan publikasi berhasil dibatalkan.']);
                } else {
                    return response()->json(['error' => 'Kode Lacak Permintaan Publikasi Tidak Dapat Ditemukan.'], 404);
                }
            } else {
                return response()->json(['error' => 'Kode Lacak Permintaan Publikasi Tidak Dapat Ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatusPublikasi(Request $request)
    {
        // Pastikan pengguna sudah terautentikasi
        if (!Auth::check() && Auth::user()->role != 'staff') {
            return response()->json(['error' => 'Pengguna tidak memiliki hak.'], 401);
        }

        // Validasi apakah pengguna yang membuat publikasi
        $id_proses_permohonan = $request->validate(
            [
                'id_proses_permohonan' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $existsInPromosi = DB::table('promosi')->where('id_proses_permohonan', $value)->exists();
                        $existsInLiputan = DB::table('liputan')->where('id_proses_permohonan', $value)->exists();

                        if (!($existsInPromosi || $existsInLiputan)) {
                            $fail('Kode proses publikasi tidak ditemukan.');
                        }
                    },
                ],
                'jenis_proses' => 'required|string|in:Diterima,Diproses,Selesai',
            ],
            [
                'id_proses_permohonan.required' => 'Kode proses publikasi wajib diisi.',
                'id_proses_permohonan.string' => 'Kode proses publikasi harus berupa teks.',
                'jenis_proses.required' => 'Jenis proses wajib diisi.',
                'jenis_proses.string' => 'Jenis proses harus berupa teks.',
                'jenis_proses.in' => 'Jenis proses tidak valid.',
            ],
        );

        try {
            $split = explode('-', $id_proses_permohonan['id_proses_permohonan']);
            $tipe = $split[0];

            if ($tipe == 'LIPUTAN') {
                $terima_liputan = Liputan::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();

                if ($terima_liputan) {
                    $terima_proses_permohonan = ProsesPermohonan::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();

                    if ($terima_proses_permohonan->status_verifikasi == 'Batal') {
                        return response()->json(['error' => 'Permohonan publikasi sudah dibatalkan.'], 403);
                    }

                    $updateData = ['status' => $id_proses_permohonan['jenis_proses']];

                    if ($id_proses_permohonan['jenis_proses'] === 'Diterima') {
                        $updateData['tanggal_diterima'] = Carbon::now();
                    } elseif ($id_proses_permohonan['jenis_proses'] === 'Diproses') {
                        $updateData['tanggal_diproses'] = Carbon::now();
                    } elseif ($id_proses_permohonan['jenis_proses'] === 'Selesai') {
                        $updateData['tanggal_selesai'] = Carbon::now();
                    }

                    $terima_proses_permohonan->update($updateData);

                    $emailController = new EmailController();
                    $response = $emailController->kirimEmailStatus($id_proses_permohonan['id_proses_permohonan']);
                    if ($response->getStatusCode() !== 200) {
                        return $response;
                    }

                    return response()->json(['message' => 'Proses permohonan publikasi berhasil diubah.']);
                } else {
                    return response()->json(['error' => 'Kode Lacak Permintaan Publikasi Tidak Dapat Ditemukan.'], 404);
                }
            } elseif ($tipe == 'PROMOSI') {
                $terima_promosi = Promosi::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();

                if ($terima_promosi) {
                    $terima_proses_permohonan = ProsesPermohonan::where('id_proses_permohonan', $id_proses_permohonan['id_proses_permohonan'])->first();

                    if ($terima_proses_permohonan->status_verifikasi == 'Batal') {
                        return response()->json(['error' => 'Permohonan publikasi sudah dibatalkan.'], 403);
                    }

                    $updateData = ['status' => $id_proses_permohonan['jenis_proses']];

                    if ($id_proses_permohonan['jenis_proses'] === 'Diterima') {
                        $updateData['tanggal_diterima'] = Carbon::now();
                    } elseif ($id_proses_permohonan['jenis_proses'] === 'Diproses') {
                        $updateData['tanggal_diproses'] = Carbon::now();
                    } elseif ($id_proses_permohonan['jenis_proses'] === 'Selesai') {
                        $updateData['tanggal_selesai'] = Carbon::now();
                    }

                    $terima_proses_permohonan->update($updateData);

                    $emailController = new EmailController();
                    $response = $emailController->kirimEmailStatus($id_proses_permohonan['id_proses_permohonan']);
                    if ($response->getStatusCode() !== 200) {
                        return $response;
                    }

                    return response()->json(['message' => 'Proses permohonan publikasi berhasil diubah.']);
                } else {
                    return response()->json(['error' => 'Kode Lacak Permintaan Publikasi Tidak Dapat Ditemukan.'], 404);
                }
            } else {
                return response()->json(['error' => 'Kode Lacak Permintaan Publikasi Tidak Dapat Ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
