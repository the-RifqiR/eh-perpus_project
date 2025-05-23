<?php
include('../../config/controller.php');

session_start();
if ($_SESSION['level'] !== '1') {
    header("Location: ../../unauthorized.php");
    exit;
}

// Ambil data buku jika ada ID
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Dapatkan data buku berdasarkan ID
    $result = getAllBuku($id);
    
    // Cek apakah data ditemukan
    if (!empty($result)) {
        $buku = $result[0];
    } else {
        // Redirect jika data tidak ditemukan
        echo "<script>
            alert('Data tidak ditemukan!');
            document.location.href='list.php';
        </script>";
        exit;
    }
}

// Ambil data untuk dropdown
$penerbitList = getAllPenerbit();
$penulisList = getAllPenulis();
$kategoriList = getAllKategori();
$rakList = getAllRak();

// Proses update
if (isset($_POST['update'])) {
    // Debug: Tampilkan data POST
    // echo '<pre>'; print_r($_POST); echo '</pre>'; die();

    $result = updateBuku($_POST);
    if ($result) {
        echo "<script>
            alert('Data Berhasil Diubah');
            document.location.href='list.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Gagal Diubah. Error: " . mysqli_error($db) . "');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/styleLibrary.css">

    
    <style>
        /*Menghilangkan scroll yang tidak perlu */
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

<body class="edit-buku-page">
    <div class="container-fluid">
        <div class="edit-card mx-auto">
            <div class="edit-header">
                <h2>Edit Buku</h2>
                <p>Perbarui informasi buku</p>
            </div>

            <form method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                <input type="hidden" name="id_bukuV2" value="<?= $buku['id_bukuV2'] ?>">

                <div class="row g-3">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="row g-3">
                            <!-- Judul -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="judul_buku" id="judul_buku"
                                        value="<?= $buku['judul_buku'] ?>" required
                                        pattern="[A-Za-z0-9\s.,!?():'\-]+"
                                        title="Judul boleh berisi huruf, angka, spasi, dan tanda baca" placeholder=" ">
                                    <label for="judul_buku">Judul Buku</label>
                                    <div class="invalid-feedback">Judul buku tidak boleh kosong</div>
                                </div>
                            </div>

                            <!-- Penerbit & Penulis -->
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="penerbit" id="penerbit" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Penerbit</option>
                                        <?php while ($p = mysqli_fetch_assoc($penerbitList)) : ?>
                                            <option value="<?= $p['id_penerbit'] ?>"
                                                <?= $p['id_penerbit'] == $buku['id_penerbit'] ? 'selected' : '' ?>>
                                                <?= $p['nama_penerbit'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="penerbit">Penerbit</label>
                                    <div class="invalid-feedback">Silakan pilih penerbit</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="penulis" id="penulis" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Penulis</option>
                                        <?php while ($p = mysqli_fetch_assoc($penulisList)) : ?>
                                            <option value="<?= $p['id_penulis'] ?>"
                                                <?= $p['id_penulis'] == $buku['id_penulis'] ? 'selected' : '' ?>>
                                                <?= $p['nama_penulis'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="penulis">Penulis</label>
                                    <div class="invalid-feedback">Silakan pilih penulis</div>
                                </div>
                            </div>

                            <!-- Kategori & Rak -->
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="kategori" id="kategori" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($k = mysqli_fetch_assoc($kategoriList)) : ?>
                                            <option value="<?= $k['id_kat'] ?>"
                                                <?= $k['id_kat'] == $buku['id_kat'] ? 'selected' : '' ?>>
                                                <?= $k['nama_kat'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="kategori">Kategori</label>
                                    <div class="invalid-feedback">Silakan pilih kategori</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <select name="rak" id="rak" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Rak</option>
                                        <?php while ($r = mysqli_fetch_assoc($rakList)) : ?>
                                            <option value="<?= $r['id_rak'] ?>"
                                                <?= $r['id_rak'] == $buku['id_rak'] ? 'selected' : '' ?>>
                                                <?= $r['nama_rak'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="rak">Rak</label>
                                    <div class="invalid-feedback">Silakan pilih rak</div>
                                </div>
                            </div>

                            <!-- Stok & Tahun Terbit -->
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="stok" id="stok"
                                        value="<?= $buku['stok'] ?>" required min="0">
                                    <label for="stok">Stok</label>
                                    <div class="invalid-feedback">Stok tidak boleh kosong dan harus berupa angka positif</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="tahun_terbit" id="tahun_terbit"
                                        value="<?= $buku['thn_terbit'] ?>" required
                                        min="1900" max="<?= date('Y') ?>">
                                    <label for="tahun_terbit">Tahun Terbit</label>
                                    <div class="invalid-feedback">Tahun terbit tidak boleh kosong dan harus antara 1900 sampai <?= date('Y') ?></div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <select name="status" id="status" class="form-select" required placeholder=" ">
                                        <option value="">Pilih Status</option>
                                        <option value="tersedia" <?= $buku['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                        <option value="tidak tersedia" <?= $buku['status'] == 'tidak tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
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
                                    <textarea class="form-control" name="deskripsi_buku" id="deskripsi_buku" style="height: 150px"><?= $buku['deskripsi_buku'] ?></textarea>
                                    <label for="deskripsi_buku">Deskripsi</label>
                                </div>
                            </div>

                            <!-- Cover Upload -->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="cover" class="form-label">Cover Buku</label>
                                    <input type="file" name="cover" id="cover" class="form-control" accept="image/*">
                                    <?php if (!empty($buku['cover'])) : ?>
                                        <div class="mt-2">
                                            <img src="../uploads/<?= $buku['cover'] ?>" width="100" class="img-thumbnail">
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="cover_lama" value="<?= $buku['cover'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" name="update" class="btn btn-update flex-grow-1">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
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