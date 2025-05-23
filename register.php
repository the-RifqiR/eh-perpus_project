<?php
include('config/controller.php');

if (isset($_POST['tambah'])) {
    if (registerAkun($_POST) > 0) {
        echo "<script>
                alert('Akun berhasil didaftarkan! Silakan login untuk mengakses sistem.');
                document.location.href='login.php';
              </script>";
    } else {
        echo "<script>
                alert('Pendaftaran gagal. Coba lagi!');
                document.location.href='register.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Akun - Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/styleLog.css">
</head>

<body class="register-page">
    <div class="register-card">
        <div class="register-header">
            <h2>Daftar Akun</h2>
            <p>Silakan lengkapi data diri Anda</p>
        </div>

        <form action="" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama" required>
                <label for="name">Nama Lengkap</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukan Username" required>
                <label for="username">Username</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" required>
                <label for="password">Password</label>
            </div>
            <!-- Checkbox sederhana untuk toggle password -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="showPassword" onclick="document.getElementById('password').type = this.checked ? 'text' : 'password'">
                <label class="form-check-label" for="showPassword">
                    Tampilkan Password
                </label>
            </div>

            <button type="submit" name="tambah" class="btn btn-register w-100">DAFTAR SEKARANG</button>
        </form>

        <div class="auth-links">
            <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
            <p>Kembali ke <a href="index.php">Halaman Utama</a></p>
        </div>
    </div> 
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>