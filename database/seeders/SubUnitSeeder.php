<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = DB::table('unit')->pluck('id_unit', 'nama_unit');

        DB::table('sub_unit')->insert([
            // Sub-unit Kemahasiswaan
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Perwakilan Mahasiswa Universitas',
                'deskripsi' => 'Badan Perwakilan Mahasiswa Universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Eksekutif Mahasiswa Universitas',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Perwakilan Mahasiswa Fakultas Teologi',
                'deskripsi' => 'Badan Perwakilan Mahasiswa Fakultas Teologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Eksekutif Mahasiswa Teologi',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Teologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Perwakilan Mahasiswa Fakultas Bioteknologi',
                'deskripsi' => 'Badan Perwakilan Mahasiswa Fakultas Bioteknologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Eksekutif Mahasiswa Fakultas Bioteknologi',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Fakultas Bioteknologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Eksekutif Mahasiswa Fakultas Kedokteran',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Fakultas Kedokteran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Eksekutif Mahasiswa Fakultas Arsitektur dan Desain',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Fakultas Arsitektur dan Desain.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan perwakilan Mahasiswa Fakultas Bisnis ',
                'deskripsi' => 'Badan Perwakilan Mahasiswa Fakultas Bisnis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Eksekutif Mahasiswa Fakultas Bisnis ',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Fakultas Bisnis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Perwakilan Mahasiswa Fakultas Teknologi Informasi',
                'deskripsi' => 'Badan Perwakilan Mahasiswa Fakultas Teknologi Informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan Eksekutif Mahasiswa Fakultas Teknologi Informasi',
                'deskripsi' => 'Badan Eksekutif Mahasiswa Fakultas Teknologi Informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Badan perwakilan Mahasiswa Fakultas Bisnis ',
                'deskripsi' => 'Badan Perwakilan Mahasiswa Fakultas Bisnis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Himpunan Mahasiswa Fakultas Teologi',
                'deskripsi' => 'Himpunan Mahasiswa Teknik Informatika.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Himpunan Mahasiswa Sistem Informasi',
                'deskripsi' => 'Himpunan Mahasiswa Sistem Informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Himpunan Mahasiswa Program Studi Manajemen',
                'deskripsi' => 'Himpunan Mahasiswa Program Studi Manajemen.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Himpunan Mahasiswa Program Studi Akuntansi',
                'deskripsi' => 'Himpunan Mahasiswa Program Studi Akuntansi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Himpunan Mahasiswa Program Studi Pendidikan Bahasa Inggris',
                'deskripsi' => 'Himpunan Mahasiswa Program Studi Pendidikan Bahasa Inggris.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Himpunan Mahasiswa Desain produk',
                'deskripsi' => 'Himpunan Mahasiswa Desain produk.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga Kemahasiswaan'],
                'nama_sub_unit' => 'Himpunan Mahasiswa Arsitektur',
                'deskripsi' => 'Himpunan Mahasiswa Arsitektur.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            //sub-unit UKM
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Duta Wacana Football Club',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Duta Wacana Football Club.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Basket',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Basket.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Badminton',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Badminton.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Taekwondo',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Taekwondo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Jeet Kune Do',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Jeet Kune Do.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Net Club',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Net Club.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Line Club',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Line Club.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Duta Wacana Photographic Club',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Duta Wacana Photographic Club.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Gapala',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Gapala.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Duta Voice',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Duta Voice.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Duta Film',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Duta Film.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Mahasiswa'],
                'nama_sub_unit' => 'UKM Duta Dance',
                'deskripsi' => 'Unit Kegiatan Mahasiswa Duta Dance.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Unit Kegiatan Kebudayaan

            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb Kawanua',
                'deskripsi' => 'Unit Kegiatan Kebudayaan Kawanua.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb Sandlewood',
                'deskripsi' => 'Unit Kegiatan Kebudayaan Sandlewood.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb Salawaku',
                'deskripsi' => 'Unit Kegiatan Kebudayaan Salawaku.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb Merga Silima',
                'deskripsi' => 'Unit Kegiatan Kebudayaan Merga Silima.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb IMBADA',
                'deskripsi' => 'Unit Kegiatan Kebudayaan IMBADA.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb IMKA',
                'deskripsi' => 'Unit Kegiatan Kebudayaan IMKA.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb SINTUWU',
                'deskripsi' => 'Unit Kegiatan Kebudayaan SINTUWU.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb DUTOR',
                'deskripsi' => 'Unit Kegiatan Kebudayaan DUTOR.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb IMT',
                'deskripsi' => 'Unit Kegiatan Kebudayaan IMT.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb KBMJ',
                'deskripsi' => 'Unit Kegiatan Kebudayaan KBMJ.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb Cendana',
                'deskripsi' => 'Unit Kegiatan Kebudayaan Cendana.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kebudayaan'],
                'nama_sub_unit' => 'UKKb Formapa',
                'deskripsi' => 'Unit Kegiatan Kebudayaan Formapa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],



            // Sub-unit Unit Kegiatan Kerohanian

            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'PMKT UKDW',
                'deskripsi' => 'Unit Kegiatan Kerohanian PMK UKDW.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'PMK Soli Deo Gloria',
                'deskripsi' => 'Unit Kegiatan Kerohanian PMK Soli Deo Gloria.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'Persekutuan Mahasiswa Kristen Fakultas Bioteknologi',
                'deskripsi' => 'Unit Kegiatan Kerohanian Persekutuan Mahasiswa Kristen Fakultas Bioteknologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'PMK Agape',
                'deskripsi' => 'Unit Kegiatan Kerohanian PMK Agape.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'Keluarga Mahasiswa Katolik Fakultas Kedokteran',
                'deskripsi' => 'Unit Kegiatan Kerohanian Keluarga Mahasiswa Katolik Fakultas Kedokteran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'Keluarga Mahasiswa Katolik',
                'deskripsi' => 'Unit Kegiatan Kerohanian Keluarga Mahasiswa Katolik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'Keluarga Mahasiswa Hindu Dharma',
                'deskripsi' => 'Unit Kegiatan Kerohanian Keluarga Mahasiswa Hindu Dharma.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'Keluarga Mahasiswa Buddhis Duta Dharma',
                'deskripsi' => 'Unit Kegiatan Kerohanian Keluarga Mahasiswa Buddhis Duta Dharma.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit Kegiatan Kerohanian'],
                'nama_sub_unit' => 'Keluarga Mahasiswa Muslim',
                'deskripsi' => 'Unit Kegiatan Kerohanian Keluarga Mahasiswa Muslim.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Biro
            [
                'id_unit' => $units['Biro'],
                'nama_sub_unit' => 'Biro Administrasi Akademik (Biro I)',
                'deskripsi' => 'Mengelola administrasi akademik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Biro'],
                'nama_sub_unit' => 'Biro Administrasi dan Keuangan (Biro II)',
                'deskripsi' => 'Mengelola administrasi dan keuangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Biro'],
                'nama_sub_unit' => 'Biro Kemahasiswaan,Alumni dan Pengembangan Karir (Biro III)',
                'deskripsi' => 'Mengelola kegiatan kemahasiswaan dan pengembangan karir.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Biro'],
                'nama_sub_unit' => 'Biro Kerjasama dan Relasi Publik (Biro IV)',
                'deskripsi' => 'Mengelola kerjasama dan hubungan publik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Biro'],
                'nama_sub_unit' => 'Biro Pengembangan Sumber Daya Manusia',
                'deskripsi' => 'Mengelola pengembangan sumber daya manusia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Pusat
            [
                'id_unit' => $units['Pusat'],
                'nama_sub_unit' => 'Pusat Pelayanan Informasi dan Intranet Kampus (PUSPINdiKA)',
                'deskripsi' => 'Mengelola pelayanan informasi dan intranet kampus.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Pusat'],
                'nama_sub_unit' => 'Pusat Pelatihan Bahasa',
                'deskripsi' => 'Menyediakan pelatihan bahasa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Pusat'],
                'nama_sub_unit' => 'Pusat Penempatan Kerja dan Pengembangan kwirausahaan (PPKPK)',
                'deskripsi' => 'Mengelola penempatan kerja dan pengembangan kewirausahaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Pusat'],
                'nama_sub_unit' => 'Pusat Pelatihan dan Layanan Komputer (PPLK)',
                'deskripsi' => 'Menyediakan pelatihan dan layanan komputer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Lembaga
            [
                'id_unit' => $units['Lembaga'],
                'nama_sub_unit' => 'Lembaga Penelitian dan Pengabdian Masyarakat (LPPM)',
                'deskripsi' => 'Mengelola penelitian dan pengabdian masyarakat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga'],
                'nama_sub_unit' => 'Lembaga Penembangan Akademik dan Inovasi Pembelajaran (LPAIP)',
                'deskripsi' => 'Mengelola pengembangan akademik dan inovasi pembelajaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Lembaga'],
                'nama_sub_unit' => 'Lembaga Pelayanan Kerohanian,Konseling dan Spiritualitas Kampus',
                'deskripsi' => 'Mengelola pelayanan kerohanian, konseling, dan spiritualitas kampus.',
                'deskripsi' => 'Mengelola pengembangan akademik dan inovasi pembelajaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //sub-unit Dektorat
            [
                'id_unit' => $units['Direktorat'],
                'nama_sub_unit' => 'Direktorat Penjaminan Mutu Institusi (InQA)',
                'deskripsi' => 'Mengelola penjaminan mutu institusi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //Sekretariat
            [
                'id_unit' => $units['Sekretariat'],
                'nama_sub_unit' => 'Yayasan',
                'deskripsi' => 'Yayasan yang mengelola kegiatan universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Sekretariat'],
                'nama_sub_unit' => 'Rektorat',
                'deskripsi' => 'Rektorat yang mengelola kegiatan universitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //sub-unit Unit
            [
                'id_unit' => $units['Unit'],
                'nama_sub_unit' => 'Admisi Promosi UKDW',
                'deskripsi' => 'Mengelola kegiatan promosi dan penerimaan mahasiswa baru.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit'],
                'nama_sub_unit' => 'Centrino',
                'deskripsi' => 'Menyediakan layanan komputer dan teknologi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit'],
                'nama_sub_unit' => 'Poliklinik',
                'deskripsi' => 'Menyediakan layanan kesehatan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit'],
                'nama_sub_unit' => 'Perpustakaan',
                'deskripsi' => 'Menyediakan layanan perpustakaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit'],
                'nama_sub_unit' => 'Mata Kuliah Humaniora',
                'deskripsi' => 'Menyediakan mata kuliah humaniora.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit'],
                'nama_sub_unit' => 'Unit Kerumahtanggaan (KRT)',
                'deskripsi' => 'Mengelola kegiatan kerumahtanggaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Unit'],
                'nama_sub_unit' => 'Unit Pengembangan Institusi (UPI)',
                'deskripsi' => 'Mengelola pengembangan institusi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Fakultas Teologi
            [
                'id_unit' => $units['Fakultas Teologi'],
                'nama_sub_unit' => 'Administratif Fakultas Teologi',
                'deskripsi' =>  'Administratif Fakultas Teologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Teologi'],
                'nama_sub_unit' => 'Filsafat keilahian Sarjana',
                'deskripsi' =>  'program studi yang mempelajari filsafat keilahian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Teologi'],
                'nama_sub_unit' => 'Filsafat keilahian Magister',
                'deskripsi' =>  'program studi yang mempelajari filsafat keilahian tingkat Magister.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Teologi'],
                'nama_sub_unit' => 'Doktor Teologi',
                'deskripsi' =>  'program studi yang mempelajari teologi pada tingkat doktor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // Sub-unit Fakultas Arsitektur dan Desain
            [
                'id_unit' => $units['Fakultas Arsitektur dan Desain'],
                'nama_sub_unit' => 'Administratif Fakultas Arsitektur dan Desain',
                'deskripsi' =>  'Administratif Fakultas Arsitektur dan Desain.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Arsitektur dan Desain'],
                'nama_sub_unit' => 'Arsitektur',
                'deskripsi' =>  'program studi yang mempelajari arsitektur.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Arsitektur dan Desain'],
                'nama_sub_unit' => 'Arsitektur Magister',
                'deskripsi' =>  'program studi yang mempelajari arsitektur pada tingkat Magister.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Arsitektur dan Desain'],
                'nama_sub_unit' => 'Desain Produk',
                'deskripsi' =>  'program studi yang mempelajari desain produk.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-unit Fakultas Bioteknologi
            [
                'id_unit' => $units['Fakultas Bioteknologi'],
                'nama_sub_unit' => 'Administratif Fakultas Bioteknologi',
                'deskripsi' =>  'Administratif Fakultas Bioteknologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Bioteknologi'],
                'nama_sub_unit' => 'Biologi',
                'deskripsi' =>  'program studi yang mempelajari biologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // sub-unit Fakultas Bisnis
            [
                'id_unit' => $units['Fakultas Bisnis'],
                'nama_sub_unit' => 'Administratif Fakultas Bisnis',
                'deskripsi' =>  'Administratif Fakultas Bisnis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Bisnis'],
                'nama_sub_unit' => 'Manajemen',
                'deskripsi' =>  'program studi yang mempelajari manajemen.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Bisnis'],
                'nama_sub_unit' => 'Manajemen Magister',
                'deskripsi' =>  'program studi yang mempelajari manajemen pada tingkat Magister.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Bisnis'],
                'nama_sub_unit' => 'Akuntansi',
                'deskripsi' =>  'program studi yang mempelajari akuntansi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // sub-unit Fakultas Teknologi Informasi
            [
                'id_unit' => $units['Fakultas Teknologi Informasi'],
                'nama_sub_unit' => 'Administratif Fakultass Teknologi Informasi',
                'deskripsi' =>  'Administratif Fakultas Teknologi Informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Teknologi Informasi'],
                'nama_sub_unit' => 'Informatika',
                'deskripsi' =>  'program studi yang mempelajari teknik informatika.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Teknologi Informasi'],
                'nama_sub_unit' => 'Sistem Informasi',
                'deskripsi' =>  'program studi yang mempelajari sistem informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // sub-unit Fakultas Kedokteran
            [
                'id_unit' => $units['Fakultas Kedokteran'],
                'nama_sub_unit' => 'Administratif Fakultas Kedokteran',
                'deskripsi' =>  'Administratif Fakultas Kedokteran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Kedokteran'],
                'nama_sub_unit' => 'Kedokteran',
                'deskripsi' =>  'program studi yang mempelajari kedokteran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Kedokteran'],
                'nama_sub_unit' => 'profesi Dokter',
                'deskripsi' => 'program studi yang mempelajari profesi dokter.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // sub-unit Fakultas Kependidikan dan Humaniora
            [
                'id_unit' => $units['Fakultas Kependidikan dan Humaniora'],
                'nama_sub_unit' => 'Administratif Fakultas Kependidikan dan Humaniora',
                'deskripsi' =>  "Administratif Fakultas Kependidikan dan Humaniora.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Kependidikan dan Humaniora'],
                'nama_sub_unit' => 'Studi Humanitas',
                'deskripsi' =>  'program studi yang mempelajari humaniora.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_unit' => $units['Fakultas Kependidikan dan Humaniora'],
                'nama_sub_unit' => 'Pendidikan Bahasa Inggris',
                'deskripsi' =>  'program studi yang mempelajari pendidikan bahasa Inggris.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}
