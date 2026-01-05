<?php
class PendaftarController
{
    private $model;

    public function __construct()
    {
        // pastikan hanya user yang sudah login yang bisa mengakses
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }
        $this->model = new Pendaftar();
    }

    public function index()
    {
        $result = $this->model->all();
        $status = $_GET['status'] ?? null;
        include 'app/views/pendaftar/index.php';
    }

    public function create()
    {
        include 'app/views/pendaftar/create.php';
    }

    public function store()
    {
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

    public function edit()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $data = $this->model->find($id);
        if (!$data) {
            echo "Data tidak ditemukan.";
            return;
        }
        include 'app/views/pendaftar/edit.php';
    }

    public function update()
    {
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

    public function delete()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($this->model->delete($id)) {
            header("Location: index.php?action=index&status=hapus_sukses");
        } else {
            header("Location: index.php?action=index&status=hapus_gagal");
        }
        exit;
    }
}
