<?php
$title = 'Registrasi Admin';
include 'app/views/layouts/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-4">
    <h2 class="mb-3 text-center">Registrasi Admin</h2>

    <?php if (!empty($success)): ?>
      <div class="alert alert-success">Berhasil membuat user. Silakan login.</div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <?php if ($error == 1): ?>
        <div class="alert alert-danger">Username dan password wajib diisi.</div>
      <?php elseif ($error == 2): ?>
        <div class="alert alert-danger">Konfirmasi password tidak sama.</div>
      <?php elseif ($error == 3): ?>
        <div class="alert alert-danger">Username sudah digunakan.</div>
      <?php else: ?>
        <div class="alert alert-danger">Terjadi kesalahan saat menyimpan data.</div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <form action="index.php?action=storeRegister" method="post">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
      </div>
    </div>

    <p class="mt-3 text-center">
      Sudah punya akun? <a href="index.php?action=login">Login di sini</a>
    </p>
  </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
