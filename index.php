<?php
session_start();

require 'config.php';
require 'app/models/Pendaftar.php';
require 'app/models/User.php';
require 'app/controllers/PendaftarController.php';
require 'app/controllers/AuthController.php';

$action = $_GET['action'] ?? 'index';

switch ($action) {
    // Auth routes
    case 'login':
        (new AuthController())->login();
        break;
    case 'doLogin':
        (new AuthController())->doLogin();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    case 'register':
        (new AuthController())->register();
        break;
    case 'storeRegister':
        (new AuthController())->storeRegister();
        break;

    // Pendaftar (protected)
    case 'index':
        (new PendaftarController())->index();
        break;
    case 'create':
        (new PendaftarController())->create();
        break;
    case 'store':
        (new PendaftarController())->store();
        break;
    case 'edit':
        (new PendaftarController())->edit();
        break;
    case 'update':
        (new PendaftarController())->update();
        break;
    case 'delete':
        (new PendaftarController())->delete();
        break;

    default:
        echo "Halaman tidak ditemukan.";
        break;
}
