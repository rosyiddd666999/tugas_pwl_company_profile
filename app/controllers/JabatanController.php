<?php
require_once __DIR__ . '/../Models/JabatanModel.php';
require_once __DIR__ . '/../../config/database.php';

class JabatanController {
    private $jabatanModel;

    public function __construct() {
        $this->checkAuth();
        $this->jabatanModel = new JabatanModel();
    }

    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public function index() {
        $query = "SELECT j.*, COUNT(p.id_pegawai) as jumlah_pegawai 
                  FROM jabatan j 
                  LEFT JOIN pegawai p ON j.id_jabatan = p.id_jabatan 
                  GROUP BY j.id_jabatan 
                  ORDER BY j.nama_jabatan ASC";
        
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $jabatan = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . '/../Views/jabatan.php';
    }

    public function getJson($id = null) {
        header('Content-Type: application/json');
        
        if ($id) {
            $data = $this->jabatanModel->getById($id);
        } else {
            $data = $this->jabatanModel->getAll();
        }
        
        echo json_encode($data);
        exit();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_jabatan' => $_POST['nama_jabatan']
            ];

            if ($this->jabatanModel->create($data)) {
                $_SESSION['success'] = 'Data jabatan berhasil ditambahkan';
            } else {
                $_SESSION['error'] = 'Gagal menambahkan data jabatan';
            }

            header('Location: /jabatan');
            exit();
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_jabatan' => $_POST['nama_jabatan']
            ];

            if ($this->jabatanModel->update($id, $data)) {
                $_SESSION['success'] = 'Data jabatan berhasil diupdate';
            } else {
                $_SESSION['error'] = 'Gagal mengupdate data jabatan';
            }

            header('Location: /jabatan');
            exit();
        }
    }

    public function delete($id) {
        try {
            if ($this->jabatanModel->delete($id)) {
                $_SESSION['success'] = 'Data jabatan berhasil dihapus';
            } else {
                $_SESSION['error'] = 'Gagal menghapus data jabatan';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Tidak dapat menghapus jabatan yang masih digunakan pegawai';
        }

        header('Location: /jabatan');
        exit();
    }
}
?>