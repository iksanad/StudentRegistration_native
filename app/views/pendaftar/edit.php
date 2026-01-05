<?php
$title = 'Edit Data Pendaftar';
include 'app/views/layouts/header.php';
?>

<h1 class="mb-3">Edit Data Pendaftar</h1>
<a href="index.php?action=index" class="btn btn-secondary mb-3">Kembali ke Data Pendaftar</a>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=update&id=<?= $data['id']; ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">NISN</label>
                <input type="text" name="nisn" class="form-control" value="<?= htmlspecialchars($data['nisn']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" <?= $data['jenis_kelamin'] === 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= $data['jenis_kelamin'] === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?= htmlspecialchars($data['tanggal_lahir']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($data['alamat']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" class="form-control" value="<?= htmlspecialchars($data['asal_sekolah']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Orang Tua/Wali</label>
                <input type="text" name="nama_ortu" class="form-control" value="<?= htmlspecialchars($data['nama_ortu']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($data['no_hp']); ?>">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
