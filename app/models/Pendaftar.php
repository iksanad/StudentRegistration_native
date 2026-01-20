<?php
/**
 * =============================================================================
 * CLASS: Pendaftar
 * =============================================================================
 * Model untuk mengelola data pendaftar/calon siswa baru.
 * Kelas ini bertugas melakukan operasi CRUD terhadap tabel 'pendaftar' di database.
 * Ini adalah model utama yang menangani seluruh data pendaftaran siswa.
 * 
 * Tabel yang digunakan: pendaftar
 * =============================================================================
 */
class Pendaftar
{
    /**
     * @var mysqli Koneksi database
     */
    private $db;

    /**
     * -------------------------------------------------------------------------
     * Constructor / Konstruktor
     * -------------------------------------------------------------------------
     * Inisialisasi koneksi database saat objek Pendaftar dibuat.
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
     * Mengambil Semua Data Pendaftar
     * -------------------------------------------------------------------------
     * Fungsi ini mengambil seluruh data pendaftar dari database.
     * Data diurutkan berdasarkan tanggal daftar terbaru (descending).
     * 
     * @return mysqli_result Hasil query yang berisi semua data pendaftar
     */
    public function all()
    {
        $sql = "SELECT * FROM pendaftar ORDER BY tgl_daftar DESC";
        return $this->db->query($sql);
    }

    /**
     * -------------------------------------------------------------------------
     * Mencari Pendaftar Berdasarkan ID
     * -------------------------------------------------------------------------
     * Fungsi ini mencari data pendaftar berdasarkan primary key (id).
     * Digunakan untuk menampilkan detail atau mengedit data pendaftar tertentu.
     * 
     * @param int $id ID pendaftar yang akan dicari
     * @return array|null Data pendaftar dalam bentuk array asosiatif, atau null jika tidak ditemukan
     */
    public function find($id)
    {
        $sql = "SELECT * FROM pendaftar WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * -------------------------------------------------------------------------
     * Mencari Pendaftar Berdasarkan User ID
     * -------------------------------------------------------------------------
     * Fungsi ini mencari data pendaftaran berdasarkan ID user yang mendaftar.
     * Digunakan untuk menampilkan pendaftaran milik user yang sedang login.
     * 
     * @param int $userId ID user yang pendaftarannya akan dicari
     * @return array|null Data pendaftar dalam bentuk array asosiatif, atau null jika tidak ditemukan
     */
    public function findByUserId($userId)
    {
        $sql = "SELECT * FROM pendaftar WHERE user_id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * -------------------------------------------------------------------------
     * Menyimpan Data Pendaftar Baru (Insert)
     * -------------------------------------------------------------------------
     * Fungsi ini menyimpan data pendaftar baru ke database.
     * Semua field termasuk file upload (foto, akta, KK) disimpan.
     * 
     * @param array $data Array asosiatif berisi data pendaftar:
     *                    - user_id: ID user pemilik pendaftaran
     *                    - nama_lengkap: Nama lengkap pendaftar
     *                    - nisn: Nomor Induk Siswa Nasional
     *                    - jenis_kelamin: L (Laki-laki) atau P (Perempuan)
     *                    - tanggal_lahir: Tanggal lahir format YYYY-MM-DD
     *                    - alamat: Alamat lengkap
     *                    - asal_sekolah: Nama sekolah asal
     *                    - nama_ortu: Nama orang tua/wali
     *                    - no_hp: Nomor HP yang bisa dihubungi
     *                    - foto: Nama file foto
     *                    - dokumen_akta: Nama file akta kelahiran
     *                    - dokumen_kk: Nama file kartu keluarga
     * @return bool True jika berhasil, false jika gagal
     */
    public function insert($data)
    {
        $sql = "INSERT INTO pendaftar 
                (user_id, nama_lengkap, nisn, jenis_kelamin, tanggal_lahir, alamat, asal_sekolah, nama_ortu, no_hp, foto, dokumen_akta, dokumen_kk)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "isssssssssss",
            $data['user_id'],
            $data['nama_lengkap'],
            $data['nisn'],
            $data['jenis_kelamin'],
            $data['tanggal_lahir'],
            $data['alamat'],
            $data['asal_sekolah'],
            $data['nama_ortu'],
            $data['no_hp'],
            $data['foto'],
            $data['dokumen_akta'],
            $data['dokumen_kk']
        );

        return $stmt->execute();
    }

    /**
     * -------------------------------------------------------------------------
     * Memperbarui Data Pendaftar (Update)
     * -------------------------------------------------------------------------
     * Fungsi ini memperbarui data pendaftar yang sudah ada di database.
     * Semua field akan diupdate termasuk file upload jika ada perubahan.
     * 
     * @param int $id ID pendaftar yang akan diupdate
     * @param array $data Array asosiatif berisi data pendaftar yang akan diupdate
     *                    (struktur sama dengan method insert)
     * @return bool True jika berhasil, false jika gagal
     */
    public function update($id, $data)
    {
        $sql = "UPDATE pendaftar
                SET user_id = ?,
                    nama_lengkap = ?,
                    nisn = ?,
                    jenis_kelamin = ?,
                    tanggal_lahir = ?,
                    alamat = ?,
                    asal_sekolah = ?,
                    nama_ortu = ?,
                    no_hp = ?,
                    foto = ?,
                    dokumen_akta = ?,
                    dokumen_kk = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "isssssssssssi",
            $data['user_id'],
            $data['nama_lengkap'],
            $data['nisn'],
            $data['jenis_kelamin'],
            $data['tanggal_lahir'],
            $data['alamat'],
            $data['asal_sekolah'],
            $data['nama_ortu'],
            $data['no_hp'],
            $data['foto'],
            $data['dokumen_akta'],
            $data['dokumen_kk'],
            $id
        );

        return $stmt->execute();
    }

    /**
     * -------------------------------------------------------------------------
     * Menghapus Data Pendaftar (Delete)
     * -------------------------------------------------------------------------
     * Fungsi ini menghapus data pendaftar dari database berdasarkan ID.
     * PERHATIAN: Proses ini tidak dapat dibatalkan (irreversible).
     * 
     * @param int $id ID pendaftar yang akan dihapus
     * @return bool True jika berhasil, false jika gagal
     */
    public function delete($id)
    {
        $sql = "DELETE FROM pendaftar WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // =========================================================================
    // STATISTIK DASHBOARD
    // =========================================================================

    /**
     * -------------------------------------------------------------------------
     * Menghitung Total Semua Pendaftar
     * -------------------------------------------------------------------------
     * Fungsi ini menghitung jumlah total seluruh pendaftar di database.
     * Digunakan untuk menampilkan statistik di dashboard admin.
     * 
     * @return int Jumlah total pendaftar
     */
    public function countAll()
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM pendaftar");
        return $result->fetch_assoc()['total'];
    }

    /**
     * -------------------------------------------------------------------------
     * Menghitung Pendaftar Hari Ini
     * -------------------------------------------------------------------------
     * Fungsi ini menghitung jumlah pendaftar yang mendaftar pada hari ini.
     * Berguna untuk monitoring aktivitas pendaftaran harian.
     * 
     * @return int Jumlah pendaftar hari ini
     */
    public function countToday()
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM pendaftar WHERE DATE(tgl_daftar) = CURDATE()");
        return $result->fetch_assoc()['total'];
    }

    /**
     * -------------------------------------------------------------------------
     * Menghitung Pendaftar Berdasarkan Jenis Kelamin
     * -------------------------------------------------------------------------
     * Fungsi ini menghitung jumlah pendaftar berdasarkan jenis kelamin.
     * Digunakan untuk statistik demografi pendaftar.
     * 
     * @param string $gender Jenis kelamin: 'L' (Laki-laki) atau 'P' (Perempuan)
     * @return int Jumlah pendaftar dengan jenis kelamin tersebut
     */
    public function countByGender($gender)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM pendaftar WHERE jenis_kelamin = ?");
        $stmt->bind_param("s", $gender);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    /**
     * -------------------------------------------------------------------------
     * Mengambil Pendaftar Terbaru
     * -------------------------------------------------------------------------
     * Fungsi ini mengambil data pendaftar terbaru dengan jumlah tertentu.
     * Digunakan untuk menampilkan daftar pendaftar terkini di dashboard.
     * 
     * @param int $limit Jumlah maksimal data yang diambil (default: 5)
     * @return array Array berisi data pendaftar terbaru
     */
    public function getRecent($limit = 5)
    {
        $stmt = $this->db->prepare("SELECT * FROM pendaftar ORDER BY tgl_daftar DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
