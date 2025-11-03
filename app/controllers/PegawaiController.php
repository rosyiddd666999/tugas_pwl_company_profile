<?php
use \Core\Model;

class PegawaiController
{
    /** @var Pegawai */
    protected $model;

    /** @var Jabatan */
    protected $jabatanModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new Pegawai();
        $this->jabatanModel = new Jabatan(); // untuk relasi jabatan
    }

    // ---------------------------
    // TAMPILKAN SEMUA PEGAWAI
    // ---------------------------
    public function index()
    {
        $data = $this->model->getAll();
        $view = __DIR__ . '/../views/pegawai/index.php';
        if (file_exists($view)) {
            $pegawai = $data;
            require_once $view;
            return;
        }
        $_SESSION['pegawai_list'] = $data;
        header('Location: /');
        exit;
    }

    // ---------------------------
    // FORM TAMBAH PEGAWAI
    // ---------------------------
    public function create()
    {
        $jabatan = $this->jabatanModel->getAll();
        $view = __DIR__ . '/../views/pegawai/create.php';
        if (file_exists($view)) {
            require_once $view;
            return;
        }
        header('Location: /pegawai');
        exit;
    }

    // ---------------------------
    // SIMPAN DATA PEGAWAI BARU
    // ---------------------------
    public function store()
    {
        $nama = trim($_POST['nama_pegawai'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $tgl_lahir = trim($_POST['tgl_lahir'] ?? '');
        $id_jabatan = intval($_POST['id_jabatan'] ?? 0);
        $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        // Validasi dasar
        if ($nama === '' || $email === '' || $password === '' || $tgl_lahir === '' || $id_jabatan === 0 || $jenis_kelamin === '') {
            $_SESSION['error'] = 'Semua field wajib diisi.';
            header('Location: /pegawai/create');
            exit;
        }

        // Upload foto (opsional)
        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            $targetDir = __DIR__ . '/../../public/uploads/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $filename = time() . '_' . basename($_FILES['foto']['name']);
            $targetFile = $targetDir . $filename;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                $foto = $filename;
            }
        }

        // Simpan data ke database
        $ok = $this->model->insertData([
            'nama_pegawai' => $nama,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'tgl_lahir' => $tgl_lahir,
            'id_jabatan' => $id_jabatan,
            'foto' => $foto,
            'keterangan' => $keterangan,
            'jenis_kelamin' => $jenis_kelamin
        ]);

        $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Berhasil menambahkan pegawai.' : 'Gagal menambahkan pegawai.';
        header('Location: /pegawai');
        exit;
    }

    // ---------------------------
    // FORM EDIT PEGAWAI
    // ---------------------------
    public function edit($id)
    {
        $row = $this->model->getById($id);
        $jabatan = $this->jabatanModel->getAll();

        $view = __DIR__ . '/../views/pegawai/edit.php';
        if (file_exists($view)) {
            $pegawai = $row;
            require_once $view;
            return;
        }
        $_SESSION['pegawai_edit'] = $row;
        header('Location: /pegawai');
        exit;
    }

    // ---------------------------
    // UPDATE DATA PEGAWAI
    // ---------------------------
    public function update($id)
    {
        $nama = trim($_POST['nama_pegawai'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $tgl_lahir = trim($_POST['tgl_lahir'] ?? '');
        $id_jabatan = intval($_POST['id_jabatan'] ?? 0);
        $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        if ($nama === '' || $email === '' || $tgl_lahir === '' || $id_jabatan === 0 || $jenis_kelamin === '') {
            $_SESSION['error'] = 'Semua field wajib diisi.';
            header("Location: /pegawai/edit/{$id}");
            exit;
        }

        // Upload foto baru (opsional)
        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            $targetDir = __DIR__ . '/../../public/uploads/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $filename = time() . '_' . basename($_FILES['foto']['name']);
            $targetFile = $targetDir . $filename;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                $foto = $filename;
            }
        }

        // Data untuk update
        $updateData = [
            'nama_pegawai' => $nama,
            'email' => $email,
            'tgl_lahir' => $tgl_lahir,
            'id_jabatan' => $id_jabatan,
            'keterangan' => $keterangan,
            'jenis_kelamin' => $jenis_kelamin
        ];

        if ($foto) {
            $updateData['foto'] = $foto;
        }
        if ($password !== '') {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $ok = $this->model->updateData($updateData, $id);

        $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Berhasil mengubah pegawai.' : 'Gagal mengubah pegawai.';
        header('Location: /pegawai');
        exit;
    }

    // ---------------------------
    // HAPUS PEGAWAI
    // ---------------------------
    public function delete($id)
    {
        $ok = $this->model->deleteData($id);

        $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Berhasil menghapus pegawai.' : 'Gagal menghapus pegawai.';
        header('Location: /pegawai');
        exit;
    }
}
?>
