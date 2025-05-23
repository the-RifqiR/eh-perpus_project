<?php
include('../../../config/controller.php');

// Menggunakan function untuk mendapatkan data peminjaman
$result_peminjaman = getPeminjamanAktif();
$result_pengembalian = getPeminjamanSelesai();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman - Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="../../../assets/styleLibrary.css" rel="stylesheet">
    <link href="../../../assets/stylePetugas.css" rel="stylesheet">
</head>

<body class="list-akun-page">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-3 px-lg-4">
            <!-- Logo & Brand -->
            <a class="navbar-brand d-flex align-items-center" href="../../dashboard.php">
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
                        <a class="nav-link" href="../pantau/buku.php">
                            <i class="bi bi-book"></i>Lihat Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pantau/akun.php">
                            <i class="bi bi-people"></i>Lihat Akun
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="list.php">
                            <i class="bi bi-arrow-left-right"></i>Peminjaman & Pengembalian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../laporan/laporan.php">
                            <i class="bi bi-eye"></i>Laporan
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a href="daftar_request_peminjaman.php" class="nav-link px-3">
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
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 shadow d-none d-lg-block bg-sidebar" style="min-height: calc(100vh - 56px);">
                <div class="d-flex flex-column pt-3">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start">
                        <li class="nav-item w-100">
                            <a href="../../dashboard.php" class="nav-link px-3">
                                <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link px-3" href="../pantau/buku.php">
                                <i class="bi bi-book me-2"></i><span>Lihat Buku</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a class="nav-link px-3" href="../pantau/akun.php">
                                <i class="bi bi-people me-2"></i><span>Lihat Akun</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="list.php" class="nav-link active px-3">
                                <i class="bi bi-arrow-left-right me-2"></i><span>Peminjaman & Pengembalian</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../laporan/laporan.php" class="nav-link px-3">
                                <i class="bi bi-eye me-2"></i><span>Laporan</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="daftar_request_peminjaman.php" class="nav-link px-3">
                                <i class="bi bi-envelope-open"></i><span>Request Peminjaman</span>
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
                                <li class="breadcrumb-item active">Daftar Peminjaman</li>
                            </ol>
                        </nav>
                    </div>


                    <!-- Page Header -->
                    <div class="page-header">
                        <h2 class="page-title">Daftar Peminjaman</h2>
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-gold" id="toggleView">
                                <i class="bi bi-arrow-repeat me-2"></i>
                                <span class="toggle-text">Lihat Pengembalian</span>
                            </button>
                            <a href="create.php" class="btn-add-account">
                                <i class="bi bi-plus-circle"></i> Tambah Peminjaman
                            </a>
                        </div>
                    </div>


                    <hr>


                    <!-- Alert Notifikasi -->
                    <?php if (isset($_GET['delete'])): ?>
                        <?php if ($_GET['delete'] == 'success'): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                Peminjaman berhasil dihapus!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php elseif ($_GET['delete'] == 'error'): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                Gagal menghapus peminjaman!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    <?php if (isset($_GET['return'])): ?>
                        <?php if ($_GET['return'] == 'success'): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                Buku berhasil dikembalikan!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php elseif ($_GET['return'] == 'error'): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                Gagal mengembalikan buku!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    <!-- Flip Card Container -->
                    <div class="flip-container">
                        <!-- Front Card (Peminjaman) -->
                        <div class="flip-card" id="peminjamanCard">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2 mb-md-0">
                                            <!-- Search box -->
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" placeholder="Cari berdasarkan nama siswa...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Filter status -->
                                            <form method="GET" class="d-flex justify-content-md-end">
                                                <div class="input-group" style="max-width: 250px;">
                                                    <label class="input-group-text" for="status">Filter Status:</label>
                                                    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                                                        <option value="">Semua Status</option>
                                                        <option value="dipinjam">Dipinjam</option>
                                                        <option value="dikembalikan">Dikembalikan</option>
                                                        <option value="terlambat">Terlambat</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <!-- Table for Peminjaman -->
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Nama Petugas</th>
                                                    <th>Tanggal Pinjam</th>
                                                    <th>Tanggal Pengembalian</th>
                                                    <th>Judul Buku</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($result_peminjaman as $row):
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                                                        <td><?= htmlspecialchars($row['nama_petugas']) ?></td>
                                                        <td><?= date('d/m/Y', strtotime($row['tgl_peminjaman'])) ?></td>
                                                        <td><?= date('d/m/Y', strtotime($row['tgl_pengembalian'])) ?></td>
                                                        <td><?= htmlspecialchars($row['buku_dipinjam']) ?></td>
                                                        <td>
                                                            <span class="badge-status <?= $row['status_buku'] ?>">
                                                                <?= ucfirst($row['status_buku']) ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="action-buttons">
                                                                <a href="update.php?id=<?= $row['id_peminjaman'] ?>" 
                                                                   class="btn-action btn-edit" 
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-placement="top" 
                                                                   title="Edit Peminjaman">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                                                                <a href="delete.php?id=<?= $row['id_peminjaman'] ?>" 
                                                                   class="btn-action btn-delete" 
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-placement="top" 
                                                                   title="Hapus Peminjaman"
                                                                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                                    <i class="bi bi-trash"></i>
                                                                </a>
                                                                <button type="button" 
                                                                        class="btn-action btn-return"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#returnModal"
                                                                        data-id="<?= $row['id_peminjaman'] ?>"
                                                                        data-tgl-kembali="<?= $row['tgl_pengembalian'] ?>"
                                                                        data-bs-toggle="tooltip" 
                                                                        data-bs-placement="top" 
                                                                        title="Kembalikan Buku">
                                                                    <i class="bi bi-arrow-return-left"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Back Card (Pengembalian) -->
                        <div class="flip-card" id="pengembalianCard">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2 mb-md-0">
                                            <!-- Search box -->
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" placeholder="Cari berdasarkan nama siswa...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Filter status -->
                                            <form method="GET" class="d-flex justify-content-md-end">
                                                <div class="input-group" style="max-width: 250px;">
                                                    <label class="input-group-text" for="statusReturn">Filter Status:</label>
                                                    <select name="status" id="statusReturn" class="form-select" onchange="this.form.submit()">
                                                        <option value="">Semua Status</option>
                                                        <option value="dikembalikan">Dikembalikan</option>
                                                        <option value="terlambat">Terlambat</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <!-- Table for Pengembalian -->
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Nama Petugas</th>
                                                    <th>Tanggal Pinjam</th>
                                                    <th>Tanggal Pengembalian</th>
                                                    <th>Tanggal Dikembalikan</th>
                                                    <th>Judul Buku</th>
                                                    <th>Status</th>
                                                    <th>Denda</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($result_pengembalian as $row):
                                                ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                                                    <td><?= htmlspecialchars($row['nama_petugas']) ?></td>
                                                    <td><?= date('d/m/Y', strtotime($row['tgl_peminjaman'])) ?></td>
                                                    <td><?= date('d/m/Y', strtotime($row['tgl_pengembalian'])) ?></td>
                                                    <td>     
                                                        <div class="d-flex flex-column">
                                                            <span><?= date('d/m/Y', strtotime($row['tgl_dikembalikan'])) ?></span>
                                                            <?php 
                                                            $tgl_pengembalian = new DateTime($row['tgl_pengembalian']);
                                                            $tgl_dikembalikan = new DateTime($row['tgl_dikembalikan']);
                                                            if ($tgl_dikembalikan > $tgl_pengembalian): 
                                                            ?>
                                                                <small class="text-danger mt-1">
                                                                    <i class="bi bi-exclamation-circle"></i>
                                                                    <?= $tgl_dikembalikan->diff($tgl_pengembalian)->days ?> hari terlambat
                                                                </small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td><?= htmlspecialchars($row['buku_dipinjam']) ?></td>
                                                    <td>
                                                        <span class="badge-status <?= $row['status_buku'] ?>">
                                                            <?= ucfirst($row['status_buku']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($row['denda'] > 0): ?>
                                                            <span class="text-danger fw-bold">Rp <?= number_format($row['denda'], 0, ',', '.') ?></span>
                                                        <?php else: ?>
                                                            <span class="text-success">Rp 0</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
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

    <!-- Bootstrap JS -->
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Overlay for Mobile Menu -->
    <div class="mobile-menu-overlay d-lg-none"></div>

    <!-- JavaScript untuk toggle view -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleView');
            const toggleText = toggleButton.querySelector('.toggle-text');
            const peminjamanCard = document.getElementById('peminjamanCard');
            const pengembalianCard = document.getElementById('pengembalianCard');
            let isFlipped = false;

            toggleButton.addEventListener('click', function() {
                isFlipped = !isFlipped;

                if (isFlipped) {
                    peminjamanCard.style.transform = 'rotateY(180deg)';
                    pengembalianCard.style.transform = 'rotateY(0deg)';
                    toggleText.textContent = 'Lihat Peminjaman';
                } else {
                    peminjamanCard.style.transform = 'rotateY(0deg)';
                    pengembalianCard.style.transform = 'rotateY(-180deg)';
                    toggleText.textContent = 'Lihat Pengembalian';
                }
            });

            // Initialize tooltips with custom options
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover',
                    animation: true,
                    delay: { show: 100, hide: 100 }
                })
            });

            // Add click feedback to buttons
            document.querySelectorAll('.btn-action').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!this.classList.contains('btn-delete')) {
                        e.preventDefault();
                        const href = this.getAttribute('href');
                        if (href) {
                            setTimeout(() => {
                                window.location.href = href;
                            }, 300);
                        }
                    }
                });
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

            // Return Modal Handler
            const returnModal = document.getElementById('returnModal');
            if (returnModal) {
                returnModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const tglKembali = button.getAttribute('data-tgl-kembali');

                    // Set hidden inputs
                    document.getElementById('return_id_peminjaman').value = id;
                    document.getElementById('return_tgl_pengembalian').value = tglKembali;

                    // Calculate denda
                    const today = new Date();
                    const returnDate = new Date(tglKembali);
                    const diffTime = Math.abs(today - returnDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    let denda = 0;
                    if (today > returnDate) {
                        denda = diffDays * 5000;
                    }

                    document.getElementById('denda').value = denda;
                });
            }
        });

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

    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Pengembalian Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="return.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_peminjaman" id="return_id_peminjaman">
                        <input type="hidden" name="tgl_pengembalian" id="return_tgl_pengembalian">

                        <div class="mb-3">
                            <label for="tgl_dikembalikan" class="form-label">Tanggal Dikembalikan</label>
                            <input type="date" class="form-control" id="tgl_dikembalikan" name="tgl_dikembalikan"
                                value="<?= date('Y-m-d') ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="status_buku" class="form-label">Status Buku</label>
                            <select class="form-select" id="status_buku" name="status_buku" required>
                                <option value="dikembalikan">Dikembalikan</option>
                                <option value="rusak">Rusak</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="denda" class="form-label">Denda (Rp)</label>
                            <input type="number" class="form-control" id="denda" name="denda" readonly>
                            <small class="text-muted">Denda dihitung otomatis jika pengembalian terlambat (Rp 5.000/hari)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>