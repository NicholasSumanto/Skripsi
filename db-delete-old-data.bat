@echo off
REM Pindah ke direktori tempat .bat ini berada
cd /d %~dp0

php artisan db:hapus-verifikasi-kadaluwarsa
