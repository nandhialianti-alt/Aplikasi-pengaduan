<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/notification_model.php';

check_login();

$role = $_SESSION['role'];

if ($role === 'admin') {
    include 'modules/admin/dashboard.php';
} else {
    include 'modules/siswa/dashboard.php';
}
?>
