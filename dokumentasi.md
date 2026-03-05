# Dokumentasi Aplikasi Pengaduan Sarana Sekolah

Aplikasi ini dirancang untuk memudahkan siswa dalam melaporkan kerusakan atau keluhan terkait sarana sekolah dan memungkinkan admin untuk mengelola laporan tersebut secara terorganisir.

## 1. Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS ||--o{ ASPIRASI : "mengajukan"
    KATEGORI ||--o{ ASPIRASI : "mengelompokkan"
    ASPIRASI ||--o{ UMPAN_BALIK : "mendapatkan"

    USERS {
        int id_user PK
        string nama
        string username
        string password_md5
        enum role
    }

    KATEGORI {
        int id_kategori PK
        string nama_kategori
    }

    ASPIRASI {
        int id_aspirasi PK
        int id_user FK
        int id_kategori FK
        datetime tanggal
        text isi
        enum status
    }

    UMPAN_BALIK {
        int id_feedback PK
        int id_aspirasi FK
        text balasan
        datetime tanggal
    }
```

## 2. Flowchart Program

### Alur Siswa
```mermaid
graph TD
    A[Login Siswa] --> B{Login Berhasil?}
    B -- Tidak --> A
    B -- Ya --> C[Dashboard Siswa]
    C --> D[Isi Form Aspirasi]
    D --> E[Simpan ke Database]
    E --> F[Lihat Histori & Status]
    F --> G[Lihat Umpan Balik Admin]
```

### Alur Admin
```mermaid
graph TD
    A[Login Admin] --> B{Login Berhasil?}
    B -- Tidak --> A
    B -- Ya --> C[Dashboard Admin]
    C --> D[Lihat Daftar Aspirasi]
    D --> E[Filter Data]
    E --> F[Detail Aspirasi]
    F --> G[Update Status]
    G --> H[Kirim Umpan Balik]
```

## 3. Dokumentasi Fungsi & Prosedur

| Fungsi / Prosedur | Deskripsi | Parameter |
|-------------------|-----------|-----------|
| `redirect($url)` | Mengalihkan halaman ke URL tujuan. | `$url` (string) |
| `sanitize($data)` | Membersihkan input dari karakter berbahaya (XSS & SQL Injection). | `$data` (string) |
| `check_login()` | Memvalidasi apakah user sudah login melalui session. | - |
| `check_role($role)`| Memvalidasi hak akses user berdasarkan role (admin/siswa). | `$expected_role` (string) |
| `format_date($date)`| Mengubah format tanggal database ke format yang mudah dibaca. | `$date` (datetime) |
| `get_status_class($s)`| Mengembalikan class CSS Bootstrap berdasarkan status aspirasi. | `$status` (string) |

## 4. Laporan Debugging Singkat

Berikut adalah ringkasan proses debugging selama pengembangan:

1.  **Issue**: Muncul error "Undefined index" pada saat memproses filter di `list_aspirasi.php`.
    *   **Penyelesaian**: Menggunakan operator null coalescing (`??`) atau pengecekan `empty()` sebelum variabel digunakan di query.
2.  **Issue**: Password MD5 tidak cocok antara input login dan database.
    *   **Penyelesaian**: Memastikan input password di-hash `md5()` sebelum dibandingkan di query SQL.
3.  **Issue**: Relasi database gagal (Foreign Key Constraint) saat menghapus user.
    *   **Penyelesaian**: Menambahkan `ON DELETE CASCADE` pada relasi tabel `aspirasi` dan `umpan_balik`.
4.  **Issue**: UI berantakan di layar kecil.
    *   **Penyelesaian**: Mengoptimalkan grid Bootstrap menggunakan class `col-md-*` dan `table-responsive`.

## 5. Cara Penggunaan

1.  Import file `database.sql` ke dalam MySQL / phpMyAdmin.
2.  Sesuaikan konfigurasi database di `config/database.php`.
3.  Login menggunakan akun default:
    *   **Admin**: `admin` / `admin123`
    *   **Siswa**: `siswa` / `siswa123`
