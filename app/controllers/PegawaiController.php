<?php
require_once __DIR__ . '/../Models/PegawaiModel.php';
require_once __DIR__ . '/../Models/JabatanModel.php';

class PegawaiController {
    private $pegawaiModel;
    private $jabatanModel;

    public function __construct() {
        $this->checkAuth();
        $this->pegawaiModel = new PegawaiModel();
        $this->jabatanModel = new JabatanModel();
    }

    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $foto = null;
            
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/assets/uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExt = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid() . '.' . $fileExt;
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                    $foto = 'assets/uploads/' . $fileName;
                }
            }

            $data = [
                'nama_pegawai' => $_POST['nama_pegawai'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'tgl_lahir' => $_POST['tgl_lahir'],
                'id_jabatan' => $_POST['id_jabatan'],
                'foto' => $foto,
                'keterangan' => $_POST['keterangan'] ?? '',
                'jenis_kelamin' => $_POST['jenis_kelamin']
            ];

            if ($this->pegawaiModel->create($data)) {
                $_SESSION['success'] = 'Data pegawai berhasil ditambahkan';
            } else {
                $_SESSION['error'] = 'Gagal menambahkan data pegawai';
            }

            header('Location: /dashboard');
            exit();
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pegawai = $this->pegawaiModel->getById($id);
            $foto = $pegawai['foto'];
            
            // Upload foto baru jika ada
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/assets/uploads/';
                
                $fileExt = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid() . '.' . $fileExt;
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                    // Hapus foto lama
                    if ($foto && file_exists(__DIR__ . '/../../public/' . $foto)) {
                        unlink(__DIR__ . '/../../public/' . $foto);
                    }
                    $foto = 'assets/uploads/' . $fileName;
                }
            }

            $data = [
                'nama_pegawai' => $_POST['nama_pegawai'],
                'email' => $_POST['email'],
                'tgl_lahir' => $_POST['tgl_lahir'],
                'id_jabatan' => $_POST['id_jabatan'],
                'foto' => $foto,
                'keterangan' => $_POST['keterangan'] ?? '',
                'jenis_kelamin' => $_POST['jenis_kelamin']
            ];

            if ($this->pegawaiModel->update($id, $data)) {
                $_SESSION['success'] = 'Data pegawai berhasil diupdate';
            } else {
                $_SESSION['error'] = 'Gagal mengupdate data pegawai';
            }

            header('Location: /dashboard');
            exit();
        }
    }

    public function delete($id) {
        $pegawai = $this->pegawaiModel->getById($id);
        
        if ($this->pegawaiModel->delete($id)) {
            // Hapus foto jika ada
            if ($pegawai['foto'] && file_exists(__DIR__ . '/../../public/' . $pegawai['foto'])) {
                unlink(__DIR__ . '/../../public/' . $pegawai['foto']);
            }
            $_SESSION['success'] = 'Data pegawai berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus data pegawai';
        }

        header('Location: /dashboard');
        exit();
    }

    public function getJson($id = null) {
        header('Content-Type: application/json');
        
        if ($id) {
            $data = $this->pegawaiModel->getById($id);
        } else {
            $data = $this->pegawaiModel->getAll();
        }
        
        echo json_encode($data);
        exit();
    }
}
?>