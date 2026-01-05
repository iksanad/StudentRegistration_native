<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Student Registration'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php if (!empty($useDataTable)): ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <?php endif; ?>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php?action=index">PPDB</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (!empty($_SESSION['user_id'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=index">Data Pendaftar</a>
        </li>
        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=create">Tambah Pendaftar</a>
        </li>
        <?php endif; ?>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (!empty($_SESSION['user_id'])): ?>
        <li class="nav-item">
          <span class="nav-link navbar-text me-3">Login sebagai : <?= htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=logout">Logout</a>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=login">Login</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container py-4">
