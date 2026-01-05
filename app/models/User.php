<?php
class User
{
    private $db;

    public function __construct()
    {
        global $koneksi;
        $this->db = $koneksi;
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($username, $password, $role = 'admin')
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password_hash, role) VALUES (?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $username, $hash, $role);
        return $stmt->execute();
    }
}
