<?php
include('../../config/app.php');

session_start();
if ($_SESSION['level'] !== '1') {
    header("Location: ../../unauthorized.php");
    exit;
}

// Proses form submission
if (isset($_POST['tambah'])) {
    if (createBuku($_POST) > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            document.location.href = 'list.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
        </script>";
    }
}

// Ambil data untuk dropdown
$kategoriList = getAllKategori();
$penerbitList = getAllPenerbit();
$penulisList = getAllPenulis();
$rakList = getAllRak();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/styleLibrary.css">

    <style>
    .edit-akun-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .container-fluid {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .edit-card {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body class="edit-akun-page">
    <div class="container-fluid">
        <div class="edit-card mx-auto">
            <div class="edit-header">
                <h2>Tambah Buku</h2>
                <p>Tambahkan buku baru ke perpustakaan</p>
            </div>

            <form action="" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                <div class="row g-3">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="row g-3">
                            <!-- Judul -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="judul_buku" id="judul_buku" required
                                        pattern="[A-Za-z0-9\s.,!?():'\-]+"
                                        title="Judul boleh berisi huruf, angka, spasi, dan tanda baca" placeholder=" ">
                                    <label for="judul_buku">Judul Buku</label>
                                    <div class="invalid-feedback">Judul buku tidak boleh kosong</div>
                                </div>
                            </div>

                            <!-- Penerbit & Penulis -->
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="id_penerbit" id="id_penerbit" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Penerbit</option>
                                        <?php while ($penerbit = mysqli_fetch_assoc($penerbitList)): ?>
                                            <option value="<?= $penerbit['id_penerbit'] ?>"><?= $penerbit['nama_penerbit'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="id_penerbit">Penerbit</label>
                                    <div class="invalid-feedback">Silakan pilih penerbit</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="id_penulis" id="id_penulis" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Penulis</option>
                                        <?php while ($penulis = mysqli_fetch_assoc($penulisList)): ?>
                                            <option value="<?= $penulis['id_penulis'] ?>"><?= $penulis['nama_penulis'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="id_penulis">Penulis</label>
                                    <div class="invalid-feedback">Silakan pilih penulis</div>
                                </div>
                            </div>

                            <!-- Kategori & Rak -->
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="id_kat" id="id_kat" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($kat = mysqli_fetch_assoc($kategoriList)): ?>
                                            <option value="<?= $kat['id_kat'] ?>"><?= $kat['nama_kat'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="id_kat">Kategori</label>
                                    <div class="invalid-feedback">Silakan pilih kategori</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="id_rak" id="id_rak" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Rak</option>
                                        <?php while ($rak = mysqli_fetch_assoc($rakList)): ?>
                                            <option value="<?= $rak['id_rak'] ?>"><?= $rak['nama_rak'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="id_rak">Rak</label>
                                    <div class="invalid-feedback">Silakan pilih rak</div>
                                </div>
                            </div>

                            <!-- Stok & Tahun Terbit -->
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="stok" id="stok" required min="0" placeholder=" ">
                                    <label for="stok">Stok</label>
                                    <div class="invalid-feedback">Stok tidak boleh kosong dan harus berupa angka positif</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="tahun_terbit" id="tahun_terbit" required
                                        min="1900" max="<?= date('Y') ?>" placeholder=" ">
                                    <label for="tahun_terbit">Tahun Terbit</label>
                                    <div class="invalid-feedback">Tahun terbit tidak boleh kosong dan harus antara 1900 sampai <?= date('Y') ?></div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <select name="status" id="status" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Status</option>
                                        <option value="tersedia">Tersedia</option>
                                        <option value="tidak tersedia">Tidak Tersedia</option>
                                    </select>
                                    <label for="status">Status</label>
                                    <div class="invalid-feedback">Silakan pilih status</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="row g-3">
                            <!-- Deskripsi -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="deskripsi_buku" id="deskripsi_buku" style="height: 150px" placeholder=" "></textarea>
                                    <label for="deskripsi_buku">Deskripsi</label>
                                </div>
                            </div>

                            <!-- Cover Upload -->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="cover" class="form-label">Cover Buku</label>
                                    <input type="file" name="cover" id="cover" class="form-control" accept="image/*" required placeholder=" ">
                                    <div class="invalid-feedback">Silakan pilih file cover buku</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" name="tambah" class="btn btn-update flex-grow-1">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Buku
                    </button>
                    <a href="list.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form Validation Script -->
    <script>
        // Form validation
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>