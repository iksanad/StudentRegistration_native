<?php
/**
 * =============================================================================
 * CLASS: PendaftarController
 * =============================================================================
 * Controller utama untuk mengelola data pendaftar/calon siswa.
 * Kelas ini menangani semua operasi CRUD untuk pendaftaran serta
 * menampilkan dashboard untuk admin dan user.
 * 
 * Fitur utama:
 * - Dashboard admin dengan statistik pendaftar
 * - Dashboard user untuk melihat status pendaftaran
 * - CRUD operasi untuk data pendaftar (khusus admin)
 * - Upload dan manajemen file dokumen
 * 
 * Akses kontrol:
 * - Semua method memerlukan login
 * - Method create, store, edit, update, delete hanya untuk admin
 * =============================================================================
 */
class PendaftarController
{
    /**
     * @var Pendaftar Model untuk mengakses data pendaftar
     */
    private $model;

    /**
     * -------------------------------------------------------------------------
     * Constructor / Konstruktor
     * -------------------------------------------------------------------------
     * Inisialisasi controller dengan pengecekan session login.
     * Jika user belum login, akan langsung diarahkan ke halaman login.
     * Setelah verifikasi, model Pendaftar diinisialisasi.
     * 
     * @return void
     */
    public function __construct()
    {
        // Wajib login dulu
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $this->model = new Pendaftar();
    }

    /**
     * -------------------------------------------------------------------------
     * Helper: Memastikan User adalah Admin
     * -------------------------------------------------------------------------
     * Fungsi helper untuk memverifikasi bahwa user yang sedang login
     * memiliki role admin. Jika bukan admin, akan menampilkan error 403.
     * 
     * @return void Menghentikan eksekusi jika bukan admin
     */
    private function ensureAdmin()
    {
        if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo "Anda tidak memiliki hak akses untuk aksi ini.";
            exit;
        }
    }

    /**
     * -------------------------------------------------------------------------
     * Helper: Upload File dengan Validasi
     * -------------------------------------------------------------------------
     * Fungsi helper untuk menangani upload file dengan validasi:
     * - Tipe file yang diizinkan
     * - Ukuran maksimal file
     * - Generate nama file unik untuk mencegah konflik
     * 
     * @param array $file Array $_FILES dari form upload
     * @param string $folder Nama subfolder di dalam 'uploads/' (contoh: 'foto', 'dokumen')
     * @param array $allowedTypes Array ekstensi file yang diizinkan (contoh: ['jpg', 'png'])
     * @param int $maxSize Ukuran maksimal file dalam bytes (default: 2MB = 2097152)
     * @return string|null|false 
     *         - String nama file baru jika berhasil
     *         - null jika tidak ada file yang diupload
     *         - false jika validasi gagal
     */
    private function uploadFile($file, $folder, $allowedTypes, $maxSize = 2097152)
    {
        if (empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Validasi tipe file
        $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileType, $allowedTypes)) {
            return false; // Invalid type
        }

        // Validasi ukuran (default 2MB)
        if ($file['size'] > $maxSize) {
            return false; // Too large
        }

        // Generate unique filename
        $newFilename = uniqid() . '_' . time() . '.' . $fileType;
        $targetPath = "uploads/{$folder}/{$newFilename}";

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $newFilename;
        }

        return false;
    }

    /**
     * -------------------------------------------------------------------------
     * Dashboard Admin
     * -------------------------------------------------------------------------
     * Menampilkan halaman dashboard untuk administrator.
     * Halaman ini menampilkan statistik:
     * - Total pendaftar
     * - Pendaftar hari ini
     * - Jumlah pendaftar laki-laki dan perempuan
     * - Daftar 5 pendaftar terbaru
     * 
     * AKSES: Hanya Admin
     * 
     * @return void Menampilkan view dashboard admin
     */
    public function dashboard()
    {
        $this->ensureAdmin();

        $totalPendaftar = $this->model->countAll();
        $todayPendaftar = $this->model->countToday();
        $malePendaftar = $this->model->countByGender('L');
        $femalePendaftar = $this->model->countByGender('P');
        $recentPendaftar = $this->model->getRecent(5);

        include 'app/views/admin/dashboard.php';
    }

    /**
     * -------------------------------------------------------------------------
     * Dashboard User
     * -------------------------------------------------------------------------
     * Menampilkan halaman dashboard untuk user biasa.
     * User dapat melihat status pendaftaran miliknya sendiri.
     * 
     * AKSES: Semua user yang login
     * 
     * @return void Menampilkan view dashboard user
     */
    public function userDashboard()
    {
        $myRegistration = $this->model->findByUserId($_SESSION['user_id']);
        include 'app/views/user/dashboard.php';
    }

    /**
     * -------------------------------------------------------------------------
     * Halaman Detail Pendaftaran Saya
     * -------------------------------------------------------------------------
     * Menampilkan detail lengkap pendaftaran milik user yang sedang login.
     * 
     * AKSES: Semua user yang login
     * 
     * @return void Menampilkan view detail pendaftaran user
     */
    public function myRegistration()
    {
        $myRegistration = $this->model->findByUserId($_SESSION['user_id']);
        include 'app/views/user/my_registration.php';
    }

    /**
     * -------------------------------------------------------------------------
     * Daftar Semua Pendaftar (Index)
     * -------------------------------------------------------------------------
     * Menampilkan daftar seluruh pendaftar dalam bentuk tabel.
     * Juga menampilkan pesan status operasi (sukses/gagal) jika ada.
     * 
     * AKSES: Semua user yang login (admin dan user biasa)
     * 
     * @return void Menampilkan view daftar pendaftar
     */
    public function index()
    {
        $result = $this->model->all();
        $status = $_GET['status'] ?? null;
        include 'app/views/pendaftar/index.php';
    }

    /**
     * -------------------------------------------------------------------------
     * Form Tambah Pendaftar Baru (Create)
     * -------------------------------------------------------------------------
     * Menampilkan form untuk menambahkan data pendaftar baru.
     * 
     * AKSES: Hanya Admin
     * 
     * @return void Menampilkan view form create
     */
    public function create()
    {
        $this->ensureAdmin();
        include 'app/views/pendaftar/create.php';
    }

    /**
     * -------------------------------------------------------------------------
     * Proses Simpan Pendaftar Baru (Store)
     * -------------------------------------------------------------------------
     * Memproses data form pendaftaran yang dikirim via POST.
     * Fungsi ini akan:
     * 1. Upload file foto, akta kelahiran, dan kartu keluarga
     * 2. Menyimpan data pendaftar ke database
     * 3. Redirect dengan pesan status (sukses/gagal)
     * 
     * AKSES: Hanya Admin
     * 
     * @return void Redirect ke halaman daftar pendaftar
     */
    public function store()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Upload files
            $foto = $this->uploadFile($_FILES['foto'] ?? [], 'foto', ['jpg', 'jpeg', 'png']);
            $dokumenAkta = $this->uploadFile($_FILES['dokumen_akta'] ?? [], 'dokumen', ['jpg', 'jpeg', 'png', 'pdf']);
            $dokumenKk = $this->uploadFile($_FILES['dokumen_kk'] ?? [], 'dokumen', ['jpg', 'jpeg', 'png', 'pdf']);

            $data = [
                'user_id'       => !empty($_POST['user_id']) ? (int)$_POST['user_id'] : null,
                'nama_lengkap'  => $_POST['nama_lengkap'] ?? '',
                'nisn'          => $_POST['nisn'] ?? '',
                'jenis_kelamin' => $_POST['jenis_kelamin'] ?? '',
                'tanggal_lahir' => $_POST['tanggal_lahir'] ?? null,
                'alamat'        => $_POST['alamat'] ?? '',
                'asal_sekolah'  => $_POST['asal_sekolah'] ?? '',
                'nama_ortu'     => $_POST['nama_ortu'] ?? '',
                'no_hp'         => $_POST['no_hp'] ?? '',
                'foto'          => $foto ?: null,
                'dokumen_akta'  => $dokumenAkta ?: null,
                'dokumen_kk'    => $dokumenKk ?: null,
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

    /**
     * -------------------------------------------------------------------------
     * Form Edit Pendaftar (Edit)
     * -------------------------------------------------------------------------
     * Menampilkan form untuk mengedit data pendaftar yang sudah ada.
     * ID pendaftar diambil dari parameter GET.
     * 
     * AKSES: Hanya Admin
     * 
     * @return void Menampilkan view form edit atau pesan error
     */
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

    /**
     * -------------------------------------------------------------------------
     * Proses Update Pendaftar (Update)
     * -------------------------------------------------------------------------
     * Memproses data form edit yang dikirim via POST.
     * Fungsi ini akan:
     * 1. Upload file baru jika ada (jika tidak, pertahankan file lama)
     * 2. Update data pendaftar di database
     * 3. Redirect dengan pesan status (sukses/gagal)
     * 
     * AKSES: Hanya Admin
     * 
     * @return void Redirect ke halaman daftar pendaftar
     */
    public function update()
    {
        $this->ensureAdmin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $existing = $this->model->find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Upload new files (keep old if not uploaded)
            $foto = $this->uploadFile($_FILES['foto'] ?? [], 'foto', ['jpg', 'jpeg', 'png']);
            $dokumenAkta = $this->uploadFile($_FILES['dokumen_akta'] ?? [], 'dokumen', ['jpg', 'jpeg', 'png', 'pdf']);
            $dokumenKk = $this->uploadFile($_FILES['dokumen_kk'] ?? [], 'dokumen', ['jpg', 'jpeg', 'png', 'pdf']);

            $data = [
                'user_id'       => !empty($_POST['user_id']) ? (int)$_POST['user_id'] : ($existing['user_id'] ?? null),
                'nama_lengkap'  => $_POST['nama_lengkap'] ?? '',
                'nisn'          => $_POST['nisn'] ?? '',
                'jenis_kelamin' => $_POST['jenis_kelamin'] ?? '',
                'tanggal_lahir' => $_POST['tanggal_lahir'] ?? null,
                'alamat'        => $_POST['alamat'] ?? '',
                'asal_sekolah'  => $_POST['asal_sekolah'] ?? '',
                'nama_ortu'     => $_POST['nama_ortu'] ?? '',
                'no_hp'         => $_POST['no_hp'] ?? '',
                'foto'          => $foto ?: ($existing['foto'] ?? null),
                'dokumen_akta'  => $dokumenAkta ?: ($existing['dokumen_akta'] ?? null),
                'dokumen_kk'    => $dokumenKk ?: ($existing['dokumen_kk'] ?? null),
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

    /**
     * -------------------------------------------------------------------------
     * Proses Hapus Pendaftar (Delete)
     * -------------------------------------------------------------------------
     * Menghapus data pendaftar dari database berdasarkan ID.
     * Fungsi ini juga akan menghapus file-file terkait (foto, akta, KK)
     * dari folder uploads untuk menghemat ruang penyimpanan.
     * 
     * PERHATIAN: Proses ini tidak dapat dibatalkan!
     * 
     * AKSES: Hanya Admin
     * 
     * @return void Redirect ke halaman daftar pendaftar
     */
    public function delete()
    {
        $this->ensureAdmin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        
        // Delete associated files
        $existing = $this->model->find($id);
        if ($existing) {
            if (!empty($existing['foto'])) {
                @unlink("uploads/foto/" . $existing['foto']);
            }
            if (!empty($existing['dokumen_akta'])) {
                @unlink("uploads/dokumen/" . $existing['dokumen_akta']);
            }
            if (!empty($existing['dokumen_kk'])) {
                @unlink("uploads/dokumen/" . $existing['dokumen_kk']);
            }
        }

        if ($this->model->delete($id)) {
            header("Location: index.php?action=index&status=hapus_sukses");
        } else {
            header("Location: index.php?action=index&status=hapus_gagal");
        }
        exit;
    }
}
