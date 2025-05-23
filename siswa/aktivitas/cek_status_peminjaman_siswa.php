<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== '3') {
    header("Location: ../../login.php");
    exit();
}

include('../../config/controller.php');
$id_siswa = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman - PerpusKu</title>
    <link href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .status-card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .status-pending {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }
        .status-proses {
            background-color: #cce5ff;
            border-left: 4px solid #0d6efd;
        }
        .status-tolak {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .status-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .back-button {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="back-button">
            <a href="../dashboard.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <h2 class="mb-4">
            <i class="fas fa-history"></i> Status Request Peminjaman
        </h2>

        <?php
        $query = "SELECT r.*, b.judul_buku 
                 FROM request_peminjaman r 
                 JOIN bukuV2 b ON r.id_buku = b.id_bukuV2 
                 WHERE r.id_siswa = ? 
                 ORDER BY r.tanggal_request DESC";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_siswa);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $status_class = '';
                $status_icon = '';
                $pesan = '';
                
                switch($row['status_request']) {
                    case 'pending':
                        $status_class = 'status-pending';
                        $status_icon = 'fa-clock';
                        $pesan = 'Menunggu diproses oleh petugas';
                        break;
                    case 'diproses':
                        $status_class = 'status-proses';
                        $status_icon = 'fa-spinner fa-spin';
                        $pesan = 'Sedang diproses oleh petugas';
                        break;
                    case 'ditolak':
                        $status_class = 'status-tolak';
                        $status_icon = 'fa-times-circle';
                        $pesan = 'Ditolak karena buku tidak tersedia';
                        break;
                }
                ?>
                <div class="card status-card <?php echo $status_class; ?>">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas <?php echo $status_icon; ?> status-icon"></i>
                            <h5 class="card-title mb-0"><?php echo $row['judul_buku']; ?></h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Tanggal Request: <?php echo date('d/m/Y H:i', strtotime($row['tanggal_request'])); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Status: <?php echo ucfirst($row['status_request']); ?>
                                </p>
                            </div>
                        </div>
                        <p class="mb-0 mt-2">
                            <i class="fas fa-comment-alt me-2"></i>
                            <?php echo $pesan; ?>
                        </p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada request peminjaman yang dibuat.
                  </div>';
        }
        ?>
    </div>

    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
