<?php
include 'config.php';
$result = $koneksi->query("SELECT * FROM pendaftar ORDER BY tgl_daftar DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pendaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-3">Data Pendaftar</h1>

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'sukses'): ?>
                <div class="alert alert-success">Data berhasil disimpan.</div>
            <?php elseif ($_GET['status'] == 'update_sukses'): ?>
                <div class="alert alert-success">Data berhasil diupdate.</div>
            <?php elseif ($_GET['status'] == 'hapus_sukses'): ?>
                <div class="alert alert-success">Data berhasil dihapus.</div>
            <?php elseif ($_GET['status'] == 'hapus_gagal'): ?>
                <div class="alert alert-danger">Data gagal dihapus.</div>
            <?php endif; ?>
        <?php endif; ?>

        <a href="form_pendaftaran.php" class="btn btn-primary mb-3">Tambah Pendaftar</a>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelPendaftar" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NISN</th>
                                <th>JK</th>
                                <th>Asal Sekolah</th>
                                <th>Nama Ortu</th>
                                <th>No HP</th>
                                <th>Tgl Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result->fetch_assoc()):
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                    <td><?= htmlspecialchars($row['nisn']); ?></td>
                                    <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                                    <td><?= htmlspecialchars($row['asal_sekolah']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_ortu']); ?></td>
                                    <td><?= htmlspecialchars($row['no_hp']); ?></td>
                                    <td><?= $row['tgl_daftar']; ?></td>
                                    <td>
                                        <a href="edit_pendaftar.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <a href="hapus_pendaftar.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?');">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelPendaftar').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100]
            });
        });
    </script>
</body>

</html>