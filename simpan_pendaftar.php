<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap  = $_POST['nama_lengkap'] ?? '';
    $nisn          = $_POST['nisn'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? null;
    $alamat        = $_POST['alamat'] ?? '';
    $asal_sekolah  = $_POST['asal_sekolah'] ?? '';
    $nama_ortu     = $_POST['nama_ortu'] ?? '';
    $no_hp         = $_POST['no_hp'] ?? '';

    $sql = "INSERT INTO pendaftar 
            (nama_lengkap, nisn, jenis_kelamin, tanggal_lahir, alamat, asal_sekolah, nama_ortu, no_hp)
            VALUES (?,?,?,?,?,?,?,?)";

    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        die("Error prepare: " . $koneksi->error);
    }

    $stmt->bind_param(
        "ssssssss",
        $nama_lengkap,
        $nisn,
        $jenis_kelamin,
        $tanggal_lahir,
        $alamat,
        $asal_sekolah,
        $nama_ortu,
        $no_hp
    );

    if ($stmt->execute()) {
        header("Location: data_pendaftar.php?status=sukses");
        exit;
    } else {
        echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
    }

    $stmt->close();
} else {
    header("Location: form_pendaftaran.php");
    exit;
}
