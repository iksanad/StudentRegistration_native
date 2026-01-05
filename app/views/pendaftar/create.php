<?php
$title = 'Form Registrasi Peserta Didik Baru';
include 'app/views/layouts/header.php';
?>

<h1 class="mb-3">Registrasi Peserta Didik Baru</h1>
<a href="index.php?action=index" class="btn btn-secondary mb-3">Lihat Data Pendaftar</a>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=store" method="post">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">NISN</label>
                <input type="text" name="nisn" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Orang Tua/Wali</label>
                <input type="text" name="nama_ortu" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
