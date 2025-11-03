<?php
require_once __DIR__ . '/../../config/database.php';

class JabatanModel {
    private $conn;
    private $table = "jabatan";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nama_jabatan ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_jabatan = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nama_jabatan) VALUES (:nama_jabatan)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_jabatan', $data['nama_jabatan']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET nama_jabatan = :nama_jabatan WHERE id_jabatan = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_jabatan', $data['nama_jabatan']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_jabatan = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>