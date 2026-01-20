<?php
/**
 * =============================================================================
 * CLASS: Admin
 * =============================================================================
 * Model untuk mengelola data administrator.
 * Kelas ini bertugas melakukan operasi CRUD terhadap tabel 'admins' di database.
 * Admin memiliki hak akses khusus untuk mengelola seluruh data pendaftaran.
 * 
 * Tabel yang digunakan: admins
 * =============================================================================
 */
class Admin
{
    /**
     * @var mysqli Koneksi database
     */
    private $db;

    /**
     * -------------------------------------------------------------------------
     * Constructor / Konstruktor
     * -------------------------------------------------------------------------
     * Inisialisasi koneksi database saat objek Admin dibuat.
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
     * Mencari Admin Berdasarkan Username
     * -------------------------------------------------------------------------
     * Fungsi ini mencari data admin di database berdasarkan username.
     * Digunakan saat proses login untuk memverifikasi kredensial administrator.
     * 
     * @param string $username Username admin yang akan dicari
     * @return array|null Data admin dalam bentuk array asosiatif, atau null jika tidak ditemukan
     */
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * -------------------------------------------------------------------------
     * Membuat Admin Baru (Registrasi Admin)
     * -------------------------------------------------------------------------
     * Fungsi ini membuat akun admin baru di database.
     * Password akan di-hash menggunakan password_hash() untuk keamanan.
     * 
     * @param string $username Username untuk admin baru
     * @param string $password Password dalam bentuk plain text (akan di-hash)
     * @param string|null $namaLengkap Nama lengkap admin (opsional)
     * @return bool True jika berhasil, false jika gagal
     */
    public function create($username, $password, $namaLengkap = null)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO admins (username, password_hash, nama_lengkap) VALUES (?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $username, $hash, $namaLengkap);
        return $stmt->execute();
    }
}
