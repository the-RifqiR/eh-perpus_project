<?php
include('../../config/controller.php');


session_start();
if ($_SESSION['level'] !== '1') {
    header("Location: ../../unauthorized.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="../../assets/styleLibrary.css" rel="stylesheet">
</head>

<body class="list-akun-page">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-3 px-lg-4">
            <!-- Logo & Brand -->
            <a class="navbar-brand d-flex align-items-center" href="../dashboard.php">
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
                                    <h6 class="mb-0"><?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'Admin'); ?></h6>
                                    <small class="text-light opacity-75">Administrator</small>
                                </div>
                            </div>
                            <div class="profile-dropdown mt-2">
                                <a href="#" class="dropdown-item"><i class="bi bi-person me-2"></i>Profil Saya</a>
                                <a href="#" class="dropdown-item"><i class="bi bi-key me-2"></i>Ganti Password</a>
                                <div class="dropdown-divider"></div>
                                <a href="../../logout.php" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                            </div>
                        </div>
                    </li>

                    <!-- Menu Items -->
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard.php">
                            <i class="bi bi-speedometer2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../buku/list.php">
                            <i class="bi bi-book"></i>Data Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="list.php">
                            <i class="bi bi-people"></i>Data Anggota
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../peminjaman/list.php">
                            <i class="bi bi-arrow-left-right"></i>Peminjaman & Pengembalian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../laporan/index.php">
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
                            <span class="ms-2"><?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'Admin'); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-key me-2"></i>Ganti Password</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="../../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 shadow d-none d-lg-block bg-sidebar" style="min-height: calc(100vh - 56px);">
                <div class="d-flex flex-column pt-3">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start">
                        <li class="nav-item w-100">
                            <a href="../dashboard.php" class="nav-link px-3 ">
                                <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../buku/list.php" class="nav-link px-3 ">
                                <i class="bi bi-book me-2"></i><span>Data Buku</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="list.php" class="nav-link active px-3 ">
                                <i class="bi bi-people me-2"></i><span>Data Anggota</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../peminjaman/list.php" class="nav-link px-3 ">
                                <i class="bi bi-arrow-left-right me-2"></i><span>Peminjaman & Pengembalian</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../laporan/index.php" class="nav-link px-3 ">
                                <i class="bi bi-file-earmark-text me-2"></i><span>Laporan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col py-3">
                <div class="container-fluid">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Daftar Akun</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Page Header -->
                    <div class="page-header">
                        <h2 class="page-title">Daftar Akun</h2>
                        <a href="createAkunAdmin.php" class="btn-add-account">
                            <i class="bi bi-plus-circle"></i> Tambah Akun
                        </a>
                    </div>
                    <hr>
                    

                    <!-- Alert Notifikasi -->
                    <?php if (isset($_GET['delete'])): ?>
                        <?php if ($_GET['delete'] == 'success'): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                Akun berhasil dihapus!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php elseif ($_GET['delete'] == 'error'): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                Gagal menghapus akun!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Card Grid Section -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <!-- Search and Filter -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" placeholder="Cari berdasarkan nama...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <form method="GET" class="d-flex justify-content-md-end">
                                        <div class="input-group" style="max-width: 250px;">
                                            <label class="input-group-text" for="level">Filter Level:</label>
                                            <select name="level" id="level" class="form-select" onchange="this.form.submit()">
                                                <option value="">Semua Level</option>
                                                <option value="1" <?= isset($_GET['level']) && $_GET['level'] == '1' ? 'selected' : '' ?>>Admin</option>
                                                <option value="2" <?= isset($_GET['level']) && $_GET['level'] == '2' ? 'selected' : '' ?>>Petugas</option>
                                                <option value="3" <?= isset($_GET['level']) && $_GET['level'] == '3' ? 'selected' : '' ?>>Siswa</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                </div>

                            <!-- Card Grid -->
                            <div class="row g-3">
                                            <?php
                                            $no = 1;
                                            $level = isset($_GET['level']) ? $_GET['level'] : '';
                                            $rows = getFilteredAkun($level);
                                            foreach ($rows as $row): ?>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="data-card">
                                            <div class="data-card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0"><?= htmlspecialchars($row['name']) ?></h6>
                                                        <span class="badge bg-<?= $row['status'] == 1 ? 'success' : 'secondary' ?>">
                                                            <?= getStatusText($row['status']) ?>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="data-card-body">
                                                <div class="data-item">
                                                    <i class="bi bi-person-circle"></i>
                                                    <span><?= htmlspecialchars($row['username']) ?></span>
                                                </div>
                                                <div class="data-item">
                                                    <i class="bi bi-key"></i>
                                                    <span><?= htmlspecialchars($row['password']) ?></span>
                                                </div>
                                                <div class="data-item">
                                                    <i class="bi bi-person-badge"></i>
                                                    <span><?= getLevelName($row['level']) ?></span>
                                                </div>
                                            </div>
                                            <div class="data-card-footer">
                                                <div class="d-flex gap-2">
                                                    <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning flex-grow-1">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                            </a>
                                                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger flex-grow-1" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                            </a>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                            <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Overlay for Mobile Menu -->
    <div class="mobile-menu-overlay d-lg-none"></div>

    <!-- JavaScript untuk mobile menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
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
        });
    </script>

    <script>
        // Auto hide alert after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });
    </script>
</body>

</html>