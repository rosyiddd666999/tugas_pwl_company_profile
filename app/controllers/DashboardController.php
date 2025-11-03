<?php
require_once __DIR__ . '/../Models/PegawaiModel.php';
require_once __DIR__ . '/../Models/JabatanModel.php';

class DashboardController {
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

    public function index() {
        $statistik = $this->pegawaiModel->getStatistik();
        $byJabatan = $this->pegawaiModel->getByJabatan();
        $totalJabatan = count($this->jabatanModel->getAll());
        $recentPegawai = $this->pegawaiModel->getRecent(5);
        
        require_once __DIR__ . '/../views/dashboard.php';
    }
}
?>