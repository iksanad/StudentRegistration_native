<?php
include 'config.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;
$id = (int)$id;

// Jika form dikirim (method POST) maka proses update berjalan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap  = $_POST['nama_lengkap'] ?? '';
    $nisn          = $_POST['nisn'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? null;
    $alamat        = $_POST['alamat'] ?? '';
    $asal_sekolah  = $_POST['asal_sekolah'] ?? '';
    $nama_ortu     = $_POST['nama_ortu'] ?? '';
    $no_hp         = $_POST['no_hp'] ?? '';

    $sql = "UPDATE pendaftar
            SET nama_lengkap = ?, 
                nisn = ?, 
                jenis_kelamin = ?, 
                tanggal_lahir = ?, 
                alamat = ?, 
                asal_sekolah = ?, 
                nama_ortu = ?, 
                no_hp = ?
            WHERE id = ?";

    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        die("Error prepare: " . $koneksi->error);
    }

    $stmt->bind_param(
        "ssssssssi",
        $nama_lengkap,
        $nisn,
        $jenis_kelamin,
        $tanggal_lahir,
        $alamat,
        $asal_sekolah,
        $nama_ortu,
        $no_hp,
        $id
    );

    if ($stmt->execute()) {
        header("Location: data_pendaftar.php?status=update_sukses");
        exit;
    } else {
        $error = "Terjadi kesalahan saat mengupdate data: " . $stmt->error;
    }

    $stmt->close();
}

// Jika GET (belum submit) maka ambil data lama untuk ditampilkan di form
$sql_ambil = "SELECT * FROM pendaftar WHERE id = ?";
$stmt_ambil = $koneksi->prepare($sql_ambil);
if (!$stmt_ambil) {
    die("Error prepare: " . $koneksi->error);
}
$stmt_ambil->bind_param("i", $id);
$stmt_ambil->execute();
$hasil = $stmt_ambil->get_result();
$data  = $hasil->fetch_assoc();
$stmt_ambil->close();

if (!$data) {
    die("Data tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Pendaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-3">Edit Data Pendaftar</h1>
        <a href="data_pendaftar.php" class="btn btn-secondary mb-3">Kembali ke Data Pendaftar</a>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="" method="post">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>