<?php
include '../../config/controller.php';
session_start();
$id_siswa = $_SESSION['id']; // pastikan sudah login sebagai siswa

$query = mysqli_query($db, "SELECT name FROM login WHERE id = '$id_siswa'");
$data = mysqli_fetch_assoc($query);
$nama_siswa = $data['name'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Peminjaman - PerpusKu</title>

    <!-- Bootstrap CSS -->
    <link href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="../../assets/styleLibrary.css" rel="stylesheet">
    <style>
        .readonly-tooltip {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .readonly-tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .readonly-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>

<body class="edit-akun-page">
    <div class="container-fluid">
        <div class="edit-card">
            <div class="edit-header">
                <h2>Request Peminjaman</h2>
                <p>Pilih buku yang ingin dipinjam</p>
            </div>

            <form action="proses_request_peminjaman.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="id_siswa" value="<?= $id_siswa ?>">
                
                <div class="form-floating mb-3">
                    <div class="readonly-tooltip">
                        <label>Nama Siswa</label>      
                        <input type="text" class="form-control" value="<?= htmlspecialchars($nama_siswa) ?>" readonly>
                        <span class="tooltip-text">Data ini tidak dapat diubah</span>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <select name="id_buku" class="form-select" required>
                        <option value="">Pilih Buku</option>
                        <?php
                        $buku = mysqli_query($db, "SELECT id_bukuV2, judul_buku FROM bukuV2 WHERE status='tersedia'");
                        while ($row = mysqli_fetch_assoc($buku)) {
                            echo "<option value='{$row['id_bukuV2']}'>{$row['judul_buku']}</option>";
                        }
                        ?>
                    </select>
                    <label for="id_buku">Pilih Buku</label>
                    <div class="invalid-feedback">Silakan pilih buku</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="catatan_siswa" id="catatan_siswa" placeholder="Catatan (opsional)">
                    <label for="catatan_siswa">Catatan (opsional)</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-update">
                        <i class="bi bi-plus-circle me-2"></i>Request Pinjam
                    </button>
                    <a href="../dashboard.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form Validation Script -->
    <script>
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