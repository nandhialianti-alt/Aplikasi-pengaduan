# Website Aplikasi Pengaduan Sarana Sekolah

Aplikasi berbasis web untuk manajemen pengaduan sarana dan prasarana sekolah. Dibangun menggunakan PHP Native dengan pendekatan modular untuk kemudahan pemeliharaan.

## Fitur Utama
- **Multi-role Authentication**: Akses berbeda untuk Admin dan Siswa.
- **Sistem Aspirasi**: Siswa dapat mengirim pengaduan dengan kategori tertentu.
- **Tracking Status**: Pemantauan progres pengaduan (Baru -> Diproses -> Selesai).
- **Sistem Umpan Balik**: Admin dapat memberikan balasan langsung ke pengirim.
- **Filtering Laporan**: Pencarian data berdasarkan tanggal, bulan, siswa, dan kategori.
- **Responsive Layout**: Optimal di desktop maupun perangkat mobile.

## Teknologi
- **Backend**: PHP Native
- **Frontend**: HTML5, CSS3 (Custom), Bootstrap 5
- **Database**: MySQL (RDBMS via XAMPP)
- **Database Access**: MySQLi Extension

## Instalasi
1. Pindahkan folder `Nandhia` ke dalam folder `htdocs` XAMPP Anda.
2. Buat database baru bernama `pengaduan_sekolah` melalui phpMyAdmin.
3. Import file `database.sql`.
4. Buka browser dan akses `localhost/Nandhia`.

## Akun Demo
- **Admin**: `admin` / `admin123`
- **Siswa**: `siswa` / `siswa123`

---
*Dibuat oleh Antigravity untuk Nandhia*
