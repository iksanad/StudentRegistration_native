<?php
class PendaftarController
{
    private $model;

    public function __construct()
    {
        // Wajib login dulu
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $this->model = new Pendaftar();
    }

    // Helper: cek harus admin
    private function ensureAdmin()
    {
        if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo "Anda tidak memiliki hak akses untuk aksi ini.";
            exit;
        }
    }

    // LIST: boleh untuk semua user yang login (admin maupun user)
    public function index()
    {
        $result = $this->model->all();
        $status = $_GET['status'] ?? null;
        include 'app/views/pendaftar/index.php';
    }

    // CREATE: hanya admin
    public function create()
    {
        $this->ensureAdmin();
        include 'app/views/pendaftar/create.php';
    }

    // STORE: hanya admin
    public function store()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_lengkap'  => $_POST['nama_lengkap'] ?? '',
                'nisn'          => $_POST['nisn'] ?? '',
                'jenis_kelamin' => $_POST['jenis_kelamin'] ?? '',
                'tanggal_lahir' => $_POST['tanggal_lahir'] ?? null,
                'alamat'        => $_POST['alamat'] ?? '',
                'asal_sekolah'  => $_POST['asal_sekolah'] ?? '',
                'nama_ortu'     => $_POST['nama_ortu'] ?? '',
                'no_hp'         => $_POST['no_hp'] ?? '',
            ];

            if ($this->model->insert($data)) {
                header("Location: index.php?action=index&status=sukses");
            } else {
                header("Location: index.php?action=index&status=gagal");
            }
            exit;
        }

        header("Location: index.php?action=create");
        exit;
    }

    // EDIT FORM: hanya admin
    public function edit()
    {
        $this->ensureAdmin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $data = $this->model->find($id);
        if (!$data) {
            echo "Data tidak ditemukan.";
            return;
        }
        include 'app/views/pendaftar/edit.php';
    }

    // UPDATE: hanya admin
    public function update()
    {
        $this->ensureAdmin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_lengkap'  => $_POST['nama_lengkap'] ?? '',
                'nisn'          => $_POST['nisn'] ?? '',
                'jenis_kelamin' => $_POST['jenis_kelamin'] ?? '',
                'tanggal_lahir' => $_POST['tanggal_lahir'] ?? null,
                'alamat'        => $_POST['alamat'] ?? '',
                'asal_sekolah'  => $_POST['asal_sekolah'] ?? '',
                'nama_ortu'     => $_POST['nama_ortu'] ?? '',
                'no_hp'         => $_POST['no_hp'] ?? '',
            ];

            if ($this->model->update($id, $data)) {
                header("Location: index.php?action=index&status=update_sukses");
            } else {
                header("Location: index.php?action=index&status=update_gagal");
            }
            exit;
        }

        header("Location: index.php?action=edit&id=" . $id);
        exit;
    }

    // DELETE: hanya admin
    public function delete()
    {
        $this->ensureAdmin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($this->model->delete($id)) {
            header("Location: index.php?action=index&status=hapus_sukses");
        } else {
            header("Location: index.php?action=index&status=hapus_gagal");
        }
        exit;
    }
}
