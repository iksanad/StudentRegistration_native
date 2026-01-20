<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PPDB - Penerimaan Peserta Didik Baru'; ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <?php if (!empty($useDataTable)): ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <?php endif; ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php?action=index">
        <i class="bi bi-mortarboard-fill me-2"></i>PPDB Online
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (!empty($_SESSION['user_id'])): ?>
        
        <!-- Menu untuk ADMIN -->
        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=dashboard">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=index">
            <i class="bi bi-people me-1"></i>Data Pendaftar
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=create">
            <i class="bi bi-person-plus me-1"></i>Tambah Pendaftar
          </a>
        </li>
        <?php else: ?>
        <!-- Menu untuk USER biasa -->
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=user_dashboard">
            <i class="bi bi-house me-1"></i>Beranda
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=my_registration">
            <i class="bi bi-file-earmark-text me-1"></i>Pendaftaran Saya
          </a>
        </li>
        <?php endif; ?>
        
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (!empty($_SESSION['user_id'])): ?>
        <li class="nav-item d-flex align-items-center me-3">
            <span class="badge <?= $_SESSION['role'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                <i class="bi <?= $_SESSION['role'] === 'admin' ? 'bi-shield-check' : 'bi-person'; ?> me-1"></i>
                <?= ucfirst($_SESSION['role']); ?>
            </span>
        </li>
        <li class="nav-item">
          <span class="nav-link">
            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['username'] ?? ''); ?>
          </span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=logout">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
          </a>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=login">
            <i class="bi bi-box-arrow-in-right me-1"></i>Login
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=register">
            <i class="bi bi-person-plus me-1"></i>Daftar
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container py-4">
