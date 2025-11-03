<?php
require_once __DIR__ . '/../Models/PegawaiModel.php';

class LoginController {
    private $pegawaiModel;

    public function __construct() {
        $this->pegawaiModel = new PegawaiModel();
    }

    public function index() {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit();
        }
        
        require_once __DIR__ . '/../Views/login.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['error'] = 'Email dan password harus diisi';
            header('Location: /login');
            exit();
        }

        $user = $this->pegawaiModel->getByEmail($email);

        if ($user && $user['password'] === $password) {
            $_SESSION['user_id'] = $user['id_pegawai'];
            $_SESSION['user_name'] = $user['nama_pegawai'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_foto'] = $user['foto'];
            
            header('Location: /dashboard');
            exit();
        } else {
            $_SESSION['error'] = 'Email atau password salah';
            header('Location: /login');
            exit();
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit();
    }
}
?>