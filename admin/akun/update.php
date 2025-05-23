<?php
include('../../config/controller.php');


session_start();
if ($_SESSION['level'] !== '1') {
    header("Location: ../../unauthorized.php");
    exit;
}


if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    // Gunakan tampilkanDataAkun langsung untuk query spesifik
    $query = "SELECT * FROM login WHERE id = $id";
    $result = tampilkanDataAkun($query);
    // Cek apakah data ditemukan
    if (!empty($result)) {
        $user = $result[0];
    } else {
        // Redirect jika data tidak ditemukan
        echo "<script>
            alert('Data tidak ditemukan!');
            document.location.href='list.php';
        </script>";
        exit;
    }
}

if (isset($_POST['update'])) {
    if (updateAkun($_POST) > 0) {
        echo "<script>
            alert('Data Berhasil Diubah');
            document.location.href='list.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Gagal Diubah');
            document.location.href='list.php';
        </script>";
    }
}


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun - Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/styleLibrary.css">

    <style>
    .edit-akun-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .container {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .edit-card {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body class="edit-akun-page">
    <div class="container">
        <div class="edit-card mx-auto">
            <div class="edit-header">
                <h2>Edit Akun</h2>
                <p>Perbarui informasi akun</p>
            </div>

            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="name" id="name" 
                           value="<?= $user['name'] ?>" required
                           pattern="[A-Za-z\s]+" 
                           title="Nama hanya boleh berisi huruf dan spasi" placeholder=" ">
                    <label for="name">Nama Lengkap</label>
                    <div class="invalid-feedback">Nama tidak boleh kosong dan hanya boleh berisi huruf</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" id="username" 
                           value="<?= $user['username'] ?>" required
                           pattern="[A-Za-z0-9_]+" 
                           title="Username hanya boleh berisi huruf, angka, dan underscore" placeholder=" ">
                    <label for="username">Username</label>
                    <div class="invalid-feedback">Username tidak boleh kosong dan hanya boleh berisi huruf, angka, dan underscore</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" 
                           value="<?= $user['password'] ?>" required
                           minlength="6" placeholder=" ">
                    <label for="password">Password</label>
                    <div class="invalid-feedback">Password minimal 6 karakter</div>
                </div>

                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select name="level" id="level" class="form-select" required placeholder=" ">
                        <option value="">Pilih Level</option>
                        <option value="1" <?= $user['level'] == 1 ? 'selected' : '' ?>>Admin</option>
                        <option value="2" <?= $user['level'] == 2 ? 'selected' : '' ?>>Petugas</option>
                        <option value="3" <?= $user['level'] == 3 ? 'selected' : '' ?>>Siswa</option>
                    </select>
                    <div class="invalid-feedback">Silakan pilih level</div>
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required placeholder=" ">
                        <option value="">Pilih Status</option>
                        <option value="1" <?= $user['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $user['status'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <div class="invalid-feedback">Silakan pilih status</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="update" class="btn btn-update flex-grow-1">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                    </button>
                    <a href="list.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Form Validation Script -->
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // Password visibility toggle
        document.getElementById('password').addEventListener('input', function() {
            this.type = this.value.length > 0 ? 'text' : 'password';
        });
    </script>
</body>

</html>