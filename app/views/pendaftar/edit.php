<?php
$title = 'Edit Data Pendaftar';
include 'app/views/layouts/header.php';
?>

<div class="page-header fade-in">
    <h1><i class="bi bi-pencil-square me-2"></i>Edit Data Pendaftar</h1>
    <p>Perbarui data pendaftaran peserta didik</p>
</div>

<div class="card fade-in">
    <div class="card-body">
        <form action="index.php?action=update&id=<?= $data['id']; ?>" method="post" enctype="multipart/form-data">
            
            <div class="row">
                <!-- Data Pribadi -->
                <div class="col-md-8">
                    <h5 class="mb-3 text-primary"><i class="bi bi-person-vcard me-2"></i>Data Pribadi</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" value="<?= htmlspecialchars($data['nisn'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" <?= ($data['jenis_kelamin'] ?? '') === 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?= ($data['jenis_kelamin'] ?? '') === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?= htmlspecialchars($data['tanggal_lahir'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" class="form-control" value="<?= htmlspecialchars($data['asal_sekolah'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Orang Tua/Wali</label>
                            <input type="text" name="nama_ortu" class="form-control" value="<?= htmlspecialchars($data['nama_ortu'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($data['no_hp'] ?? ''); ?>">
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="col-md-4">
                    <h5 class="mb-3 text-primary"><i class="bi bi-cloud-upload me-2"></i>Dokumen</h5>
                    
                    <div class="mb-4">
                        <label class="form-label">Foto Siswa</label>
                        <?php if (!empty($data['foto'])): ?>
                        <div class="mb-2">
                            <img src="uploads/foto/<?= htmlspecialchars($data['foto']); ?>" alt="Foto" class="file-preview">
                            <small class="d-block text-muted mt-1">File saat ini</small>
                        </div>
                        <?php endif; ?>
                        <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png" onchange="previewImage(this, 'previewFoto')">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                        <div class="mt-2">
                            <img id="previewFoto" src="#" alt="Preview" class="file-preview d-none">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Akta Kelahiran</label>
                        <?php if (!empty($data['dokumen_akta'])): ?>
                        <div class="mb-2">
                            <a href="uploads/dokumen/<?= htmlspecialchars($data['dokumen_akta']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark me-1"></i>Lihat File
                            </a>
                        </div>
                        <?php endif; ?>
                        <input type="file" name="dokumen_akta" class="form-control" accept="image/jpeg,image/png,application/pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kartu Keluarga</label>
                        <?php if (!empty($data['dokumen_kk'])): ?>
                        <div class="mb-2">
                            <a href="uploads/dokumen/<?= htmlspecialchars($data['dokumen_kk']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark me-1"></i>Lihat File
                            </a>
                        </div>
                        <?php endif; ?>
                        <input type="file" name="dokumen_kk" class="form-control" accept="image/jpeg,image/png,application/pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                </button>
                <a href="index.php?action=index" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include 'app/views/layouts/footer.php'; ?>
