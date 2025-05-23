<?php
include '../../../config/controller.php';
$query = "SELECT r.*, l.name, b.judul_buku FROM request_peminjaman r
          JOIN login l ON r.id_siswa = l.id
          JOIN bukuV2 b ON r.id_buku = b.id_bukuV2
          WHERE r.status_request = 'pending'
          ORDER BY r.tanggal_request DESC";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Request Peminjaman - PerpusKu</title>

    <!-- Bootstrap CSS -->
    <link href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="../../../assets/styleLibrary.css" rel="stylesheet">
    <link href="../../../assets/stylePetugas.css" rel="stylesheet">

    <style>
        .main-content {
            padding: 1.5rem;
            background-color: #f8f9fa;
            min-height: calc(100vh - 56px);
        }

        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .page-title {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumb-wrapper {
            margin-bottom: 1rem;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: #6c757d;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #2c3e50;
        }

        .request-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }

        .request-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .request-header {
            padding: 1.25rem;
            border-bottom: 1px solid #e9ecef;
        }

        .book-title {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
            font-size: 1.1rem;
        }

        .request-body {
            padding: 1.25rem;
        }

        .request-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            color: #6c757d;
        }

        .request-info i {
            color: #3498db;
            font-size: 1.1rem;
        }

        .request-footer {
            padding: 1.25rem;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
            border-radius: 0 0 10px 10px;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .alert i {
            font-size: 1.1rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .empty-state i {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6c757d;
            margin: 0;
        }
    </style>
</head>

<body>

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
                            <a href="list.php" class="nav-link px-3">
                                <i class="bi bi-arrow-left-right me-2"></i><span>Peminjaman & Pengembalian</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="../laporan/laporan.php" class="nav-link px-3">
                                <i class="bi bi-eye me-2"></i><span>Laporan</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="daftar_request_peminjaman.php" class="nav-link active px-3">
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
                                <li class="breadcrumb-item active">Request Peminjaman</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Page Header -->
                    <div class="page-header">
                        <h2 class="page-title">
                            <i class="bi bi-envelope-open me-2"></i>
                            Request Peminjaman
                        </h2>
                    </div>

                    <?php if (isset($_GET['msg'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= htmlspecialchars($_GET['msg']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row g-4">
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="request-card">
                                                <div class="request-header">
                                                    <h6 class="book-title"><?= htmlspecialchars($row['judul_buku']) ?></h6>
                                                </div>
                                                <div class="request-body">
                                                    <div class="request-info">
                                                        <i class="bi bi-person"></i>
                                                        <span><?= htmlspecialchars($row['name']) ?></span>
                                                    </div>
                                                    <div class="request-info">
                                                        <i class="bi bi-calendar"></i>
                                                        <span>Request: <?= date('d/m/Y H:i', strtotime($row['tanggal_request'])) ?></span>
                                                    </div>
                                                    <?php if (!empty($row['catatan_siswa'])): ?>
                                                        <div class="request-info">
                                                            <i class="bi bi-chat-left-text"></i>
                                                            <span><?= htmlspecialchars($row['catatan_siswa']) ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="request-footer">
                                                    <div class="d-flex gap-2">
                                                        <a href="create.php?id_request=<?= $row['id_request'] ?>" 
                                                           class="btn btn-success btn-action flex-grow-1">
                                                            <i class="bi bi-check-circle"></i>
                                                            <span>Setujui</span>
                                                        </a>
                                                        <a href="proses_approve_request.php?id_request=<?= $row['id_request'] ?>&action=reject" 
                                                           class="btn btn-danger btn-action flex-grow-1"
                                                           onclick="return confirm('Yakin ingin menolak request ini?')">
                                                            <i class="bi bi-x-circle"></i>
                                                            <span>Tolak</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="col-12">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <p>Tidak ada request peminjaman yang menunggu persetujuan.</p>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>