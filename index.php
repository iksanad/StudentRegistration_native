<?php
/**
 * =============================================================================
 * FILE: index.php (Front Controller / Router Utama)
 * =============================================================================
 * File ini adalah entry point utama dari aplikasi Student Registration.
 * Semua request akan masuk melalui file ini dan diarahkan ke controller yang sesuai.
 * 
 * Alur Kerja:
 * 1. Session dimulai untuk menyimpan data login pengguna
 * 2. File konfigurasi dan model/controller di-include
 * 3. Parameter 'action' dari URL menentukan halaman yang ditampilkan
 * 4. Controller yang sesuai dipanggil berdasarkan action
 * 
 * Contoh URL:
 * - index.php?action=login     → Halaman login
 * - index.php?action=dashboard → Dashboard admin
 * - index.php?action=create    → Form tambah pendaftar
 * =============================================================================
 */

// Memulai session untuk tracking login user
session_start();

// Include file konfigurasi database
require 'config.php';

// Include semua model (Data Access Layer)
require 'app/models/Pendaftar.php';
require 'app/models/User.php';
require 'app/models/Admin.php';

// Include semua controller (Business Logic Layer)
require 'app/controllers/PendaftarController.php';
require 'app/controllers/AuthController.php';

/**
 * Mengambil parameter 'action' dari URL untuk menentukan halaman yang diminta.
 * Jika tidak ada action, default ke 'index' (daftar pendaftar).
 */
$action = $_GET['action'] ?? 'index';

/**
 * =============================================================================
 * ROUTING TABLE
 * =============================================================================
 * Switch case ini berfungsi sebagai router sederhana.
 * Menghubungkan setiap action dengan method controller yang sesuai.
 */
switch ($action) {
    // =========================================================================
    // AUTH ROUTES (Autentikasi)
    // =========================================================================
    
    /**
     * Menampilkan halaman login
     */
    case 'login':
        (new AuthController())->login();
        break;
    
    /**
     * Memproses data login yang dikirim via POST
     */
    case 'doLogin':
        (new AuthController())->doLogin();
        break;
    
    /**
     * Proses logout dan hapus session
     */
    case 'logout':
        (new AuthController())->logout();
        break;
    
    /**
     * Menampilkan halaman registrasi
     */
    case 'register':
        (new AuthController())->register();
        break;
    
    /**
     * Memproses data registrasi yang dikirim via POST
     */
    case 'storeRegister':
        (new AuthController())->storeRegister();
        break;

    // =========================================================================
    // DASHBOARD ROUTES
    // =========================================================================
    
    /**
     * Dashboard admin dengan statistik pendaftar
     */
    case 'dashboard':
        (new PendaftarController())->dashboard();
        break;
    
    /**
     * Dashboard user untuk melihat status pendaftaran sendiri
     */
    case 'user_dashboard':
        (new PendaftarController())->userDashboard();
        break;
    
    /**
     * Halaman detail pendaftaran user yang sedang login
     */
    case 'my_registration':
        (new PendaftarController())->myRegistration();
        break;

    // =========================================================================
    // PENDAFTAR ROUTES (CRUD Operations)
    // =========================================================================
    
    /**
     * Menampilkan daftar semua pendaftar (protected - perlu login)
     */
    case 'index':
        (new PendaftarController())->index();
        break;
    
    /**
     * Menampilkan form tambah pendaftar baru (admin only)
     */
    case 'create':
        (new PendaftarController())->create();
        break;
    
    /**
     * Memproses penyimpanan pendaftar baru (admin only)
     */
    case 'store':
        (new PendaftarController())->store();
        break;
    
    /**
     * Menampilkan form edit pendaftar (admin only)
     */
    case 'edit':
        (new PendaftarController())->edit();
        break;
    
    /**
     * Memproses update data pendaftar (admin only)
     */
    case 'update':
        (new PendaftarController())->update();
        break;
    
    /**
     * Menghapus data pendaftar (admin only)
     */
    case 'delete':
        (new PendaftarController())->delete();
        break;

    // =========================================================================
    // DEFAULT (404 - Halaman Tidak Ditemukan)
    // =========================================================================
    default:
        echo "Halaman tidak ditemukan.";
        break;
}
