<?php
include('../../../config/controller.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $tgl_dikembalikan = $_POST['tgl_dikembalikan'];
    $status_buku = $_POST['status_buku'];
    $denda = $_POST['denda'];

    // Start transaction
    mysqli_begin_transaction($db);

    try {
        // Update peminjaman table
        $query_peminjaman = "UPDATE peminjaman 
                            SET tgl_dikembalikan = ?, 
                                denda = ? 
                            WHERE id_peminjaman = ?";
        
        $stmt_peminjaman = mysqli_prepare($db, $query_peminjaman);
        mysqli_stmt_bind_param($stmt_peminjaman, "sii", $tgl_dikembalikan, $denda, $id_peminjaman);
        mysqli_stmt_execute($stmt_peminjaman);

        // Update detail_peminjaman table
        $query_detail = "UPDATE detail_peminjaman 
                        SET status_buku = ? 
                        WHERE id_peminjaman = ?";
        
        $stmt_detail = mysqli_prepare($db, $query_detail);
        mysqli_stmt_bind_param($stmt_detail, "si", $status_buku, $id_peminjaman);
        mysqli_stmt_execute($stmt_detail);

        // If status is 'dikembalikan', update book stock
        if ($status_buku === 'dikembalikan') {
            $query_update_stock = "UPDATE bukuV2 b 
                                 JOIN detail_peminjaman dp ON b.id_bukuV2 = dp.id_bukuV2 
                                 SET b.stok = b.stok + 1 
                                 WHERE dp.id_peminjaman = ?";
            
            $stmt_stock = mysqli_prepare($db, $query_update_stock);
            mysqli_stmt_bind_param($stmt_stock, "i", $id_peminjaman);
            mysqli_stmt_execute($stmt_stock);
        }

        // Commit transaction
        mysqli_commit($db);

        // Redirect with success message
        header("Location: list.php?return=success");
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($db);
        
        // Redirect with error message
        header("Location: list.php?return=error");
        exit();
    }
} else {
    // If not POST request, redirect to list
    header("Location: list.php");
    exit();
}
?> 