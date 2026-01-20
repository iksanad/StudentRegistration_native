<?php
$title = 'Data Pendaftar';
$useDataTable = true;
include 'app/views/layouts/header.php';
?>

<div class="page-header fade-in">
    <h1><i class="bi bi-people me-2"></i>Data Pendaftar</h1>
    <p>Daftar seluruh peserta didik yang telah mendaftar</p>
</div>

<?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="index.php?action=create" class="btn btn-primary mb-3 fade-in">
        <i class="bi bi-person-plus me-1"></i>Tambah Pendaftar
    </a>
<?php endif; ?>

<?php if (!empty($status)): ?>
    <?php if ($status == 'sukses'): ?>
        <div class="alert alert-success fade-in"><i class="bi bi-check-circle me-2"></i>Data berhasil disimpan.</div>
    <?php elseif ($status == 'update_sukses'): ?>
        <div class="alert alert-success fade-in"><i class="bi bi-check-circle me-2"></i>Data berhasil diupdate.</div>
    <?php elseif ($status == 'hapus_sukses'): ?>
        <div class="alert alert-success fade-in"><i class="bi bi-check-circle me-2"></i>Data berhasil dihapus.</div>
    <?php elseif ($status == 'hapus_gagal'): ?>
        <div class="alert alert-danger fade-in"><i class="bi bi-x-circle me-2"></i>Data gagal dihapus.</div>
    <?php endif; ?>
<?php endif; ?>

<div class="card fade-in">
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelPendaftar" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>NISN</th>
                        <th>JK</th>
                        <th>Asal Sekolah</th>
                        <th>No HP</th>
                        <th>Dokumen</th>
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
                        <td class="text-center">
                            <?php if (!empty($row['foto'])): ?>
                                <img src="uploads/foto/<?= htmlspecialchars($row['foto']); ?>" alt="Foto" 
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <span class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                      style="width: 40px; height: 40px;">
                                    <i class="bi bi-person"></i>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                        <td><?= htmlspecialchars($row['nisn']); ?></td>
                        <td>
                            <span class="badge <?= $row['jenis_kelamin'] == 'L' ? 'bg-info' : 'bg-pink'; ?>" 
                                  style="<?= $row['jenis_kelamin'] == 'P' ? 'background: #ec4899;' : ''; ?>">
                                <?= $row['jenis_kelamin'] == 'L' ? 'L' : 'P'; ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['asal_sekolah']); ?></td>
                        <td><?= htmlspecialchars($row['no_hp']); ?></td>
                        <td>
                            <?php if (!empty($row['dokumen_akta'])): ?>
                                <a href="uploads/dokumen/<?= htmlspecialchars($row['dokumen_akta']); ?>" target="_blank" 
                                   class="btn btn-sm btn-outline-secondary" title="Akta">
                                    <i class="bi bi-file-earmark"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($row['dokumen_kk'])): ?>
                                <a href="uploads/dokumen/<?= htmlspecialchars($row['dokumen_kk']); ?>" target="_blank" 
                                   class="btn btn-sm btn-outline-secondary" title="KK">
                                    <i class="bi bi-file-earmark-text"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (empty($row['dokumen_akta']) && empty($row['dokumen_kk'])): ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($row['tgl_daftar'])); ?></td>
                        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <td>
                            <a href="index.php?action=edit&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="index.php?action=delete&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Yakin ingin menghapus data ini?');">
                                <i class="bi bi-trash"></i>
                            </a>
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
