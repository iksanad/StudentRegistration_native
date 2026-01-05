<?php
require 'config.php';
require 'app/models/Pendaftar.php';
require 'app/controllers/PendaftarController.php';

$controller = new PendaftarController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        echo "Halaman tidak ditemukan.";
        break;
}
