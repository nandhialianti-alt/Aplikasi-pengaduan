# Implementation Plan - Pengaduan Sarana Sekolah

Project for building a school facility complaint web application.

## 1. Project Structure (Modular/MVC-ish)
- `config/` - Database connection and global constants.
- `includes/` - Helper functions and shared logic.
- `layouts/` - UI components (header, sidebar, footer).
- `modules/`
  - `auth/` - Login/Logout logic.
  - `siswa/` - Student specific features.
  - `admin/` - Admin specific features.
- `assets/` - CSS, JS, and images.
- `index.php` - Entry point/Router.
- `database.sql` - Database schema.

## 2. Database Schema
- `users`: `id_user`, `nama`, `username`, `password_md5`, `role`
- `kategori`: `id_kategori`, `nama_kategori`
- `aspirasi`: `id_aspirasi`, `id_user`, `id_kategori`, `tanggal`, `isi`, `status`
- `umpan_balik`: `id_feedback`, `id_aspirasi`, `balasan`, `tanggal`

## 3. Implementation Steps
- [ ] Setup database and `config.php`.
- [ ] Create authentication system (Login/Logout).
- [ ] Design modern UI layout (Bootstrap 5 + Custom CSS).
- [ ] Implement Siswa Dashboard & Aspirasi Form.
- [ ] Implement Admin Dashboard & Aspirasi Management.
- [ ] Add filters and feedback functionality.
- [ ] Generate documentation (ERD, Flowchart, etc.).
