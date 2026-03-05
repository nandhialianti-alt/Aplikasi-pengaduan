<?php
session_start();
require_once 'config/database.php';
require_once 'includes/notification_model.php';

if (isset($_SESSION['user_id'])) {
    add_notification($_SESSION['user_id'], "Anda telah keluar dari sistem.", "logout");
}

session_destroy();
header("Location: login.php");
exit();
?>
