CREATE DATABASE IF NOT EXISTS peminjaman;
USE peminjaman;

-- Tabel user
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE ruangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ruangan VARCHAR(100) NOT NULL,
    lokasi TEXT,
    kapasitas INT
);

CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    ruangan_id INT,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    keterangan TEXT,
    dokumen VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (ruangan_id) REFERENCES ruangan(id)
);
