<?php
$title = 'Login';
include 'app/views/layouts/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-4">
    <h2 class="mb-3 text-center">Login Admin</h2>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger">Username atau password salah.</div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <form action="index.php?action=doLogin" method="post">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>

    <p class="mt-3 text-center">
      (Opsional) <a href="index.php?action=register">Daftar admin baru</a>
    </p>
  </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
