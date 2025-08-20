Installation :

composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
npm run dev


How this Application work :

Registrasi/Login :
Pengguna dapat membuat akun atau login dengan akun yang sudah ada.
Sistem mendukung autentikasi dengan role (pemohon & staff).

Pengajuan Publikasi :
Pemohon dapat mengisi form pengajuan publikasi.
Dapat melampirkan file (dokumen/foto).

Proses Publikasi oleh Staff :
Staff dapat melihat daftar pengajuan.
Staff dapat mengubah status (diproses, diterima, selesai).
Notifikasi email akan dikirim sesuai perubahan status.

Riwayat & Monitoring :
Pemohon bisa memantau status pengajuan.
Staff bisa melihat riwayat publikasi.
