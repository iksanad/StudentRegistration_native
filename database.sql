-- =========================================================
-- Student Registration DB (Separate Admin & User Tables)
-- =========================================================

-- 1) Buat database kalau belum ada
CREATE DATABASE IF NOT EXISTS student_registration
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- 2) Pakai databasenya
USE student_registration;

-- 3) Matikan cek FK sementara
SET FOREIGN_KEY_CHECKS = 0;

-- 4) Drop tabel lama
DROP TABLE IF EXISTS pendaftar;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admins;

-- 5) Nyalakan lagi cek FK
SET FOREIGN_KEY_CHECKS = 1;

-- =========================================================
-- TABLE: admins (untuk petugas sekolah)
-- =========================================================
CREATE TABLE admins (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nama_lengkap  VARCHAR(100) NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================================
-- TABLE: users (untuk peserta didik / orang tua)
-- =========================================================
CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nama_lengkap  VARCHAR(100) NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================================
-- TABLE: pendaftar
-- =========================================================
CREATE TABLE pendaftar (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT NULL,

    nama_lengkap    VARCHAR(100) NOT NULL,
    nisn            VARCHAR(20)  NULL,
    jenis_kelamin   ENUM('L','P') NOT NULL,
    tanggal_lahir   DATE NULL,
    alamat          TEXT NULL,
    asal_sekolah    VARCHAR(100) NULL,
    nama_ortu       VARCHAR(100) NULL,
    no_hp           VARCHAR(20)  NULL,

    foto            VARCHAR(255) NULL,
    dokumen_akta    VARCHAR(255) NULL,
    dokumen_kk      VARCHAR(255) NULL,

    tgl_daftar      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_pendaftar_user
      FOREIGN KEY (user_id) REFERENCES users(id)
      ON UPDATE CASCADE
      ON DELETE SET NULL
) ENGINE=InnoDB;

-- =========================================================
-- Seed admin default
-- Password: password
-- =========================================================
INSERT INTO admins (username, password_hash, nama_lengkap)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');
