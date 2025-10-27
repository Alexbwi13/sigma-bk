-- Buat database
CREATE DATABASE IF NOT EXISTS sigma_bk;
USE sigma_bk;

-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100)
);

-- Insert data users
INSERT INTO users (username, password, nama) VALUES
('BK01', 'BK01', 'Ibu Tri Atmiji'),
('BK02', 'BK02', 'Ibu Mega Silviana'),
('BK03', 'BK03', 'Bapak Muhammad Nurhadi'),
('BK04', 'BK04', 'Ibu Ulfi Rachma Amzi'),
('BK05', 'BK05', 'Bapak Abdul Rahmad Tuasikal'),
('BK06', 'BK06', 'Ibu Fajriyatus Syifa'),
('BK07', 'BK07', NULL),
('BK08', 'BK08', NULL),
('BK09', 'BK09', NULL),
('BK10', 'BK10', NULL);

-- Tabel layanan_bk
CREATE TABLE layanan_bk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jenis_layanan ENUM('konseling_individu', 'konseling_kelompok', 'bimbingan_kelompok', 
                      'bimbingan_klasikal', 'kolaborasi', 'mediasi', 'konsultasi', 'home_visit'),
    tanggal DATE,
    nama_siswa TEXT,
    kelas VARCHAR(20),
    topik TEXT,
    deskripsi TEXT,
    tindak_lanjut TEXT,
    status ENUM('selesai', 'berkelanjutan'),
    alamat TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);