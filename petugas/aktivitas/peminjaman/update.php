<?php
include('../../../config/controller.php');

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit;
}

$id_peminjaman = $_GET['id'];

// Ambil data peminjaman menggunakan function yang sudah ada
$query = "SELECT p.*, 
          s.name as nama_siswa,
          pt.name as nama_petugas,
          GROUP_CONCAT(b.judul_buku SEPARATOR ', ') as buku_dipinjam
          FROM peminjaman p
          JOIN login s ON p.id_siswa = s.id
          JOIN login pt ON p.id_petugas = pt.id
          JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
          JOIN bukuV2 b ON dp.id_bukuV2 = b.id_bukuV2
          WHERE p.id_peminjaman = $id_peminjaman
          GROUP BY p.id_peminjaman";

$result = mysqli_query($db, $query);
$data = mysqli_fetch_assoc($result);

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    
    if (updateTanggalPengembalian($id_peminjaman, $tgl_pengembalian)) {
        echo "<script>
            alert('Data berhasil diupdate!');
            document.location.href='list.php?update=success';
        </script>";
    } else {
        $error = "Gagal mengupdate data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Peminjaman - Perpustakaan</title>
    
    <!-- Bootstrap CSS -->
    <link href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link href="../../../assets/styleLibrary.css" rel="stylesheet">

    <style>
        .edit-peminjaman-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .edit-card {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
            opacity: 0.8;
        }

        .form-control[readonly]:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .readonly-tooltip {
            position: relative;
            display: inline-block;
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
<body class="edit-peminjaman-page">
    <div class="container">
        <div class="edit-card mx-auto">
            <div class="edit-header mb-4">
                <h2>Update Peminjaman</h2>
                <p>Perbarui tanggal pengembalian buku</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label">Nama Siswa</label>
                    <div class="readonly-tooltip">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama_siswa']) ?>" readonly>
                        <span class="tooltip-text">Data ini tidak dapat diubah</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Nama Petugas</label>
                    <div class="readonly-tooltip">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama_petugas']) ?>" readonly>
                        <span class="tooltip-text">Data ini tidak dapat diubah</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <div class="readonly-tooltip">
                        <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($data['tgl_peminjaman'])) ?>" readonly>
                        <span class="tooltip-text">Data ini tidak dapat diubah</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="tgl_pengembalian" class="form-label">Tanggal Pengembalian</label>
                    <input type="date" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian" 
                           value="<?= date('Y-m-d', strtotime($data['tgl_pengembalian'])) ?>" required>
                    <div class="invalid-feedback">Tanggal pengembalian harus diisi</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Buku yang Dipinjam</label>
                    <div class="readonly-tooltip">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($data['buku_dipinjam']) ?>" readonly>
                        <span class="tooltip-text">Data ini tidak dapat diubah</span>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-update flex-grow-1">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                    </button>
                    <a href="list.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

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

        // Prevent interaction with readonly inputs
        document.querySelectorAll('input[readonly]').forEach(input => {
            input.addEventListener('click', function(e) {
                e.preventDefault();
                this.blur();
            });
        });
    </script>
</body>
</html>
