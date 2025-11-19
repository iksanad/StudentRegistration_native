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
