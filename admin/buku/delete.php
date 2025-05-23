<?php

include '../../config/app.php';

session_start();
if ($_SESSION['level'] !== '1') {
    header("Location: ../../unauthorized.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    if (deleteBuku($id)) {
        // Redirect dengan parameter delete=success
        header("Location: list.php?delete=success");
    } else {
        // Redirect dengan parameter delete=error
        header("Location: list.php?delete=error");
    }
    exit;
}