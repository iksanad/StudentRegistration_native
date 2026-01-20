<?php
$title = 'Beranda - PPDB Online';
include 'app/views/layouts/header.php';
?>

<div class="page-header fade-in">
    <h1><i class="bi bi-house-heart me-2"></i>Selamat Datang!</h1>
    <p>Halo, <?= htmlspecialchars($_SESSION['username']); ?>! Pantau status pendaftaran Anda di sini.</p>
</div>

<div class="row g-4">
    <!-- Status Pendaftaran -->
    <div class="col-md-8 fade-in">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-file-earmark-check me-2"></i>Status Pendaftaran Saya
            </div>
            <div class="card-body">
                <?php if (!empty($myRegistration)): ?>
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <?php if (!empty($myRegistration['foto'])): ?>
                        <img src="uploads/foto/<?= htmlspecialchars($myRegistration['foto']); ?>" 
                             alt="Foto" class="file-preview rounded-circle" style="width: 120px; height: 120px;">
                        <?php else: ?>
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px;">
                            <i class="bi bi-person-fill fs-1 text-muted"></i>
                        </div>
                        <?php endif; ?>
                        <h5 class="mt-3 mb-0"><?= htmlspecialchars($myRegistration['nama_lengkap']); ?></h5>
                        <small class="text-muted">NISN: <?= htmlspecialchars($myRegistration['nisn'] ?? '-'); ?></small>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><i class="bi bi-calendar3 me-2"></i>Tanggal Daftar</td>
                                <td><strong><?= date('d F Y', strtotime($myRegistration['tgl_daftar'])); ?></strong></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-gender-ambiguous me-2"></i>Jenis Kelamin</td>
                                <td><strong><?= $myRegistration['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></strong></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-building me-2"></i>Asal Sekolah</td>
                                <td><strong><?= htmlspecialchars($myRegistration['asal_sekolah'] ?? '-'); ?></strong></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-telephone me-2"></i>No. HP</td>
                                <td><strong><?= htmlspecialchars($myRegistration['no_hp'] ?? '-'); ?></strong></td>
                            </tr>
                        </table>
                        
                        <div class="mt-3">
                            <a href="index.php?action=my_registration" class="btn btn-primary">
                                <i class="bi bi-eye me-1"></i>Lihat Detail Lengkap
                            </a>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-x fs-1 text-muted d-block mb-3"></i>
                    <h5>Anda belum melakukan pendaftaran</h5>
                    <p class="text-muted">Silakan hubungi admin untuk mendaftarkan diri Anda.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Info Panel -->
    <div class="col-md-4 fade-in">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Informasi
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="bi bi-calendar-event text-primary fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Periode Pendaftaran</small>
                        <strong>2025/2026</strong>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Status</small>
                        <strong class="text-success">Pendaftaran Dibuka</strong>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="bi bi-question-circle me-2"></i>Butuh Bantuan?
            </div>
            <div class="card-body">
                <p class="text-muted small">Jika ada pertanyaan seputar pendaftaran, silakan hubungi:</p>
                <p class="mb-1"><i class="bi bi-telephone me-2"></i>(021) 1234-5678</p>
                <p class="mb-0"><i class="bi bi-envelope me-2"></i>info@sekolah.sch.id</p>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
