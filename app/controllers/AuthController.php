<?php
/**
 * =============================================================================
 * CLASS: AuthController
 * =============================================================================
 * Controller untuk menangani proses autentikasi pengguna.
 * Kelas ini mengatur login, logout, dan registrasi untuk admin maupun user biasa.
 * 
 * Fitur utama:
 * - Login dengan pengecekan di tabel admins dan users
 * - Registrasi untuk admin dan user
 * - Logout dan penghapusan session
 * - Redirect berdasarkan role (admin/user)
 * =============================================================================
 */
class AuthController
{
    /**
     * @var User Model untuk mengakses data user
     */
    private $userModel;

    /**
     * @var Admin Model untuk mengakses data admin
     */
    private $adminModel;

    /**
     * -------------------------------------------------------------------------
     * Constructor / Konstruktor
     * -------------------------------------------------------------------------
     * Inisialisasi model User dan Admin yang akan digunakan untuk
     * proses autentikasi.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->userModel = new User();
        $this->adminModel = new Admin();
    }

    /**
     * -------------------------------------------------------------------------
     * Menampilkan Halaman Login
     * -------------------------------------------------------------------------
     * Fungsi ini menampilkan form login kepada pengguna.
     * Jika user sudah login (session aktif), akan langsung diarahkan
     * ke dashboard sesuai role-nya.
     * 
     * @return void Menampilkan view login atau redirect ke dashboard
     */
    public function login()
    {
        // jika sudah login, redirect sesuai role
        if (!empty($_SESSION['user_id'])) {
            $this->redirectByRole();
        }
        $error = $_GET['error'] ?? null;
        include 'app/views/auth/login.php';
    }

    /**
     * -------------------------------------------------------------------------
     * Proses Login (Verifikasi Kredensial)
     * -------------------------------------------------------------------------
     * Fungsi ini memproses data login yang dikirim via POST.
     * Alur pengecekan:
     * 1. Cek di tabel admins terlebih dahulu
     * 2. Jika tidak ditemukan, cek di tabel users
     * 3. Jika kredensial valid, simpan data ke session
     * 4. Redirect ke dashboard sesuai role
     * 
     * @return void Redirect ke dashboard atau kembali ke login dengan error
     */
    public function doLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=login");
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Cek di tabel admins dulu
        $admin = $this->adminModel->findByUsername($username);
        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['role'] = 'admin';
            $_SESSION['nama_lengkap'] = $admin['nama_lengkap'];
            $this->redirectByRole();
        }

        // Kalau bukan admin, cek di tabel users
        $user = $this->userModel->findByUsername($username);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'user';
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $this->redirectByRole();
        }

        // Gagal login
        header("Location: index.php?action=login&error=1");
        exit;
    }

    /**
     * -------------------------------------------------------------------------
     * Redirect Berdasarkan Role Pengguna
     * -------------------------------------------------------------------------
     * Fungsi helper untuk mengarahkan user ke halaman yang sesuai
     * berdasarkan role yang tersimpan di session.
     * - Admin → Dashboard Admin
     * - User → Dashboard User
     * 
     * @return void Redirect dan terminasi script
     */
    private function redirectByRole()
    {
        if ($_SESSION['role'] === 'admin') {
            header("Location: index.php?action=dashboard");
        } else {
            header("Location: index.php?action=user_dashboard");
        }
        exit;
    }

    /**
     * -------------------------------------------------------------------------
     * Proses Logout
     * -------------------------------------------------------------------------
     * Fungsi ini menghapus semua data session dan mengakhiri sesi pengguna.
     * Setelah logout, user akan diarahkan kembali ke halaman login.
     * 
     * @return void Redirect ke halaman login
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }

    /**
     * -------------------------------------------------------------------------
     * Menampilkan Halaman Registrasi
     * -------------------------------------------------------------------------
     * Fungsi ini menampilkan form registrasi di mana pengguna baru
     * dapat mendaftar sebagai admin atau user biasa.
     * 
     * @return void Menampilkan view registrasi
     */
    public function register()
    {
        $error = $_GET['error'] ?? null;
        $success = $_GET['success'] ?? null;
        include 'app/views/auth/register.php';
    }

    /**
     * -------------------------------------------------------------------------
     * Proses Registrasi Akun Baru
     * -------------------------------------------------------------------------
     * Fungsi ini memproses data registrasi yang dikirim via POST.
     * 
     * Validasi yang dilakukan:
     * 1. Cek role valid (admin/user)
     * 2. Cek username dan password tidak kosong
     * 3. Cek password dan konfirmasi cocok
     * 4. Cek username belum digunakan di kedua tabel
     * 
     * Error codes:
     * - error=1: Username atau password kosong
     * - error=2: Password dan konfirmasi tidak cocok
     * - error=3: Username sudah digunakan
     * - error=4: Gagal menyimpan ke database
     * 
     * @return void Redirect ke login (sukses) atau register (gagal)
     */
    public function storeRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=register");
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';
        $role     = $_POST['role'] ?? 'user';
        $namaLengkap = trim($_POST['nama_lengkap'] ?? '');

        // Validasi role
        if (!in_array($role, ['admin', 'user'])) {
            $role = 'user';
        }

        if ($username === '' || $password === '') {
            header("Location: index.php?action=register&error=1");
            exit;
        }
        if ($password !== $confirm) {
            header("Location: index.php?action=register&error=2");
            exit;
        }

        // Cek username sudah ada di kedua tabel
        $existingAdmin = $this->adminModel->findByUsername($username);
        $existingUser = $this->userModel->findByUsername($username);
        if ($existingAdmin || $existingUser) {
            header("Location: index.php?action=register&error=3");
            exit;
        }

        // Simpan ke tabel yang sesuai
        $success = false;
        if ($role === 'admin') {
            $success = $this->adminModel->create($username, $password, $namaLengkap);
        } else {
            $success = $this->userModel->create($username, $password, $namaLengkap);
        }

        if ($success) {
            header("Location: index.php?action=login&registered=1");
            exit;
        } else {
            header("Location: index.php?action=register&error=4");
            exit;
        }
    }
}
