<?php
use \Core\Model;
class JabatanController
{
    /** @var Jabatan */
    protected $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new Jabatan();
    }
    public function index()
    {
        $data = $this->model->getAll();
        $view = __DIR__ . '/../views/jabatan/index.php';
        if (file_exists($view)) {
            $jabatan = $data; 
            require_once $view;
            return;
        }
        $_SESSION['jabatan_list'] = $data;
        header('Location: /');
        exit;
    }
    public function create()
    {
        $view = __DIR__ . '/../views/jabatan/create.php';
        if (file_exists($view)) {
            require_once $view;
            return;
        }
        header('Location: /jabatan');
        exit;
    }
    public function store()
    {
        $nama = isset($_POST['nama_jabatan']) ? trim($_POST['nama_jabatan']) : '';

        if ($nama === '') {
            $_SESSION['error'] = 'Nama jabatan harus diisi.';
            header('Location: /jabatan/create');
            exit;
        }

        $ok = $this->model->insertData(['nama_jabatan' => $nama]);

        if ($ok) {
            $_SESSION['success'] = 'Berhasil menambahkan jabatan.';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan jabatan.';
        }

        header('Location: /jabatan');
        exit;
    }
    public function edit($id)
    {
        $row = $this->model->getById($id);

        $view = __DIR__ . '/../views/jabatan/edit.php';
        if (file_exists($view)) {
            $jabatan = $row; 
            require_once $view;
            return;
        }
        $_SESSION['jabatan_edit'] = $row;
        header('Location: /jabatan');
        exit;
    }
    public function update($id)
    {
        $nama = isset($_POST['nama_jabatan']) ? trim($_POST['nama_jabatan']) : '';

        if ($nama === '') {
            $_SESSION['error'] = 'Nama jabatan harus diisi.';
            header("Location: /jabatan/edit/{$id}");
            exit;
        }

        $ok = $this->model->updateData(['nama_jabatan' => $nama], $id);

        if ($ok) {
            $_SESSION['success'] = 'Berhasil mengubah jabatan.';
        } else {
            $_SESSION['error'] = 'Gagal mengubah jabatan.';
        }

        header('Location: /jabatan');
        exit;
    }
    public function delete($id)
    {
        $ok = $this->model->deleteData($id);

        if ($ok) {
            $_SESSION['success'] = 'Berhasil menghapus jabatan.';
        } else {
            $_SESSION['error'] = 'Gagal menghapus jabatan.';
        }

        header('Location: /jabatan');
        exit;
    }
}
?>