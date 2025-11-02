# Wong Sangar Team

Nama Project: **Tugas PWL Company Profile**

## Deskripsi Singkat

Membuat Website dengan penerapan MVC

---

## Teknologi / Requirement

* PHP 8.x
* Web server (Apache / Nginx) atau built-in PHP server (jika Apache gunakan XAMPP)
* MySQL / MariaDB (bisa menggunakan Php Mysql dari XAMPP)
* Git

---

## Struktur Project Detail

```
project-name/
├─ app/
│  ├─ Controllers/
│  │   ├─ LoginController.php
│  │   ├─ PegawaiController.php
|  |   └─ JabatanController.php
│  ├─ Models/
│  │   ├─ PegawaiModel.php
│  │   └─ JabatanModel.php
│  ├─ Views/
│  │   ├─ login.php
│  │   └─ dashboard.php
│  ├─ Core/
│  │   └─ Routes.php
├─ public/
│  ├─ index.php         # Front controller
│  ├─ assets/
│  │   ├─ css/
│  │   └─ js/
├─ config/
│  └─ database.php
├─ .gitignore
└─ README.md
```

> Catatan: `public/` berada sebagai document root web server. Direktori `app/` berisi kode MVC utama.

---

## Penjelasan tiap bagian

* **app/Core/Router.php** — Menangani mapping URL (contoh https://app/login, https://app/dashoad)
* **app/Controllers/** — Menangani request, validasi input, memanggil model, dan menyiapkan data untuk view.
* **app/Models/** — Representasi data dan logika akses data.
* **app/Views/** — Tampilan HTML/PHP; hanya presentasi (hindari logic bisnis berat di sini).
* **config/database.php** — Konfigurasi koneksi DB (gunakan .gitignore untukmelindungi data).

---

## Model / Controller / View — Contoh Daftar (sesuaikan dengan project)

### Models (contoh)

* `UserModel` — register, login, getById, update
* `ProductModel` — all, findById, create, update, delete
* `CategoryModel` — all, parent-child

### Controllers (contoh)

* `AuthController` — register(), login(), logout()
* `HomeController` — index()
* `ProductController` — index(), show($id), create(), store(), edit($id), update($id), destroy($id)
* `ApiController` — endpoint JSON (opsional)

### Views (contoh isi)

* `home.php` — tampilan landing
* `auth/login.php` — form login
* `auth/register.php` — form registrasi
* `products/index.php` — daftar produk (tabel / grid)
* `products/show.php` — detail produk
* `products/form.php` — partial form untuk create & edit
* `layouts/main.php` — header/footer/asset includes

---

## Contoh alur kerja MVC (singkat)

1. User buka `GET /products` → `public/index.php` meneruskan ke `Router`.
2. `Router` memanggil `ProductController::index()`.
3. `ProductController::index()` mengakses `ProductModel::all()`.
4. Data dikirim ke `View` `products/index.php`.
5. View dirender ke HTML yang dikirim ke browser.

---

## Setup & Cara pakai Git (langkah demi langkah)

### 1) Clone repository (download repo)

```bash
# ganti URL dengan repo tim
git clone https://github.com/<org-or-username>/<repo>.git
cd <repo>
```

### 2) Buat branch fitur (best practice: feature branch per tugas)

```bash
# nama branch: feature/<deskripsi-singkat>
git checkout -b feature/nama-fitur
```

### 3) Bekerja dan commit perubahan

```bash
git add .
git commit -m "feat: menambahkan halaman produk dan model dasar"
```

### 4) Push branch ke remote

```bash
git push origin feature/nama-fitur
```

### 5) Membuat Pull Request (PR)

* Buka GitHub → buat Pull Request dari `feature/nama-fitur` ke `main`/`develop`.
* Mintalah 1–2 reviewer.

### 6) Mengambil update dari remote (sync)

```bash
# ambil perubahan dari main
git checkout main
git pull origin main
# jika di branch fitur, rebase atau merge
git checkout feature/nama-fitur
git rebase main
# atau
git merge main
```

### 7) Contoh perintah penting lain

* `git status` — lihat status
* `git diff` — lihat perubahan
* `git log --oneline` — riwayat commit singkat
* `git stash` — simpan sementara perubahan lokal

## Contoh SQL

```
CREATE TABLE jabatan (
  id_jabatan INT(11) NOT NULL AUTO_INCREMENT,
  nama_jabatan VARCHAR(100) NOT NULL,
  PRIMARY KEY (id_jabatan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE pegawai (
  id_pegawai INT(11) NOT NULL AUTO_INCREMENT,
  nama_pegawai VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  password VARCHAR(16) NOT NULL,
  tgl_lahir DATE NOT NULL,
  id_jabatan INT(11) NOT NULL,
  foto VARCHAR(255) DEFAULT NULL,
  keterangan TEXT DEFAULT NULL,
  jenis_kelamin CHAR(1) NOT NULL,
  PRIMARY KEY (id_pegawai),
  CONSTRAINT fk_pegawai_jabatan FOREIGN KEY (id_jabatan)
    REFERENCES jabatan(id_jabatan)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

---

## Konvensi & Best Practices (singkat dan tegas)

* Nama file Controller: `PascalCaseController.php` (contoh: `ProductController.php`).
* Nama class model: `PascalCaseModel`.
* Hindari query SQL langsung di View.
* Validasi input di Controller / Service layer.
* Escape output pada View: gunakan `htmlspecialchars()`.
* Simpan credential sensitif di `database.php` (jangan push ke repo).

## Contributing (aturan singkat untuk tim)

1. Fork / clone repo.
2. Gunakan branch baru (`contoh: branch_model`) untuk setiap tugas.
3. Sertakan deskripsi jelas di setiap commit dan PR.
4. Review kode sebelum merge: cek security, SQL injection, XSS.

---

## Checklist sebelum merge PR

* [ ] Code lulus review
* [ ] Tidak ada secret di commit
* [ ] Manual test flow utama (create/edit/delete) OK
* [ ] DB migration (jika ada) ditambahkan

---

## Referensi struktur file contoh (snippet kecil `public/index.php`)

```php
<?php
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

$router = new Router();
$router->get('/', [HomeController::class, 'index']);
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
```

---

