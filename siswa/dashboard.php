<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== '3') {
    header("Location: ../login.php");
    exit();
}

include('../config/controller.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - PerpusKu</title>

    <!-- Bootstrap CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets/styleDashboard.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-book-open me-2" style="font-size: 1.5rem;"></i>
                <span class="fw-bold" style="font-size: 1.4rem; letter-spacing: 0.5px;">PerpusKu</span>
            </a>

            <!-- Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>


            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Menu Kategori -->
                <ul class="navbar-nav me-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-th-list me-1"></i> Kategori
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Semua Kategori</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <?php
                            $kategori = getAllKategori();
                            while ($row = mysqli_fetch_assoc($kategori)) {
                                echo "<li><a class='dropdown-item' href='?kategori=" . $row['id_kat'] . "'>" . $row['nama_kat'] . "</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                </ul>

                <!-- Search Bar (centered) -->
                <div class="navbar-search mx-auto">
                    <i class="fas fa-search search-icon"></i>
                    <input type="search" class="search-input" placeholder="Cari buku..." aria-label="Search">
                </div>

                <!-- Nav Items Kanan (Aktivitas, Keranjang, Akun) -->
                <div class="d-flex align-items-center ms-auto gap-2">
                    <!-- Aktivitas Dropdown -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="aktivitasDropdown" role="button" data-bs-toggle="dropdown">
                                Aktivitas Saya
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="aktivitas/request_peminjaman.php">Peminjaman</a></li>
                                <li><a class="dropdown-item" href="aktivitas/cek_status_peminjaman_siswa.php">Status Peminjaman</a></li>
                                <li><a class="dropdown-item" href="../index.php">Pengembalian</a></li>
                                <li><a class="dropdown-item" href="../admin/dashboard.php">Riwayat</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Cart Button -->
                    <a href="keranjang.php" class="btn btn-outline-light">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                    <!-- Account Dropdown -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> Akun
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                                <li><a class="dropdown-item" href="../index.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Daftar Buku Tersedia</h1>
            <p class="page-description">Jelajahi koleksi buku perpustakaan kami. Gunakan filter untuk menemukan buku yang Anda inginkan.</p>
        </div>

        <!-- Popular Books Section -->
        <div class="popular-books mb-4">
            <h3 class="section-title mb-3">
                <i class="fas fa-star text-warning me-2"></i>Buku Terpopuler
            </h3>
            <div class="row g-4">
                <?php
                // Query untuk mendapatkan buku terpopuler berdasarkan jumlah peminjaman
                $query_popular = "SELECT b.*, 
                                p.nama_penerbit,
                                pl.nama_penulis,
                                k.nama_kat,
                                COUNT(dp.id_bukuV2) as total_pinjam 
                                FROM bukuV2 b 
                                LEFT JOIN penerbit p ON b.id_penerbit = p.id_penerbit
                                LEFT JOIN penulis pl ON b.id_penulis = pl.id_penulis
                                LEFT JOIN kategori k ON b.id_kat = k.id_kat
                                LEFT JOIN detail_peminjaman dp ON b.id_bukuV2 = dp.id_bukuV2 
                                WHERE b.status = 'tersedia' 
                                GROUP BY b.id_bukuV2 
                                ORDER BY total_pinjam DESC 
                                LIMIT 4";
                $popular_books = mysqli_query($db, $query_popular);
                while ($row = mysqli_fetch_assoc($popular_books)) {
                    $stok = $row['stok'];
                    $badgeClass = $stok > 0 ? 'badge-status available' : 'badge-status borrowed';
                    $badgeText = $stok > 0 ? 'Tersedia' : 'Habis';
                ?>
                    <div class="col-md-3">
                        <div class="card book-card h-100">
                            <div class="position-relative">
                                <img src="../admin/uploads/<?php echo $row['cover']; ?>" class="card-img-top" alt="<?php echo $row['judul_buku']; ?>">
                                <span class="badge-status <?php echo $badgeClass; ?> position-absolute top-0 end-0 m-2">
                                    <i class="fas <?php echo $stok > 0 ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                    <?php echo $badgeText; ?>
                                </span>
                                <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                    <i class="fas fa-star me-1"></i>Populer
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-truncate" title="<?php echo $row['judul_buku']; ?>"><?php echo $row['judul_buku']; ?></h5>
                                <p class="card-text text-muted mb-2">
                                    <small><i class="fas fa-user-edit me-1"></i> <?php echo $row['nama_penulis'] ?? 'Tidak ada penulis'; ?></small>
                                </p>
                                <p class="card-text text-muted mb-2">
                                    <small><i class="fas fa-building me-1"></i> <?php echo $row['nama_penerbit'] ?? 'Tidak ada penerbit'; ?></small>
                                </p>
                                <p class="card-text text-muted mb-3">
                                    <small><i class="fas fa-bookmark me-1"></i> <?php echo $row['nama_kat'] ?? 'Tidak ada kategori'; ?></small>
                                </p>
                                <?php if ($stok > 0) { ?>
                                    <button class="btn btn-gold w-100" onclick="requestBook(<?php echo $row['id_bukuV2']; ?>)">
                                        <i class="fas fa-cart-plus me-2"></i>Pinjam
                                    </button>
                                <?php } else { ?>
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-ban me-2"></i>Stok Habis
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" id="kategoriFilter">
                        <option value="">Semua Kategori</option>
                        <?php
                        $kategori = getAllKategori();
                        while ($row = mysqli_fetch_assoc($kategori)) {
                            echo "<option value='" . $row['id_kat'] . "'>" . $row['nama_kat'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="penerbitFilter">
                        <option value="">Semua Penerbit</option>
                        <?php
                        $penerbit = getAllPenerbit();
                        while ($row = mysqli_fetch_assoc($penerbit)) {
                            echo "<option value='" . $row['id_penerbit'] . "'>" . $row['nama_penerbit'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="penulisFilter" placeholder="Cari berdasarkan penulis...">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="judulFilter" placeholder="Cari berdasarkan judul...">
                </div>
            </div>
        </div>

        <!-- Book List Section -->
        <div class="row g-4" id="bookList">
            <?php
            $buku = getAllBuku();
            foreach ($buku as $row) {
                $stok = $row['stok'];
                $badgeClass = $stok > 0 ? 'badge-status available' : 'badge-status borrowed';
                $badgeText = $stok > 0 ? 'Tersedia' : 'Habis';
            ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card book-card h-100">
                        <div class="position-relative">
                            <img src="../admin/uploads/<?php echo $row['cover']; ?>" class="card-img-top" alt="<?php echo $row['judul_buku']; ?>">
                            <span class="badge-status <?php echo $badgeClass; ?> position-absolute top-0 end-0 m-2">
                                <i class="fas <?php echo $stok > 0 ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                <?php echo $badgeText; ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="<?php echo $row['judul_buku']; ?>"><?php echo $row['judul_buku']; ?></h5>
                            <p class="card-text text-muted mb-2">
                                <small><i class="fas fa-user-edit me-1"></i> <?php echo $row['nama_penulis'] ?? 'Tidak ada penulis'; ?></small>
                            </p>
                            <p class="card-text text-muted mb-2">
                                <small><i class="fas fa-building me-1"></i> <?php echo $row['nama_penerbit'] ?? 'Tidak ada penerbit'; ?></small>
                            </p>
                            <p class="card-text text-muted mb-2">
                                <small><i class="fas fa-bookmark me-1"></i> <?php echo $row['nama_kat'] ?? 'Tidak ada kategori'; ?></small>
                            </p>
                            <p class="card-text text-muted mb-3">
                                <small><i class="fas fa-box me-1"></i> Stok: <?php echo $row['stok']; ?> buku</small>
                            </p>
                            <?php if ($stok > 0) { ?>
                                <button class="btn btn-gold w-100" onclick="requestBook(<?php echo $row['id_bukuV2']; ?>)">
                                    <i class="fas fa-cart-plus me-2"></i>Pinjam
                                </button>
                            <?php } else { ?>
                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="fas fa-ban me-2"></i>Stok Habis
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Add JavaScript for filtering and book request -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filters = {
                kategori: document.getElementById('kategoriFilter'),
                penerbit: document.getElementById('penerbitFilter'),
                penulis: document.getElementById('penulisFilter'),
                judul: document.getElementById('judulFilter')
            };

            // Add event listeners to all filters
            Object.values(filters).forEach(filter => {
                filter.addEventListener('input', filterBooks);
            });

            function filterBooks() {
                const bookCards = document.querySelectorAll('.book-card');
                const filterValues = {
                    kategori: filters.kategori.value.toLowerCase(),
                    penerbit: filters.penerbit.value.toLowerCase(),
                    penulis: filters.penulis.value.toLowerCase(),
                    judul: filters.judul.value.toLowerCase()
                };

                bookCards.forEach(card => {
                    const cardKategori = card.querySelector('.fa-bookmark').nextSibling.textContent.trim().toLowerCase();
                    const cardPenerbit = card.querySelector('.fa-building').nextSibling.textContent.trim().toLowerCase();
                    const cardPenulis = card.querySelector('.fa-user-edit').nextSibling.textContent.trim().toLowerCase();
                    const cardJudul = card.querySelector('.card-title').textContent.trim().toLowerCase();

                    const matches = (
                        (!filterValues.kategori || cardKategori === filterValues.kategori) &&
                        (!filterValues.penerbit || cardPenerbit === filterValues.penerbit) &&
                        (!filterValues.penulis || cardPenulis.includes(filterValues.penulis)) &&
                        (!filterValues.judul || cardJudul.includes(filterValues.judul))
                    );

                    // Tampilkan/sembunyikan card berdasarkan filter
                    const cardContainer = card.closest('.col-md-4, .col-md-3');
                    if (cardContainer) {
                        cardContainer.style.display = matches ? 'block' : 'none';
                    }
                });

                // Tampilkan pesan jika tidak ada hasil
                const visibleCards = document.querySelectorAll('.book-card').length;
                const totalCards = document.querySelectorAll('.book-card').length;
                const noResultsMessage = document.getElementById('noResultsMessage');
                
                if (visibleCards === 0) {
                    if (!noResultsMessage) {
                        const message = document.createElement('div');
                        message.id = 'noResultsMessage';
                        message.className = 'alert alert-info text-center mt-4';
                        message.innerHTML = '<i class="fas fa-info-circle me-2"></i>Tidak ada buku yang sesuai dengan filter yang dipilih';
                        document.getElementById('bookList').appendChild(message);
                    }
                } else {
                    if (noResultsMessage) {
                        noResultsMessage.remove();
                    }
                }
            }

            // Tambahkan event listener untuk search bar
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase();
                    const bookCards = document.querySelectorAll('.book-card');
                    
                    bookCards.forEach(card => {
                        const cardTitle = card.querySelector('.card-title').textContent.toLowerCase();
                        const cardAuthor = card.querySelector('.fa-user-edit').nextSibling.textContent.toLowerCase();
                        const cardPublisher = card.querySelector('.fa-building').nextSibling.textContent.toLowerCase();
                        const cardCategory = card.querySelector('.fa-bookmark').nextSibling.textContent.toLowerCase();
                        
                        const matches = 
                            cardTitle.includes(searchValue) ||
                            cardAuthor.includes(searchValue) ||
                            cardPublisher.includes(searchValue) ||
                            cardCategory.includes(searchValue);
                        
                        const cardContainer = card.closest('.col-md-4, .col-md-3');
                        if (cardContainer) {
                            cardContainer.style.display = matches ? 'block' : 'none';
                        }
                    });
                });
            }
        });

        function requestBook(bookId) {
            // Create form dynamically
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'aktivitas/request_peminjaman.php';

            // Add hidden input for book ID
            const bookInput = document.createElement('input');
            bookInput.type = 'hidden';
            bookInput.name = 'id_buku';
            bookInput.value = bookId;

            // Add form to document and submit
            form.appendChild(bookInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Footer -->
    <footer class="footer-custom mt-auto">
        <div class="container">
            <div class="row py-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h4>PerpusKu</h4>
                    <p>Platform perpustakaan digital untuk semua kalangan.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h4>Kontak</h4>
                    <p>Email: info@perpusku.com</p>
                    <p>Telepon: 0821-1234-5678</p>
                </div>
                <div class="col-md-4">
                    <h4>Jam Operasional</h4>
                    <p>Senin - Jumat: 08:00 - 17:00</p>
                    <p>Sabtu: 09:00 - 15:00</p>
                </div>
            </div>
            <div class="footer-bottom text-center py-3">
                &copy; <?= date("Y") ?> PerpusKu. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>