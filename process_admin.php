<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

check_login();
check_role('admin');

if (isset($_POST['update_status'])) {
    $id = (int)$_POST['id_aspirasi'];
    $status = sanitize($_POST['status']);

    $query = "UPDATE aspirasi SET status = '$status' WHERE id_aspirasi = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: detail_aspirasi.php?id=$id&msg=Status+updated");
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

if (isset($_POST['submit_feedback'])) {
    $id = (int)$_POST['id_aspirasi'];
    $balasan = sanitize($_POST['balasan']);
    $tanggal = date('Y-m-d H:i:s');

    $query = "INSERT INTO umpan_balik (id_aspirasi, balasan, tanggal) VALUES ($id, '$balasan', '$tanggal')";
    if (mysqli_query($conn, $query)) {
        header("Location: detail_aspirasi.php?id=$id&msg=Feedback+sent");
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>
