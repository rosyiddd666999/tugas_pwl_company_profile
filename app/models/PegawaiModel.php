<?php
require_once __DIR__ . '/../../config/database.php';

class PegawaiModel {
    private $conn;
    private $table = "pegawai";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT p.*, j.nama_jabatan 
                  FROM " . $this->table . " p 
                  LEFT JOIN jabatan j ON p.id_jabatan = j.id_jabatan 
                  ORDER BY p.nama_pegawai ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT p.*, j.nama_jabatan 
                  FROM " . $this->table . " p 
                  LEFT JOIN jabatan j ON p.id_jabatan = j.id_jabatan 
                  WHERE p.id_pegawai = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (nama_pegawai, email, password, tgl_lahir, id_jabatan, foto, keterangan, jenis_kelamin) 
                  VALUES (:nama_pegawai, :email, :password, :tgl_lahir, :id_jabatan, :foto, :keterangan, :jenis_kelamin)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_pegawai', $data['nama_pegawai']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':tgl_lahir', $data['tgl_lahir']);
        $stmt->bindParam(':id_jabatan', $data['id_jabatan']);
        $stmt->bindParam(':foto', $data['foto']);
        $stmt->bindParam(':keterangan', $data['keterangan']);
        $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_pegawai = :nama_pegawai, 
                      email = :email, 
                      tgl_lahir = :tgl_lahir, 
                      id_jabatan = :id_jabatan, 
                      foto = :foto, 
                      keterangan = :keterangan, 
                      jenis_kelamin = :jenis_kelamin 
                  WHERE id_pegawai = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_pegawai', $data['nama_pegawai']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':tgl_lahir', $data['tgl_lahir']);
        $stmt->bindParam(':id_jabatan', $data['id_jabatan']);
        $stmt->bindParam(':foto', $data['foto']);
        $stmt->bindParam(':keterangan', $data['keterangan']);
        $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function updatePassword($id, $password) {
        $query = "UPDATE " . $this->table . " SET password = :password WHERE id_pegawai = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_pegawai = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getStatistik() {
        $query = "SELECT 
                    COUNT(*) as total_pegawai,
                    COUNT(CASE WHEN jenis_kelamin = 'L' THEN 1 END) as total_laki,
                    COUNT(CASE WHEN jenis_kelamin = 'P' THEN 1 END) as total_perempuan
                  FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByJabatan() {
        $query = "SELECT j.nama_jabatan, COUNT(p.id_pegawai) as jumlah
                  FROM jabatan j
                  LEFT JOIN " . $this->table . " p ON j.id_jabatan = p.id_jabatan
                  GROUP BY j.id_jabatan, j.nama_jabatan
                  ORDER BY jumlah DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecent($limit = 5) {
        $query = "SELECT p.*, j.nama_jabatan 
                  FROM " . $this->table . " p 
                  LEFT JOIN jabatan j ON p.id_jabatan = j.id_jabatan 
                  ORDER BY p.id_pegawai DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>