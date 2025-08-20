# 📌 Skripsi - Sistem Publikasi

Aplikasi ini adalah sistem publikasi berbasis web yang dibangun dengan **Laravel**.  
Fitur utama: pengajuan publikasi, manajemen proses oleh staff, notifikasi email, dan monitoring status publikasi.

---

## ⚙️ Installation

Jalankan perintah berikut secara berurutan:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
npm run dev

## 🚀 How this Application Works

### 1. 🔑 Registrasi & Login
- Pengguna dapat membuat akun baru atau login dengan akun yang sudah ada.  
- Sistem mendukung autentikasi berbasis **role**:
  - **Pemohon** → mengajukan permohonan publikasi.  
  - **Staff** → memproses pengajuan publikasi.  

---

### 2. 📝 Pengajuan Publikasi (Pemohon)
- Pemohon mengisi form pengajuan publikasi.  
- Pemohon dapat melampirkan file (dokumen/foto).  

---

### 3. 👨‍💼 Proses Publikasi (Staff)
- Staff melihat daftar pengajuan publikasi.  
- Staff dapat memperbarui status pengajuan:
  - **Diproses**  
  - **Diterima**  
  - **Selesai**  
- Sistem mengirim **notifikasi email otomatis** kepada pemohon sesuai perubahan status.  

---

### 4. 📊 Riwayat & Monitoring
- **Pemohon** dapat memantau status pengajuan publikasi yang diajukan.  
- **Staff** dapat melihat riwayat seluruh publikasi yang sudah diproses.  
