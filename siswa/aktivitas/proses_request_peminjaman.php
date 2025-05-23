<?php
include '../../config/controller.php';
session_start();
$id_siswa = $_SESSION['id']; // pastikan sudah login sebagai siswa
$id_buku = $_POST['id_buku'];
$catatan = $_POST['catatan_siswa'];

$query = "INSERT INTO request_peminjaman (id_siswa, id_buku, catatan_siswa, status_request) VALUES (?, ?, ?, 'pending')";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "iis", $id_siswa, $id_buku, $catatan);
mysqli_stmt_execute($stmt);

header("Location: ../dashboard.php?msg=Request berhasil dikirim");
?>