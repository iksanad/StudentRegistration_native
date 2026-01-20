<?php
/**
 * =============================================================================
 * CLASS: User
 * =============================================================================
 * Model untuk mengelola data user (pengguna biasa/non-admin).
 * Kelas ini bertugas melakukan operasi CRUD terhadap tabel 'users' di database.
 * 
 * Tabel yang digunakan: users
 * =============================================================================
 */
class User
{
    /**
     * @var mysqli Koneksi database
     */
    private $db;

    /**
     * -------------------------------------------------------------------------
     * Constructor / Konstruktor
     * -------------------------------------------------------------------------
     * Inisialisasi koneksi database saat objek User dibuat.
     * Mengambil koneksi dari variabel global $koneksi yang didefinisikan di config.php.
     * 
     * @return void
     */
    public function __construct()
    {
        global $koneksi;
        $this->db = $koneksi;
    }

    /**
     * -------------------------------------------------------------------------
     * Mencari User Berdasarkan Username
     * -------------------------------------------------------------------------
     * Fungsi ini mencari data user di database berdasarkan username.
     * Digunakan saat proses login untuk memverifikasi kredensial pengguna.
     * 
     * @param string $username Username yang akan dicari
     * @return array|null Data user dalam bentuk array asosiatif, atau null jika tidak ditemukan
     */
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * -------------------------------------------------------------------------
     * Membuat User Baru (Registrasi)
     * -------------------------------------------------------------------------
     * Fungsi ini membuat akun user baru di database.
     * Password akan di-hash menggunakan password_hash() untuk keamanan.
     * 
     * @param string $username Username untuk user baru
     * @param string $password Password dalam bentuk plain text (akan di-hash)
     * @param string|null $namaLengkap Nama lengkap user (opsional)
     * @return bool True jika berhasil, false jika gagal
     */
    public function create($username, $password, $namaLengkap = null)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password_hash, nama_lengkap) VALUES (?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $username, $hash, $namaLengkap);
        return $stmt->execute();
    }

    /**
     * -------------------------------------------------------------------------
     * Mencari User Berdasarkan ID
     * -------------------------------------------------------------------------
     * Fungsi ini mencari data user berdasarkan primary key (id).
     * Berguna untuk mengambil detail user yang sedang login.
     * 
     * @param int $id ID user yang akan dicari
     * @return array|null Data user dalam bentuk array asosiatif, atau null jika tidak ditemukan
     */
    public function find($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * -------------------------------------------------------------------------
     * Mengambil Semua Data User
     * -------------------------------------------------------------------------
     * Fungsi ini mengambil seluruh data user dari database.
     * Digunakan untuk menampilkan dropdown pilihan user saat
     * menghubungkan pendaftar dengan akun user.
     * Data diurutkan berdasarkan nama lengkap secara ascending.
     * 
     * @return array Array berisi semua data user (id, username, nama_lengkap)
     */
    public function getAll()
    {
        $sql = "SELECT id, username, nama_lengkap FROM users ORDER BY nama_lengkap ASC";
        $result = $this->db->query($sql);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }
}
