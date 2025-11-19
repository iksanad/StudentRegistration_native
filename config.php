<?php
$host     = "localhost";
$user     = "root";
$password = "";
$dbname   = "student_registration";
$port     = 3322;

$koneksi = new mysqli($host, $user, $password, $dbname, $port);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
