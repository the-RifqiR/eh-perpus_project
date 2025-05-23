<?php
session_start();

// Cek level untuk menentukan dashboard tujuan
$dashboardUrl = '../index.php'; // fallback umum

if (isset($_SESSION['level'])) {
    switch ($_SESSION['level']) {
        case '1':
            $dashboardUrl = 'admin/dashboard.php';
            break;
        case '2':
            $dashboardUrl = 'petugas/dashboard.php';
            break;
        case '3':
            $dashboardUrl = 'siswa/dashboard.php';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <h1 class="text-danger mb-4">🚫 Akses Ditolak</h1>
        <p class="mb-3">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <p class="text-muted">Level akun Anda: <strong><?= htmlspecialchars($_SESSION['level'] ?? 'Tidak Diketahui') ?></strong></p>
        <a href="<?= $dashboardUrl ?>" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</body>
</html>