<?php
include('../config/controller.php');

session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== '2') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - Eh-Perpus</title>

    <!-- Bootstrap CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets/styleDashboard.css" rel="stylesheet">
</head>

<body class="">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-3 px-lg-4">
            <!-- Logo & Brand -->
            <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
                <i class="bi bi-book me-2 fs-4"></i>
                <span class="fs-4">Eh-Perpus</span>
            </a>

            <!-- Right Navigation Items (Always Visible) -->
            <ul class="navbar-nav ms-auto d-flex align-items-center gap-3 d-lg-none">
                <!-- Mobile Notifications -->
                <li class="nav-item">
                    <a class="notification-link" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifikasi">
                        <i class="bi bi-bell"></i>
                        <?php
                        // TODO: Implementasi notifikasi dinamis
                        // $unreadNotifications = getUnreadNotifications(); // Fungsi untuk mengambil notifikasi yang belum dibaca
                        // if ($unreadNotifications > 0): 
                        ?>
                        <span class="notification-badge d-none">0</span>
                        <?php // endif; 
                        ?>
                    </a>
                </li>
            </ul>

            <!-- Hamburger Menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Mobile Menu -->
                <ul class="navbar-nav d-lg-none mt-3 mb-2 w-100">
                    <!-- Profile Section -->
                    <li class="nav-item mb-3">
                        <div class="mobile-profile-section">
                            <div class="profile-header d-flex align-items-center">
                                <div class="profile-circle">
                                    <i class="bi bi-person-circle fs-4"></i>
                                </div>
                                <div class="profile-info">
                                    <h6 class="mb-0"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Petugas'); ?></h6>
                                    <small class="text-light opacity-75">Petugas</small>
                                </div>
                            </div>
                            <div class="profile-dropdown mt-2">
                                <a href="#" class="dropdown-item"><i class="bi bi-person me-2"></i>Profil Saya</a>
                                <a href="#" class="dropdown-item"><i class="bi bi-key me-2"></i>Ganti Password</a>
                                <div class="dropdown-divider"></div>
                                <a href="../logout.php" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                            </div>
                        </div>
                    </li>

                    <!-- Menu Items -->
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="bi bi-speedometer2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aktivitas/buku/list.php">
                            <i class="bi bi-book"></i>Data Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aktivitas/akun/list.php">
                            <i class="bi bi-people"></i>Data Anggota
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="peminjaman/list.php">
                            <i class="bi bi-arrow-left-right"></i>Peminjaman & Pengembalian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aktivitas/pantau/peminjaman.php">
                            <i class="bi bi-eye"></i>Pantau Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laporan/index.php">
                            <i class="bi bi-file-earmark-text"></i>Laporan
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a href="aktivitas/peminjaman/daftar_request_peminjaman.php" class="nav-link px-3">
                            <i class="bi bi-envelope-open"></i><span>Request Peminjaman</span>
                        </a>
                    </li>
                </ul>

                <!-- Desktop Right Navigation Items -->
                <ul class="navbar-nav ms-auto d-none d-lg-flex align-items-center gap-3">
                    <!-- Desktop Notifications -->
                    <li class="nav-item">
                        <a class="notification-link" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifikasi">
                            <i class="bi bi-bell"></i>
                            <?php
                            // TODO: Implementasi notifikasi dinamis
                            // $unreadNotifications = getUnreadNotifications(); // Fungsi untuk mengambil notifikasi yang belum dibaca
                            // if ($unreadNotifications > 0): 
                            ?>
                            <span class="notification-badge d-none">0</span>
                            <?php // endif; 
                            ?>
                        </a>
                    </li>

                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-circle">
                                <i class="bi bi-person-circle fs-4"></i>
                            </div>
                            <span class="ms-2"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-key me-2"></i>Ganti Password</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Overlay for Mobile Menu -->
    <div class="mobile-menu-overlay d-lg-none"></div>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 shadow d-none d-lg-block bg-sidebar" style="min-height: calc(100vh - 56px);">
                <div class="d-flex flex-column pt-3">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start">
                        <li class="nav-item w-100">
                            <a href="dashboard.php" class="nav-link active px-3">
                                <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="aktivitas/pantau/buku.php" class="nav-link px-3">
                                <i class="bi bi-book me-2"></i><span>Lihat Buku</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="aktivitas/pantau/akun.php" class="nav-link px-3">
                                <i class="bi bi-people me-2"></i><span>Lihat Anggota</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="aktivitas/peminjaman/list.php" class="nav-link px-3 ">
                                <i class="bi bi-arrow-left-right me-2"></i><span>Peminjaman & Pengembalian</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="laporan/index.php" class="nav-link px-3">
                                <i class="bi bi-file-earmark-text me-2"></i><span>Laporan</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="aktivitas/peminjaman/daftar_request_peminjaman.php" class="nav-link px-3">
                                <i class="bi bi-envelope-open"></i><span>Request Peminjaman</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col py-3">
                <!-- Breadcrumb -->
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>

                <!-- Page Header -->
                <div class="page-header">
                    <h2 class="page-title">Dashboard Petugas</h2>
                    <p class="page-description">
                        <i class="bi bi-book me-2"></i>
                        Selamat datang di dashboard, Petugas <?php echo htmlspecialchars($_SESSION['name'] ?? 'petugas'); ?>.
                        Di sini Anda dapat memantau aktivitas perpustakaan digital.
                    </p>
                </div>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <!-- Jumlah Buku Tersedia -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card" style="--card-index: 0">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                                            <i class="bi bi-book text-primary fs-3"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-0">Buku Tersedia</h6>
                                        <h2 class="mt-2 mb-0 counter">150</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Siswa Terdaftar -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card" style="--card-index: 1">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success bg-opacity-10 p-3 rounded">
                                            <i class="bi bi-people text-success fs-3"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-0">Siswa Terdaftar</h6>
                                        <h2 class="mt-2 mb-0 counter">75</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Peminjaman Hari Ini -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card" style="--card-index: 2">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info bg-opacity-10 p-3 rounded">
                                            <i class="bi bi-arrow-left-right text-info fs-3"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-0">Peminjaman Hari Ini</h6>
                                        <h2 class="mt-2 mb-0 counter">12</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengembalian Jatuh Tempo -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card" style="--card-index: 3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                                            <i class="bi bi-exclamation-circle text-danger fs-3"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-0">Jatuh Tempo Hari Ini</h6>
                                        <h2 class="mt-2 mb-0 counter">3</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Low Stock Books -->
                <div class="row">
                    <!-- Recent Activity -->
                    <div class="col-12 col-lg-8 mb-4">
                        <div class="card shadow-sm dashboard-section">
                            <div class="card-header recent-activity-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                                <a href="aktivitas/peminjaman/list.php" class="btn btn-sm btn-gold">
                                    <i class="bi bi-list-ul me-1"></i> Lihat Semua
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Siswa</th>
                                                <th>Buku</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="--row-index: 0">
                                                <td>2024-02-20</td>
                                                <td>Budi Santoso</td>
                                                <td>Atomic Habits</td>
                                                <td><span class="badge badge-status bg-info">Peminjaman Baru</span></td>
                                            </tr>
                                            <tr style="--row-index: 1">
                                                <td>2024-02-20</td>
                                                <td>Ani Wijaya</td>
                                                <td>Bumi</td>
                                                <td><span class="badge badge-status bg-success">Dikembalikan</span></td>
                                            </tr>
                                            <tr style="--row-index: 2">
                                                <td>2024-02-19</td>
                                                <td>Dewi Putri</td>
                                                <td>Dilan 1990</td>
                                                <td><span class="badge badge-status bg-danger">Terlambat</span></td>
                                            </tr>
                                            <tr style="--row-index: 3">
                                                <td>2024-02-19</td>
                                                <td>Rudi Hartono</td>
                                                <td>Laskar Pelangi</td>
                                                <td><span class="badge badge-status bg-success">Dikembalikan</span></td>
                                            </tr>
                                            <tr style="--row-index: 4">
                                                <td>2024-02-18</td>
                                                <td>Siti Aminah</td>
                                                <td>Filosofi Teras</td>
                                                <td><span class="badge badge-status bg-info">Peminjaman Baru</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Books -->
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="card shadow-sm dashboard-section">
                            <div class="card-header recent-activity-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Stok Minim</h5>
                                <a href="aktivitas/buku/list.php" class="btn btn-sm btn-gold">
                                    <i class="bi bi-book me-1"></i> Lihat Semua
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Judul Buku</th>
                                                <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="--row-index: 0">
                                                <td>Atomic Habits</td>
                                                <td><span class="badge bg-danger">2</span></td>
                                            </tr>
                                            <tr style="--row-index: 1">
                                                <td>Bumi</td>
                                                <td><span class="badge bg-danger">1</span></td>
                                            </tr>
                                            <tr style="--row-index: 2">
                                                <td>Dilan 1990</td>
                                                <td><span class="badge bg-warning">3</span></td>
                                            </tr>
                                            <tr style="--row-index: 3">
                                                <td>Filosofi Teras</td>
                                                <td><span class="badge bg-warning">3</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Animate counters
            function animateCounter(element, target) {
                let current = 0;
                const increment = target / 50;
                const duration = 1000;
                const stepTime = duration / 50;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current).toLocaleString();
                    }
                }, stepTime);
            }

            // Animate all counters
            document.querySelectorAll('.counter').forEach(counter => {
                const target = parseInt(counter.textContent) || 0;
                animateCounter(counter, target);
            });

            // Intersection Observer untuk animasi section
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            // Observe all dashboard sections
            document.querySelectorAll('.dashboard-section').forEach(section => {
                observer.observe(section);
            });
        });
    </script>
</body>

</html>