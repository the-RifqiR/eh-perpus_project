<?php
include('../../config/controller.php');


session_start();
if ($_SESSION['level'] !== '1') {
    header("Location: ../../unauthorized.php");
    exit;
}
// Mengambil data akun user dari database

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="../../assets/styleLibrary.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="../dashboard.php">PerpusKu</a>

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
                    <li class="nav-item w-100">
                        <a href="list.php" class="nav-link active px-3">
                            <i class="bi bi-book me-2"></i><span>Data Buku</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../akun/list.php">
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
                            <a href="../dashboard.php" class="nav-link px-3">
                                <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../buku/list.php" class="nav-link active px-3">
                                <i class="bi bi-book me-2"></i><span>Data Buku</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../akun/list.php" class="nav-link px-3 ">
                                <i class="bi bi-people me-2"></i><span>Data Anggota</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../peminjaman/list.php" class="nav-link px-3 k">
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
                                <li class="breadcrumb-item active">Daftar Buku</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Page Header -->
                    <div class="page-header">
                        <h2 class="page-title">Daftar Buku</h2>
                        <a href="create.php" class="btn-add-account">
                            <i class="bi bi-plus-circle"></i> Tambah Buku
                        </a>
                    </div>

                    <hr>

                    <!-- Alert Notifikasi -->
                    <?php if (isset($_GET['delete'])): ?>
                        <?php if ($_GET['delete'] == 'success'): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                Buku berhasil dihapus!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php elseif ($_GET['delete'] == 'error'): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                Gagal menghapus buku!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <!-- Search box -->
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" placeholder="Cari berdasarkan judul buku...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Filter level -->
                                    <form method="GET" class="d-flex justify-content-md-end">
                                        <div class="input-group" style="max-width: 250px;">
                                            <label class="input-group-text" for="kategori">Filter Kategori:</label>
                                            <select name="kategori" id="kategori" class="form-select" onchange="this.form.submit()">
                                                <option value="">Semua Kategori</option>
                                                <?php
                                                $kategoriList = getAllKategori();
                                                while ($kat = mysqli_fetch_assoc($kategoriList)): ?>
                                                    <option value="<?= $kat['id_kat'] ?>" <?= isset($_GET['kategori']) && $_GET['kategori'] == $kat['id_kat'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($kat['nama_kat']) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Card Grid -->
                            <div class="row g-4">
                                <?php
                                $no = 1;
                                $buku_list = getAllBuku();
                                foreach ($buku_list as $row):
                                ?>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="data-card h-100">
                                            <!-- Cover Image Section -->
                                            <div class="book-cover-wrapper">
                                                <img src="../uploads/<?= htmlspecialchars($row['cover']) ?>" alt="Cover">
                                            </div>

                                            <div class="data-card-header">
                                                <h6 class="book-title mb-0" data-bs-toggle="tooltip" title="<?= htmlspecialchars($row['judul_buku']) ?>">
                                                    <?= htmlspecialchars($row['judul_buku']) ?>
                                                </h6>
                                            </div>

                                            <div class="data-card-body">
                                                <div class="data-item">
                                                    <i class="bi bi-building"></i>
                                                    <span class="text-truncate" data-bs-toggle="tooltip" title="<?= htmlspecialchars($row['nama_penerbit']) ?>">
                                                        <?= htmlspecialchars($row['nama_penerbit']) ?>
                                                    </span>
                                                </div>
                                                <div class="data-item">
                                                    <i class="bi bi-person"></i>
                                                    <span class="text-truncate" data-bs-toggle="tooltip" title="<?= htmlspecialchars($row['nama_penulis']) ?>">
                                                        <?= htmlspecialchars($row['nama_penulis']) ?>
                                                    </span>
                                                </div>
                                                <div class="data-item">
                                                    <i class="bi bi-tags"></i>
                                                    <span class="text-truncate" data-bs-toggle="tooltip" title="<?= htmlspecialchars($row['nama_kat']) ?>">
                                                        <?= htmlspecialchars($row['nama_kat']) ?>
                                                    </span>
                                                </div>
                                                <div class="data-item">
                                                    <i class="bi bi-box"></i>
                                                    <span>Stok: <?= htmlspecialchars($row['stok']) ?></span>
                                                </div>
                                                <div class="data-item">
                                                    <i class="bi bi-calendar"></i>
                                                    <span>Tahun: <?= htmlspecialchars($row['thn_terbit']) ?></span>
                                                </div>
                                                <div class="data-item">
                                                    <i class="bi bi-bookshelf"></i>
                                                    <span>Rak: <?= htmlspecialchars($row['nama_rak']) ?></span>
                                                </div>
                                                <?php if (!empty($row['deskripsi_buku'])): ?>
                                                    <div class="data-item description-item">
                                                        <i class="bi bi-info-circle"></i>
                                                        <div class="description-content">
                                                            <p class="mb-0 description-text">
                                                                <?= htmlspecialchars($row['deskripsi_buku']) ?>
                                                            </p>
                                                            <?php if (strlen($row['deskripsi_buku']) > 100): ?>
                                                                <button class="btn btn-link btn-sm p-0 text-primary read-more-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#descriptionModal<?= $row['id_bukuV2'] ?>">
                                                                    Baca selengkapnya
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="data-card-footer">
                                                <div class="d-flex gap-2">
                                                    <a href="update.php?id=<?= $row['id_bukuV2'] ?>"
                                                        class="btn btn-sm btn-warning flex-grow-1 d-flex align-items-center justify-content-center gap-1">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <a href="delete.php?id=<?= $row['id_bukuV2'] ?>"
                                                        class="btn btn-sm btn-danger flex-grow-1 d-flex align-items-center justify-content-center gap-1"
                                                        onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal for Full Description -->
                                        <?php if (!empty($row['deskripsi_buku'])): ?>
                                            <div class="modal fade" id="descriptionModal<?= $row['id_bukuV2'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Deskripsi Buku</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="mb-3"><?= htmlspecialchars($row['judul_buku']) ?></h6>
                                                            <p class="mb-0"><?= nl2br(htmlspecialchars($row['deskripsi_buku'])) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Initialize tooltips -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Initialize tooltips
                                    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                    let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                                        return new bootstrap.Tooltip(tooltipTriggerEl, {
                                            trigger: 'hover'
                                        })
                                    });
                                });
                            </script>
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
</body>

</html>