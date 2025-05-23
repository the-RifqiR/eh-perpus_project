<?php
include('../../config/app.php');




session_start();
if ($_SESSION['level'] !== '1') {
    header("Location: ../../unauthorized.php");
    exit;
}

if (isset($_POST['tambah'])) {
    if (createAkunAdmin($_POST) > 0) {
        echo "<script>
                alert('Akun berhasil didaftarkan!');
                document.location.href='list.php';
              </script>";
    } else {
        echo "<script>
                alert('Pendaftaran gagal. Coba lagi!');
                document.location.href='createAkunAdmin.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun - Eh-Perpus</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="../../node_modules/bootstrap-icons/font/bootstrap-icons.css">

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

    .container-fluid {
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
    <div class="container-fluid">
        <div class="edit-card">
            <div class="edit-header">
                <h2>Tambah Akun</h2>
                <p>Tambahkan akun baru melalui panel admin</p>
            </div>

            <form action="" method="POST" class="needs-validation" novalidate>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder=" " required>
                    <label for="name">Nama Lengkap</label>
                    <div class="invalid-feedback">
                        Nama lengkap harus diisi
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder=" " required>
                    <label for="username">Username</label>
                    <div class="invalid-feedback">
                        Username harus diisi
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
                    <label for="password">Password</label>
                    <div class="invalid-feedback">
                        Password harus diisi
                    </div>
                </div>

                <!-- Password Toggle -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="showPassword" onclick="document.getElementById('password').type = this.checked ? 'text' : 'password'">
                    <label class="form-check-label" for="showPassword">
                        Tampilkan Password
                    </label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="level" name="level" required placeholder=" ">
                        <option value="">Pilih Level</option>
                        <option value="1">Admin</option>
                        <option value="2">Petugas</option>
                        <option value="3">Siswa</option>
                    </select>
                    <label for="level">Level Akses</label>
                    <div class="invalid-feedback">
                        Level akses harus dipilih
                    </div>
                </div>

                <div class="form-floating mb-4">
                    <select class="form-select" id="status" name="status" required placeholder=" ">
                        <option value="">Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <label for="status">Status Akun</label>
                    <div class="invalid-feedback">
                        Status akun harus dipilih
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="tambah" class="btn btn-update">
                        <i class="bi bi-person-plus-fill me-2"></i>Tambah Akun
                    </button>
                    <a href="list.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Form Validation Script -->
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>