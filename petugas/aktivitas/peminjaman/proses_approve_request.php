<?php
include '../../../config/controller.php';
session_start();
$id_petugas = $_SESSION['id']; // pastikan sudah login sebagai petugas
$id_request = $_GET['id_request'];
$action = $_GET['action'] ?? 'approve'; // Default to approve if not specified

// Ambil data request
$query = "SELECT * FROM request_peminjaman WHERE id_request = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $id_request);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$request = mysqli_fetch_assoc($result);

if (!$request) {
    header("Location: daftar_request_peminjaman.php?error=Request tidak ditemukan");
    exit;
}

if ($action === 'approve') {
    $id_siswa = $request['id_siswa'];
    $id_buku = $request['id_buku'];

    // Insert ke peminjaman
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime('+7 days'));
    $query = "INSERT INTO peminjaman (id_siswa, id_petugas, tgl_peminjaman, tgl_pengembalian, status_peminjaman) VALUES (?, ?, ?, ?, 'Dipinjam')";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "iiss", $id_siswa, $id_petugas, $tgl_pinjam, $tgl_kembali);
    mysqli_stmt_execute($stmt);
    $id_peminjaman = mysqli_insert_id($db);

    // Insert ke detail_peminjaman
    $query = "INSERT INTO detail_peminjaman (id_peminjaman, id_bukuV2, status_buku) VALUES (?, ?, 'dipinjam')";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_peminjaman, $id_buku);
    mysqli_stmt_execute($stmt);

    // Update status request
    $query = "UPDATE request_peminjaman SET status_request = 'approved' WHERE id_request = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_request);
    mysqli_stmt_execute($stmt);

    header("Location: daftar_request_peminjaman.php?msg=Request berhasil disetujui");
} else {
    // Reject request
    $query = "UPDATE request_peminjaman SET status_request = 'ditolak' WHERE id_request = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_request);
    mysqli_stmt_execute($stmt);

    header("Location: daftar_request_peminjaman.php?msg=Request berhasil ditolak");
}
?>