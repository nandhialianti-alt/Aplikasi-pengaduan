-- Database for Pengaduan Sarana Sekolah

CREATE DATABASE IF NOT EXISTS pengaduan_sekolah;
USE pengaduan_sekolah;

-- Users table
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_md5 VARCHAR(32) NOT NULL,
    role ENUM('admin', 'siswa') NOT NULL
) ENGINE=InnoDB;

-- Kategori table
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- Aspirasi table
CREATE TABLE aspirasi (
    id_aspirasi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_kategori INT NOT NULL,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    isi TEXT NOT NULL,
    status ENUM('baru', 'diproses', 'selesai') DEFAULT 'baru',
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Umpan balik table
CREATE TABLE umpan_balik (
    id_feedback INT AUTO_INCREMENT PRIMARY KEY,
    id_aspirasi INT NOT NULL,
    balasan TEXT NOT NULL,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_aspirasi) REFERENCES aspirasi(id_aspirasi) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Notifikasi table
CREATE TABLE notifikasi (
    id_notifikasi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    pesan TEXT NOT NULL,
    tipe VARCHAR(50) NOT NULL, -- login, logout, aspirasi_baru, balasan
    is_read BOOLEAN DEFAULT FALSE,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Initial Data
INSERT INTO users (nama, username, password_md5, role) VALUES 
('Administrator', 'admin', MD5('admin123'), 'admin'),
('Siswa Contoh', 'siswa', MD5('siswa123'), 'siswa');

INSERT INTO kategori (nama_kategori) VALUES 
('Kebersihan'),
('Kerusakan Kelas'),
('Fasilitas Olahraga'),
('Perpustakaan'),
('Lain-lain');
