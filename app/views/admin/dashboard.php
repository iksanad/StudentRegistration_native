<?php
$title = 'Dashboard Admin';
include 'app/views/layouts/header.php';

// Get statistics
$stats = [
    'total' => $totalPendaftar ?? 0,
    'today' => $todayPendaftar ?? 0,
    'male' => $malePendaftar ?? 0,
    'female' => $femalePendaftar ?? 0,
];
?>

<div class="page-header fade-in">
    <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h1>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?>! Kelola data pendaftaran dengan mudah.</p>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6 fade-in">
        <div class="stat-card primary">
            <i class="bi bi-people-fill stat-icon"></i>
            <div class="stat-value"><?= $stats['total']; ?></div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 fade-in">
        <div class="stat-card success">
            <i class="bi bi-calendar-check stat-icon"></i>
            <div class="stat-value"><?= $stats['today']; ?></div>
            <div class="stat-label">Pendaftar Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 fade-in">
        <div class="stat-card info">
            <i class="bi bi-gender-male stat-icon"></i>
            <div class="stat-value"><?= $stats['male']; ?></div>
            <div class="stat-label">Laki-laki</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 fade-in">
        <div class="stat-card warning">
            <i class="bi bi-gender-female stat-icon"></i>
            <div class="stat-value"><?= $stats['female']; ?></div>
            <div class="stat-label">Perempuan</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4">
    <div class="col-md-6 fade-in">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-lightning-fill me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <a href="index.php?action=create" class="quick-action mb-3">
                    <i class="bi bi-person-plus-fill"></i>
                    <div>
                        <strong>Tambah Pendaftar Baru</strong>
                        <small class="d-block text-muted">Daftarkan peserta didik baru</small>
                    </div>
                </a>
                <a href="index.php?action=index" class="quick-action mb-3">
                    <i class="bi bi-table"></i>
                    <div>
                        <strong>Lihat Semua Data</strong>
                        <small class="d-block text-muted">Kelola data pendaftar</small>
                    </div>
                </a>
                <a href="index.php?action=register" class="quick-action">
                    <i class="bi bi-person-gear"></i>
                    <div>
                        <strong>Kelola Akun</strong>
                        <small class="d-block text-muted">Tambah admin atau user baru</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 fade-in">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-clock-history me-2"></i>Pendaftar Terbaru
            </div>
            <div class="card-body">
                <?php if (!empty($recentPendaftar)): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Asal Sekolah</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPendaftar as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['nama_lengkap']); ?></td>
                                <td><?= htmlspecialchars($p['asal_sekolah']); ?></td>
                                <td><small><?= date('d/m/Y', strtotime($p['tgl_daftar'])); ?></small></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted text-center my-4">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada pendaftar
                </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
