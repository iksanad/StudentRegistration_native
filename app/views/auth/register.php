<?php
$title = 'Registrasi Akun - PPDB Online';
include 'app/views/layouts/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5 fade-in">
        <div class="card auth-card">
            <div class="card-header">
                <i class="bi bi-person-plus-fill fs-1 d-block mb-2"></i>
                <h4>Registrasi Akun Baru</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>Registrasi berhasil! Silakan login.
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php
                        switch ($error) {
                            case '1': echo 'Username dan password wajib diisi.'; break;
                            case '2': echo 'Password tidak cocok.'; break;
                            case '3': echo 'Username sudah digunakan.'; break;
                            case '4': echo 'Gagal menyimpan data. Silakan coba lagi.'; break;
                            default: echo 'Terjadi kesalahan.';
                        }
                        ?>
                    </div>
                <?php endif; ?>
                
                <form action="index.php?action=storeRegister" method="post">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-person-badge me-1"></i>Nama Lengkap
                        </label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama lengkap Anda">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-person me-1"></i>Username
                        </label>
                        <input type="text" name="username" class="form-control" placeholder="Pilih username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-lock me-1"></i>Password
                        </label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password
                        </label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-person-badge me-1"></i>Daftar Sebagai
                        </label>
                        <select name="role" class="form-select">
                            <option value="user">User (Peserta Didik/Orang Tua)</option>
                            <option value="admin">Admin (Petugas Sekolah)</option>
                        </select>
                        <small class="text-muted">Pilih sesuai peran Anda</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-person-plus me-1"></i>Daftar
                    </button>
                </form>
                
                <hr class="my-4">
                
                <p class="text-center mb-0">
                    Sudah punya akun? 
                    <a href="index.php?action=login" class="text-decoration-none">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
