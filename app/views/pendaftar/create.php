<?php
$title = 'Form Registrasi Peserta Didik Baru';
include 'app/views/layouts/header.php';
?>

<div class="page-header fade-in">
    <h1><i class="bi bi-person-plus me-2"></i>Registrasi Peserta Didik Baru</h1>
    <p>Lengkapi data pendaftaran calon peserta didik</p>
</div>

<div class="card fade-in">
    <div class="card-body">
        <form action="index.php?action=store" method="post" enctype="multipart/form-data">
            
            <div class="row">
                <!-- Data Pribadi -->
                <div class="col-md-8">
                    <!-- Link ke Akun User -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <h5 class="mb-3 text-success"><i class="bi bi-link-45deg me-2"></i>Hubungkan ke Akun User</h5>
                        <div class="mb-3">
                            <label class="form-label">Pilih Akun User (Opsional)</label>
                            <select name="user_id" class="form-select">
                                <option value="">-- Tidak dihubungkan --</option>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id']; ?>">
                                            <?= htmlspecialchars($user['nama_lengkap'] ?: $user['username']); ?> 
                                            (@<?= htmlspecialchars($user['username']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">Hubungkan pendaftar ini ke akun user yang sudah terdaftar</small>
                        </div>
                    </div>

                    <h5 class="mb-3 text-primary"><i class="bi bi-person-vcard me-2"></i>Data Pribadi</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" placeholder="Nomor Induk Siswa Nasional">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama sekolah asal">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Orang Tua/Wali</label>
                            <input type="text" name="nama_ortu" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Nomor yang bisa dihubungi">
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="col-md-4">
                    <h5 class="mb-3 text-primary"><i class="bi bi-cloud-upload me-2"></i>Upload Dokumen</h5>
                    
                    <div class="mb-4">
                        <label class="form-label">Foto Siswa</label>
                        <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png" onchange="previewImage(this, 'previewFoto')">
                        <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                        <div class="mt-2">
                            <img id="previewFoto" src="#" alt="Preview" class="file-preview d-none">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Akta Kelahiran</label>
                        <input type="file" name="dokumen_akta" class="form-control" accept="image/jpeg,image/png,application/pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kartu Keluarga</label>
                        <input type="file" name="dokumen_kk" class="form-control" accept="image/jpeg,image/png,application/pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Simpan Data
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
