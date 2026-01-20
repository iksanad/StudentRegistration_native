<?php
$title = 'Pendaftaran Saya - PPDB Online';
include 'app/views/layouts/header.php';
?>

<div class="page-header fade-in">
    <h1><i class="bi bi-file-earmark-person me-2"></i>Data Pendaftaran Saya</h1>
    <p>Detail lengkap data pendaftaran Anda</p>
</div>

<?php if (!empty($myRegistration)): ?>
<div class="row g-4">
    <!-- Data Pribadi -->
    <div class="col-md-8 fade-in">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-vcard me-2"></i>Data Pribadi
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <p class="fw-bold mb-0"><?= htmlspecialchars($myRegistration['nama_lengkap']); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">NISN</label>
                        <p class="fw-bold mb-0"><?= htmlspecialchars($myRegistration['nisn'] ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Jenis Kelamin</label>
                        <p class="fw-bold mb-0"><?= $myRegistration['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Tanggal Lahir</label>
                        <p class="fw-bold mb-0">
                            <?= !empty($myRegistration['tanggal_lahir']) ? date('d F Y', strtotime($myRegistration['tanggal_lahir'])) : '-'; ?>
                        </p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label text-muted">Alamat</label>
                        <p class="fw-bold mb-0"><?= htmlspecialchars($myRegistration['alamat'] ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Asal Sekolah</label>
                        <p class="fw-bold mb-0"><?= htmlspecialchars($myRegistration['asal_sekolah'] ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Orang Tua/Wali</label>
                        <p class="fw-bold mb-0"><?= htmlspecialchars($myRegistration['nama_ortu'] ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">No. HP</label>
                        <p class="fw-bold mb-0"><?= htmlspecialchars($myRegistration['no_hp'] ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Tanggal Daftar</label>
                        <p class="fw-bold mb-0"><?= date('d F Y, H:i', strtotime($myRegistration['tgl_daftar'])); ?> WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Foto & Dokumen -->
    <div class="col-md-4 fade-in">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-camera me-2"></i>Foto
            </div>
            <div class="card-body text-center">
                <?php if (!empty($myRegistration['foto'])): ?>
                <img src="uploads/foto/<?= htmlspecialchars($myRegistration['foto']); ?>" 
                     alt="Foto Pendaftar" class="img-fluid rounded" style="max-height: 200px;">
                <?php else: ?>
                <div class="bg-light rounded p-5">
                    <i class="bi bi-image fs-1 text-muted"></i>
                    <p class="text-muted mb-0 mt-2">Belum ada foto</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="bi bi-folder me-2"></i>Dokumen
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                    <div>
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                        Akta Kelahiran
                    </div>
                    <?php if (!empty($myRegistration['dokumen_akta'])): ?>
                    <a href="uploads/dokumen/<?= htmlspecialchars($myRegistration['dokumen_akta']); ?>" 
                       class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="bi bi-eye"></i>
                    </a>
                    <?php else: ?>
                    <span class="badge bg-secondary">Belum upload</span>
                    <?php endif; ?>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                        Kartu Keluarga
                    </div>
                    <?php if (!empty($myRegistration['dokumen_kk'])): ?>
                    <a href="uploads/dokumen/<?= htmlspecialchars($myRegistration['dokumen_kk']); ?>" 
                       class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="bi bi-eye"></i>
                    </a>
                    <?php else: ?>
                    <span class="badge bg-secondary">Belum upload</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card fade-in">
    <div class="card-body text-center py-5">
        <i class="bi bi-file-earmark-x fs-1 text-muted d-block mb-3"></i>
        <h4>Data Pendaftaran Tidak Ditemukan</h4>
        <p class="text-muted">Anda belum terdaftar dalam sistem. Silakan hubungi admin untuk mendaftarkan diri.</p>
        <a href="index.php?action=user_dashboard" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
        </a>
    </div>
</div>
<?php endif; ?>

<?php include 'app/views/layouts/footer.php'; ?>
