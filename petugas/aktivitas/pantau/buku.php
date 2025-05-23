<?php
include '../../../config/app.php';

$buku = getAllBuku();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="../../../assets/styleLibrary.css" rel="stylesheet">

    <title>Pantau Buku</title>
</head>

<body>
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
                        <span class="notification-badge d-none">0</span>
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
                                    <h6 class="mb-0"><?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'Petugas'); ?></h6>
                                    <small class="text-light opacity-75">Petugas</small>
                                </div>
                            </div>
                            <div class="profile-dropdown mt-2">
                                <a href="#" class="dropdown-item"><i class="bi bi-person me-2"></i>Profil Saya</a>
                                <a href="#" class="dropdown-item"><i class="bi bi-key me-2"></i>Ganti Password</a>
                                <div class="dropdown-divider"></div>
                                <a href="../../../logout.php" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                            </div>
                        </div>
                    </li>

                    <!-- Menu Items -->
                    <li class="nav-item">
                        <a class="nav-link" href="../../dashboard.php">
                            <i class="bi bi-speedometer2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="buku.php">
                            <i class="bi bi-eye"></i>Lihat Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="akun.php">
                            <i class="bi bi-eye"></i>Lihat Akun
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../peminjaman/list.php">
                            <i class="bi bi-arrow-left-right"></i>Peminjaman & Pengembalian
                        </a>
                </ul>

                <!-- Desktop Right Navigation Items -->
                <ul class="navbar-nav ms-auto d-none d-lg-flex align-items-center gap-3">
                    <!-- Desktop Notifications -->
                    <li class="nav-item">
                        <a class="notification-link" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifikasi">
                            <i class="bi bi-bell"></i>
                            <span class="notification-badge d-none">0</span>
                        </a>
                    </li>

                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-circle">
                                <i class="bi bi-person-circle fs-4"></i>
                            </div>
                            <span class="ms-2"><?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'Petugas'); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-key me-2"></i>Ganti Password</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="../../../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 shadow d-none d-lg-block bg-sidebar">
                <div class="d-flex flex-column pt-3">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start">
                        <li class="nav-item w-100">
                            <a href="../../dashboard.php" class="nav-link px-3">
                                <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="buku.php" class="nav-link active px-3">
                                <i class="bi bi-book me-2"></i><span>Lihat Buku</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="akun.php" class="nav-link px-3">
                                <i class="bi bi-people me-2"></i><span>Lihat Akun</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../peminjaman/list.php" class="nav-link px-3">
                                <i class="bi bi-arrow-left-right me-2"></i><span>Peminjaman & Pengembalian</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../laporan/laporan.php" class="nav-link px-3">
                                <i class="bi bi-eye me-2"></i><span>Laporan</span>
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
                                <li class="breadcrumb-item"><a href="../../dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Pantau Buku</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Page Header -->
                    <div class="page-header">
                        <h2 class="page-title">Pantau Buku</h2>
                    </div>

                    <hr>

                    <!-- Content will go here -->
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Daftar Buku</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="table-success text-center">
                                        <tr>
                                            <th>No</th>
                                            <td>Kode Buku</td>
                                            <th>Judul</th>
                                            <th>Penulis</th>
                                            <th>Penerbit</th>
                                            <th>Kategori</th>
                                            <th>Rak</th>
                                            <th>Tahun</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($buku) > 0): ?>
                                            <?php foreach ($buku as $i => $item): ?>
                                                <tr>
                                                    <td class="text-center"><?= htmlspecialchars($i + 1) ?></td>
                                                    <td class="text-center"><?= "KDK" . htmlspecialchars($item['id_bukuV2']) ?></td>
                                                    <td><?= htmlspecialchars($item['judul_buku']) ?></td>
                                                    <td><?= htmlspecialchars($item['nama_penulis']) ?></td>
                                                    <td><?= htmlspecialchars($item['nama_penerbit']) ?></td>
                                                    <td><?= htmlspecialchars($item['nama_kat']) ?></td>
                                                    <td><?= htmlspecialchars($item['nama_rak']) ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($item['thn_terbit']) ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($item['stok']) ?></td>
                                                    <td class="text-center">
                                                        <?php if ($item['status'] === 'tersedia'): ?>
                                                            <span class="badge bg-success">Tersedia</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Tidak Tersedia</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9" class="text-center text-muted">Tidak ada data buku tersedia.</td>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Overlay for Mobile Menu -->
    <div class="mobile-menu-overlay d-lg-none"></div>

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
        });
    </script>
</body>

</html>