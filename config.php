<?php
/**
 * =============================================================================
 * FILE: config.php (Konfigurasi Database)
 * =============================================================================
 * File ini berisi konfigurasi koneksi database MySQL.
 * Pastikan untuk menyesuaikan nilai-nilai di bawah ini dengan
 * konfigurasi server MySQL Anda.
 * 
 * KEAMANAN:
 * - Jangan pernah commit file ini dengan password asli ke repository publik
 * - Gunakan environment variables untuk production
 * =============================================================================
 */

/**
 * Mengaktifkan error reporting untuk debugging.
 * PENTING: Nonaktifkan di production untuk keamanan!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * =============================================================================
 * KONFIGURASI DATABASE
 * =============================================================================
 */

/** @var string Host database (biasanya 'localhost' untuk pengembangan lokal) */
$host     = "localhost";

/** @var string Username database (default XAMPP adalah 'root') */
$user     = "root";

/** @var string Password database (default XAMPP kosong) */
$password = "";

/** @var string Nama database yang digunakan */
$dbname   = "student_registration";

/** @var int Port MySQL (default 3306) */
$port     = 3306;

/**
 * =============================================================================
 * MEMBUAT KONEKSI DATABASE
 * =============================================================================
 * Membuat objek mysqli untuk koneksi ke database.
 * Variabel $koneksi akan digunakan secara global di seluruh aplikasi.
 */
$koneksi = new mysqli($host, $user, $password, $dbname, $port);

/**
 * Pengecekan koneksi database.
 * Jika koneksi gagal, aplikasi akan berhenti dan menampilkan pesan error.
 */
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
