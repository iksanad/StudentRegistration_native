<?php
class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        // jika sudah login, langsung ke halaman utama
        if (!empty($_SESSION['user_id'])) {
            header("Location: index.php?action=index");
            exit;
        }
        $error = $_GET['error'] ?? null;
        include 'app/views/auth/login.php';
    }

    public function doLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=login");
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByUsername($username);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            header("Location: index.php?action=login&error=1");
            exit;
        }

        // set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: index.php?action=index");
        exit;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }

    // opsional: halaman registrasi user baru
    public function register()
    {
        $error = $_GET['error'] ?? null;
        $success = $_GET['success'] ?? null;
        include 'app/views/auth/register.php';
    }

    public function storeRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=register");
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if ($username === '' || $password === '') {
            header("Location: index.php?action=register&error=1");
            exit;
        }
        if ($password !== $confirm) {
            header("Location: index.php?action=register&error=2");
            exit;
        }

        // cek sudah ada atau belum
        $existing = $this->userModel->findByUsername($username);
        if ($existing) {
            header("Location: index.php?action=register&error=3");
            exit;
        }

        if ($this->userModel->create($username, $password, 'admin')) {
            header("Location: index.php?action=register&success=1");
            exit;
        } else {
            header("Location: index.php?action=register&error=4");
            exit;
        }
    }
}
