<?php
$title = 'Data Pendaftar';
$useDataTable = true;
include 'app/views/layouts/header.php';
?>

<h1 class="mb-3">Data Pendaftar</h1>
<?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="index.php?action=create" class="btn btn-primary mb-3">Tambah Pendaftar</a>
<?php endif; ?>


<?php if (!empty($status)): ?>
    <?php if ($status == 'sukses'): ?>
        <div class="alert alert-success">Data berhasil disimpan.</div>
    <?php elseif ($status == 'update_sukses'): ?>
        <div class="alert alert-success">Data berhasil diupdate.</div>
    <?php elseif ($status == 'hapus_sukses'): ?>
        <div class="alert alert-success">Data berhasil dihapus.</div>
    <?php elseif ($status == 'hapus_gagal'): ?>
        <div class="alert alert-danger">Data gagal dihapus.</div>
    <?php endif; ?>
<?php endif; ?>

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
                        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
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
                        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <td>
                            <a href="index.php?action=edit&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="index.php?action=delete&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
