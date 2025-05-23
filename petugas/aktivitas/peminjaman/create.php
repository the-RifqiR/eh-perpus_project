<?php
include('../../../config/controller.php');

if (isset($_GET['id_request'])) {
    $id_request = $_GET['id_request'];
    $query = "SELECT r.*, l.name, b.judul_buku, b.id_bukuV2 
              FROM request_peminjaman r
              JOIN login l ON r.id_siswa = l.id
              JOIN bukuV2 b ON r.id_buku = b.id_bukuV2
              WHERE r.id_request = $id_request";
    $result = mysqli_query($db, $query);
    $request = mysqli_fetch_assoc($result);

    $prefill_id_siswa = $request['id_siswa'];
    $prefill_nama_siswa = $request['name'];
    $prefill_id_buku = $request['id_bukuV2'];
    $prefill_judul_buku = $request['judul_buku'];
}

// Ambil data siswa
$siswa = mysqli_query($db, "SELECT id, name FROM login WHERE level = 3 AND status = 1");

// Ambil data petugas
$petugas = mysqli_query($db, "SELECT id, name FROM login WHERE level = 2 AND status = 1");

// Ambil data buku yang tersedia
$buku = mysqli_query($db, "SELECT id_bukuV2, judul_buku FROM bukuV2 WHERE status = 'tersedia'");

// Proses form
if (isset($_POST['tambah'])) {
    $id_siswa = $_POST['id_siswa'];
    $id_petugas = $_POST['id_petugas'];
    $tgl_peminjaman = $_POST['tgl_peminjaman'];
    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    $buku_list = $_POST['buku'];

    // Validasi tanggal
    if (strtotime($tgl_peminjaman) > strtotime($tgl_pengembalian)) {
        echo "<script>
                alert('Tanggal pengembalian harus lebih besar dari tanggal peminjaman!');
                window.location.href = 'create.php';
              </script>";
        exit;
    }

    $result = simpanPeminjaman($db, $id_siswa, $id_petugas, $tgl_peminjaman, $tgl_pengembalian, $buku_list);
    if (isset($_GET['id_request'])) {
        $id_request = $_GET['id_request'];
        mysqli_query($db, "UPDATE request_peminjaman SET status_request = 'approved' WHERE id_request = $id_request");
    }

    if ($result) {
        echo "<script>
                alert('Data peminjaman berhasil disimpan!');
                window.location.href = 'list.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan data!');
                window.location.href = 'create.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman - Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="../../../node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../../assets/stylePetugas.css">
</head>

<body class="edit-akun-page">
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
        <div class="edit-card" style="max-width: 800px; width: 100%;">
            <div class="edit-header">
                <h2>Tambah Peminjaman</h2>
                <p>Tambahkan data peminjaman baru</p>
            </div>

            <form action="" method="POST" class="needs-validation" novalidate>
                <?php if (isset($prefill_id_siswa)): ?>
                    <input type="hidden" name="id_siswa" value="<?= $prefill_id_siswa ?>">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="<?= $prefill_nama_siswa ?>" readonly>
                        <label>Nama Siswa</label>
                    </div>
                <?php else: ?>
                    <div class="form-floating mb-3">
                        <select name="id_siswa" id="id_siswa" class="form-select" required>
                            <option value="">Pilih Siswa</option>
                            <?php while ($row = mysqli_fetch_assoc($siswa)): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label for="id_siswa">Pilih Siswa</label>
                        <div class="invalid-feedback">Silakan pilih siswa</div>
                    </div>
                <?php endif; ?>

                <div class="form-floating mb-3">
                    <select name="id_petugas" id="id_petugas" class="form-select" required placeholder=" ">
                        <option value="">Pilih Petugas</option>
                        <?php while ($row = mysqli_fetch_assoc($petugas)): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label for="id_petugas">Pilih Petugas</label>
                    <div class="invalid-feedback">
                        Silakan pilih petugas
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="tgl_peminjaman" name="tgl_peminjaman"
                                value="<?= date('Y-m-d') ?>" required placeholder=" ">
                            <label for="tgl_peminjaman">Tanggal Peminjaman</label>
                            <div class="invalid-feedback">
                                Tanggal peminjaman harus diisi
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian"
                                min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required placeholder=" ">
                            <label for="tgl_pengembalian">Tanggal Pengembalian</label>
                            <div class="invalid-feedback">
                                Tanggal pengembalian harus diisi
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (isset($prefill_id_buku)): ?>
                    <input type="hidden" name="buku[]" value="<?= $prefill_id_buku ?>">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="<?= $prefill_judul_buku ?>" readonly>
                        <label>Buku</label>
                    </div>
                <?php else: ?>
                    <div class="mb-4">
                        <label class="form-label">Pilih Buku</label>
                        <div class="buku-checkbox-group">
                            <?php while ($row = mysqli_fetch_assoc($buku)): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="buku[]" value="<?= $row['id_bukuV2'] ?>" id="buku_<?= $row['id_bukuV2'] ?>">
                                    <label class="form-check-label" for="buku_<?= $row['id_bukuV2'] ?>">
                                        <?= $row['judul_buku'] ?>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="invalid-feedback">Pilih minimal satu buku</div>
                    </div>
                <?php endif; ?>

                <div class="d-grid gap-2">
                    <button type="submit" name="tambah" class="btn btn-update">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Peminjaman
                    </button>
                    <a href="list.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form Validation Script -->
    <script>
        // Form validation
        (function() {
            'use strict'
            let forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        // Validasi tanggal
                        let tglPeminjaman = new Date(document.getElementById('tgl_peminjaman').value);
                        let tglPengembalian = new Date(document.getElementById('tgl_pengembalian').value);

                        if (tglPengembalian <= tglPeminjaman) {
                            event.preventDefault();
                            alert('Tanggal pengembalian harus lebih besar dari tanggal peminjaman!');
                            return;
                        }

                        // Validasi checkbox buku (hanya jika tidak prefill)
                        let bukuHidden = document.querySelector('input[type="hidden"][name="buku[]"]');
                        if (!bukuHidden) {
                            let bukuCheckboxes = document.querySelectorAll('input[name="buku[]"]:checked');
                            if (bukuCheckboxes.length === 0) {
                                event.preventDefault();
                                alert('Pilih minimal satu buku!');
                                return;
                            }
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Set minimum date for return date based on loan date
        document.getElementById('tgl_peminjaman').addEventListener('change', function() {
            let minDate = new Date(this.value);
            minDate.setDate(minDate.getDate() + 1);
            document.getElementById('tgl_pengembalian').min = minDate.toISOString().split('T')[0];
        });
    </script>
</body>

</html>