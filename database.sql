/* Tambahkan Database dulu */
CREATE DATABASE student_registration;
USE student_registration;

CREATE TABLE pendaftar (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap    VARCHAR(100) NOT NULL,
    nisn            VARCHAR(20),
    jenis_kelamin   ENUM('L','P') NOT NULL,
    tanggal_lahir   DATE,
    alamat          TEXT,
    asal_sekolah    VARCHAR(100),
    nama_ortu       VARCHAR(100),
    no_hp           VARCHAR(20),
    tgl_daftar      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel user untuk autentikasi
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*
Untuk membuat user admin pertama, jalankan di MySQL (ganti HASH dengan hasil password_hash di PHP):

INSERT INTO users (username, password_hash, role)
VALUES ('admin', '$2y...hash_dari_password_hash...', 'admin');

Atau gunakan halaman Registrasi Admin (index.php?action=register).
*/
