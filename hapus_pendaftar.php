<?php
include 'config.php';

// Ambil ID dari parameter URL
$id = $_GET['id'] ?? 0;
$id = (int)$id;

if ($id <= 0) {
    // ID tidak valid
    header("Location: data_pendaftar.php?status=hapus_gagal");
    exit;
}

// Siapkan query DELETE
$sql = "DELETE FROM pendaftar WHERE id = ?";

$stmt = $koneksi->prepare($sql);
if (!$stmt) {
    // jika prepare gagal
    header("Location: data_pendaftar.php?status=hapus_gagal");
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Berhasil hapus
    header("Location: data_pendaftar.php?status=hapus_sukses");
    exit;
} else {
    // Gagal hapus
    header("Location: data_pendaftar.php?status=hapus_gagal");
    exit;
}

$stmt->close();
