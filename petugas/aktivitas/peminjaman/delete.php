<?php
include('../../../config/controller.php');

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit;
}

$id_peminjaman = $_GET['id'];

// Proses hapus data
if (hapusPeminjaman($id_peminjaman)) {
    header("Location: list.php?delete=success");
} else {
    header("Location: list.php?delete=error");
}
exit;
