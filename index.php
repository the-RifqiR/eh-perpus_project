<?php
include('config/controller.php');
session_start();

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['level']);
}

// Function to get user level
function getUserLevel() {
    return $_SESSION['level'] ?? null;
}

// Function to get redirect URL based on user level
function getRedirectUrl() {
    $level = getUserLevel();
    switch($level) {
        case '1':
            return 'admin/dashboard.php';
        case '2':
            return 'petugas/dashboard.php';
        case '3':
            return 'siswa/dashboard.php';
        default:
            return 'login.php';
    }
}
?>

<!DOCTYPE html>
<html lang="id">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eh-Perpus</title>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/styleIndex.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Preloader Styles */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--light-color);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }

        .preloader.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .preloader-content {
            text-align: center;
        }

        .preloader-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        .preloader-text {
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 600;
            animation: pulse 1.5s infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }

        /* Enhanced Book Card Styles */
        .book-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: white;
            height: 100%;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .book-card .card-img-top {
            height: 300px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .book-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .book-card .card-body {
            padding: 1.5rem;
            background: white;
        }

        .book-card .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .book-card .card-text {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .book-card .card-text i {
            color: var(--primary-color);
            width: 20px;
        }

        .book-card .btn-borrow {
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .book-card .btn-borrow:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .book-card .btn-borrow i {
            font-size: 1.1rem;
        }

        .book-card .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .book-card .status-badge.available {
            background: var(--success-color);
            color: white;
        }

        .book-card .status-badge.borrowed {
            background: var(--danger-color);
            color: white;
        }

        .book-card .status-badge i {
            font-size: 1rem;
        }

        .book-card .stok-info {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Modal Styles */
        .login-modal .modal-content {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }

        .login-modal .modal-header {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .login-modal .modal-body {
            padding: 2rem;
            text-align: center;
        }

        .login-modal .modal-footer {
            border: none;
            padding: 1.5rem;
            justify-content: center;
        }

        .login-modal .btn-login {
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .login-modal .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .emoji-container {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-content">
            <div class="preloader-spinner"></div>
            <div class="preloader-text">Loading Eh-Perpus...</div>
        </div>
    </div>

    <!-- Navbar Umum (Login/Register) -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-book-open me-2" style="font-size: 1.5rem;"></i>
                <span class="fw-bold" style="font-size: 1.4rem; letter-spacing: 0.5px;">Eh-Perpus</span>
            </a>

            <!-- Tombol Toggle untuk layar kecil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Isi Navbar -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Menu Kategori -->
                <ul class="navbar-nav me-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-th-list me-1"></i> Kategori
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Semua Kategori</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php
                            $query = "SELECT * FROM kategori ORDER BY nama_kat ASC";
                            $result = mysqli_query($db, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<li><a class='dropdown-item' href='#'>{$row['nama_kat']}</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                </ul>

                <!-- Kolom Pencarian (tengah) -->
                <div class="navbar-search mx-auto">
                    <i class="fas fa-search search-icon"></i>
                    <input class="search-input" type="search" placeholder="Cari buku..." aria-label="Search">
                </div>

                <!-- Menu Kanan -->
                <div class="d-flex align-items-center ms-auto gap-2">
                    <!-- Dropdown Aktivitas Saya -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="aktivitasDropdown" role="button" data-bs-toggle="dropdown">
                                Aktivitas Saya
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if (isLoggedIn()): ?>
                                    <?php if (getUserLevel() == '2'): ?>
                                        <li><a class="dropdown-item" href="petugas/dashboard.php">Peminjaman</a></li>
                                    <?php elseif (getUserLevel() == '3'): ?>
                                        <li><a class="dropdown-item" href="siswa/dashboard.php">Peminjaman</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="siswa/dashboard.php">Pengembalian</a></li>
                                    <li><a class="dropdown-item" href="admin/dashboard.php">Riwayat</a></li>
                                <?php else: ?>
                                    <li><button class="dropdown-item" onclick="showLoginModal()">Login untuk melihat aktivitas</button></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>

                    <!-- Tombol Keranjang -->
                    <?php if (isLoggedIn()): ?>
                        <a href="siswa/keranjang.php" class="btn btn-outline-light">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </a>
                    <?php else: ?>
                        <button class="btn btn-outline-light" onclick="showLoginModal()">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </button>
                    <?php endif; ?>

                    <!-- Dropdown Akun -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> Akun
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if (isLoggedIn()): ?>
                                    <li><a class="dropdown-item" href="<?php echo getRedirectUrl(); ?>">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                                    <li><a class="dropdown-item" href="register.php">Register</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <main class="flex-grow-1">
        <div class="container py-4">
            <!-- Highlight Section -->
            <section class="highlight-custom mb-4">
                <h1>Selamat Datang di Eh-Perpus</h1>
                <p class="lead">Perpustakaan online. Pinjam buku di mana saja dan kapan saja.</p>
                <?php if (isLoggedIn()): ?>
                    <a href="<?php echo getRedirectUrl(); ?>" class="btn btn-light btn-lg">Masuk Sekarang</a>
                <?php else: ?>
                    <button class="btn btn-light btn-lg" onclick="showLoginModal()">Masuk Sekarang</button>
                <?php endif; ?>
            </section>

            <!-- Popular Books Section -->
            <section class="popular-books mb-4">
                <h2 class="mb-4">📚 Buku Populer</h2>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    <?php
                    $books = getAllBuku();
                    foreach ($books as $book) {
                        $cover_path = !empty($book['cover']) ? 'admin/uploads/' . $book['cover'] : 'assets/default-cover.jpg';
                        $isAvailable = $book['stok'] > 0;
                    ?>
                        <div class="col">
                            <div class="book-card">
                                <div class="position-relative">
                                    <img src="<?= $cover_path ?>" class="card-img-top" alt="<?= $book['judul_buku'] ?>">
                                    <span class="stok-info">
                                        <i class="fas fa-box"></i> Stok: <?= $book['stok'] ?>
                                    </span>
                                    <span class="status-badge <?= $isAvailable ? 'available' : 'borrowed' ?>">
                                        <i class="fas <?= $isAvailable ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                                        <?= $isAvailable ? 'Tersedia' : 'Stok Habis' ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $book['judul_buku'] ?></h5>
                                    <p class="card-text">
                                        <i class="fas fa-user-edit"></i>
                                        <?= $book['nama_penulis'] ?>
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-building"></i>
                                        <?= $book['nama_penerbit'] ?>
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-bookmark"></i>
                                        <?= $book['nama_kat'] ?>
                                    </p>
                                    <?php if ($isAvailable): ?>
                                        <button class="btn btn-primary btn-borrow" onclick="showLoginModal()">
                                            <i class="fas fa-book-reader"></i>
                                            Pinjam
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-borrow" disabled>
                                            <i class="fas fa-ban"></i>
                                            Stok Habis
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>

            <!-- Info Section -->
            <section class="pemberitahuan-custom">
                <p class="mb-0"><strong>Info:</strong> Anda harus login untuk meminjam atau mengembalikan buku.</p>
            </section>
        </div>
    </main>

    <!-- Login Modal -->
    <div class="modal fade login-modal" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Perhatian!
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="emoji-container">
                        🤔
                    </div>
                    <h4 class="mb-3">Kamu Belum Login!!</h4>
                    <p class="text-muted">Login dulu untuk aktivitas lainnya, ya!</p>
                </div>
                <div class="modal-footer">
                    <a href="login.php" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Iya.. Bang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add JavaScript for preloader and animations -->
    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });

        // Animate book cards on scroll
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.book-card').forEach(card => {
            observer.observe(card);
        });

        function showLoginModal() {
            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
        }

        // Add hover effect to book cards
        document.querySelectorAll('.book-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add loading animation to images
        document.querySelectorAll('.card-img-top').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });
    </script>

    <!-- Footer -->
    <footer class="footer-custom mt-auto">
        <div class="container">
            <div class="row py-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h4>Eh-Perpus</h4>
                    <p>Platform perpustakaan digital untuk semua kalangan.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h4>Kontak</h4>
                    <p>Email: info@ehperpusno1.com</p>
                    <p>Telepon: 0821-1234-5678</p>
                </div>
                <div class="col-md-4">
                    <h4>Jam Operasional</h4>
                    <p>Senin - Jumat: 08:00 - 17:00</p>
                    <p>Sabtu: 09:00 - 15:00</p>
                </div>
            </div>
            <div class="footer-bottom text-center py-3">
                &copy; <?= date("Y") ?> Eh-Perpus. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>