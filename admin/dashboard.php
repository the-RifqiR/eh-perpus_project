<?php
include('../config/controller.php');

session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== '1') {
    header("Location: ../login.php");
    exit();
}

$dataAkun = getRecentAkun(5);

// Untuk menghitung total akun
$totalAkun = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM login"))['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpustakaan</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/styleDashboard.css">
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
                                    <h6 class="mb-0"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></h6>
                                    <small class="text-light opacity-75">Administrator</small>
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
                        <a class="nav-link" href="buku/list.php">
                            <i class="bi bi-book"></i>Data Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="akun/list.php">
                            <i class="bi bi-people"></i>Data Anggota
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="peminjaman/list.php">
                            <i class="bi bi-arrow-left-right"></i>Peminjaman & Pengembalian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laporan/index.php">
                            <i class="bi bi-file-earmark-text"></i>Laporan
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
                            <a href="buku/list.php" class="nav-link px-3">
                                <i class="bi bi-book me-2"></i><span>Data Buku</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="akun/list.php" class="nav-link px-3">
                                <i class="bi bi-people me-2"></i><span>Data Anggota</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../petugas/aktivitas/peminjaman/list.php" class="nav-link px-3 ">
                                <i class="bi bi-arrow-left-right me-2"></i><span>Peminjaman & Pengembalian</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="laporan/index.php" class="nav-link px-3">
                                <i class="bi bi-file-earmark-text me-2"></i><span>Laporan</span>
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
                    <h2 class="page-title">Dashboard</h2>
                    <p class="page-description">
                        <i class="bi bi-book me-2"></i>
                        Selamat datang di dashboard, Admin <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>. 
                        Di sini Anda dapat mengelola seluruh aktivitas perpustakaan digital.
                    </p>
                </div>

                <hr>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
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
                                        <h6 class="card-title mb-0">Total Buku</h6>
                                        <h2 class="mt-2 mb-0 counter"><?php  ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <a href="akun/list.php" class="text-decoration-none">
                            <div class="stat-card stat-card-hover" style="--card-index: 1">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                                <i class="bi bi-people text-primary fs-3"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="card-title mb-0 text-dark">Total Anggota</h6>
                                            <h2 class="mt-2 mb-0 text-dark counter"><?php echo number_format($totalAkun); ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="stat-card" style="--card-index: 2">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                                            <i class="bi bi-arrow-left-right text-primary fs-3"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-0">Peminjaman Aktif</h6>
                                        <h2 class="mt-2 mb-0 counter"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <h6 class="card-title mb-0">Buku Terlambat</h6>
                                        <h2 class="mt-2 mb-0 counter"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="row">
                    <!-- Kartu Aktivitas Terbaru Akun -->
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm dashboard-section">
                            <div class="card-header recent-activity-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Aktivitas Terbaru Akun</h5>
                                <a href="akun/list.php" class="btn btn-sm btn-gold">
                                    <i class="bi bi-list-ul me-1"></i> Lihat Semua Akun
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Level</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($dataAkun)) {
                                                $no = 1;
                                                foreach ($dataAkun as $user): ?>
                                                    <tr style="--row-index: <?= $no - 1 ?>">
                                                        <td><?= $no++ ?></td>
                                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                                        <td><?= getLevelName($user['level']) ?></td>
                                                        <td>
                                                            <span class="badge badge-status bg-<?= $user['status'] == 1 ? 'success' : 'secondary' ?>">
                                                                <?= getStatusText($user['status']) ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                            <?php
                                                endforeach;
                                            } else {
                                                echo '<tr><td colspan="5" class="text-center">Tidak ada data akun.</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Aktivitas Terbaru Buku -->
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header recent-activity-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Aktivitas Terbaru Buku</h5>
                                <a href="buku/list.php" class="btn btn-sm btn-gold">
                                    <i class="bi bi-book me-1"></i> Lihat Semua Buku
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Buku</th>
                                                <th>Pengarang</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            echo '<tr><td colspan="5" class="text-center">Tidak ada data buku terkini.</td></tr>';
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Aktivitas Terbaru Peminjaman -->
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header recent-activity-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Aktivitas Terbaru Peminjaman</h5>
                                <a href="peminjaman/list.php" class="btn btn-sm btn-gold">
                                    <i class="bi bi-arrow-left-right me-1"></i> Lihat Semua Peminjaman
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peminjam</th>
                                                <th>Judul Buku</th>
                                                <th>Tgl Pinjam</th>
                                                <th>Tgl Kembali</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            echo '<tr><td colspan="6" class="text-center">Tidak ada data peminjaman terkini.</td></tr>';
                                            ?>
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
    </div>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Mobile menu click outside handler
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const navbarToggler = document.querySelector('.navbar-toggler');

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInside = navbarCollapse.contains(event.target);
                const isNavbarToggler = event.target.closest('.navbar-toggler');

                if (navbarCollapse.classList.contains('show') && !isClickInside && !isNavbarToggler) {
                    navbarCollapse.classList.remove('show');
                }
            });

            // Prevent menu from closing when clicking inside
            navbarCollapse.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            // Profile dropdown toggle for mobile
            const profileHeader = document.querySelector('.profile-header');
            if (profileHeader) {
                profileHeader.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.classList.toggle('active');
                });
            }

            // Close profile dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (profileHeader && !profileHeader.contains(e.target)) {
                    profileHeader.classList.remove('active');
                }
            });

            // Fungsi untuk animasi counter
            function animateCounter(element, target) {
                let current = 0;
                const increment = target / 50; // 50 steps
                const duration = 1000; // 1 second
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