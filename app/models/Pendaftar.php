<?php
class Pendaftar
{
    private $db;

    public function __construct()
    {
        global $koneksi;
        $this->db = $koneksi;
    }

    public function all()
    {
        $sql = "SELECT * FROM pendaftar ORDER BY tgl_daftar DESC";
        return $this->db->query($sql);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM pendaftar WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO pendaftar 
                (nama_lengkap, nisn, jenis_kelamin, tanggal_lahir, alamat, asal_sekolah, nama_ortu, no_hp)
                VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "ssssssss",
            $data['nama_lengkap'],
            $data['nisn'],
            $data['jenis_kelamin'],
            $data['tanggal_lahir'],
            $data['alamat'],
            $data['asal_sekolah'],
            $data['nama_ortu'],
            $data['no_hp']
        );

        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE pendaftar
                SET nama_lengkap = ?,
                    nisn = ?,
                    jenis_kelamin = ?,
                    tanggal_lahir = ?,
                    alamat = ?,
                    asal_sekolah = ?,
                    nama_ortu = ?,
                    no_hp = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param(
            "ssssssssi",
            $data['nama_lengkap'],
            $data['nisn'],
            $data['jenis_kelamin'],
            $data['tanggal_lahir'],
            $data['alamat'],
            $data['asal_sekolah'],
            $data['nama_ortu'],
            $data['no_hp'],
            $id
        );

        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM pendaftar WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
