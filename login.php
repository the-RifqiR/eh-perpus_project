<?php
include("config/controller.php");
// Logika Login
session_start(); // Memulai session

// Jika tombol login ditekan
if (isset($_POST['login'])) {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa kredensial pengguna
    $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($db, $query);

    // Jika data ditemukan
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level']; // Menyimpan peran pengguna

        // Arahkan berdasarkan level
        if ($row['level'] == '1') {
            $_SESSION['1'] = true;
            header("Location: admin/dashboard.php");
            exit();
        } elseif ($row['level'] == '2') {
            $_SESSION['2'] = true;
            header("Location: petugas/dashboard.php");
            exit();
        } elseif ($row['level'] == '3') {
            $_SESSION['3'] = true;
            header("Location: siswa/dashboard.php");
            exit();
        } else {
            // Level tidak dikenal
            $error = "Level akses tidak valid!";
        }
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/styleLog.css">
</head>

<body class="login-page">
    <div class="login-card">
        <div class="login-header">
            <h2>Login</h2>
            <p>Masuk ke akun Anda</p>
        </div>
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <!-- Checkbox sederhana untuk toggle password -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="showPassword" onclick="document.getElementById('password').type = this.checked ? 'text' : 'password'">
                <label class="form-check-label" for="showPassword">
                    Tampilkan Password
                </label>
            </div>
            <button type="submit" name="login" class="btn btn-login">Login</button>
        </form>
        <div class="auth-links">
            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            <p>Kembali ke <a href="index.php">Halaman Utama</a></p>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>