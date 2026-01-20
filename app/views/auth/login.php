<?php
$title = 'Login - PPDB Online';
include 'app/views/layouts/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5 fade-in">
        <div class="card auth-card">
            <div class="card-header">
                <i class="bi bi-mortarboard-fill fs-1 d-block mb-2"></i>
                <h4>Masuk ke PPDB Online</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($_GET['registered'])): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>Registrasi berhasil! Silakan login.
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle me-2"></i>Username atau password salah!
                    </div>
                <?php endif; ?>
                
                <form action="index.php?action=doLogin" method="post">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-person me-1"></i>Username
                        </label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-lock me-1"></i>Password
                        </label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </button>
                </form>
                
                <hr class="my-4">
                
                <p class="text-center mb-0">
                    Belum punya akun? 
                    <a href="index.php?action=register" class="text-decoration-none">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
