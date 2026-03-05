<?php
// includes/functions.php

/**
 * Redirect utility
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Sanitize input
 */
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
}

/**
 * Check if user is logged in
 */
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

/**
 * Check if user has specific role
 */
function check_role($expected_role) {
    if ($_SESSION['role'] !== $expected_role) {
        // Simple error handling for access violation
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location.href='index.php';</script>";
        exit();
    }
}

/**
 * Format date for display
 */
function format_date($date) {
    return date('d M Y H:i', strtotime($date));
}

/**
 * Get status badge class
 */
function get_status_class($status) {
    switch ($status) {
        case 'baru': return 'bg-danger';
        case 'diproses': return 'bg-warning text-dark';
        case 'selesai': return 'bg-success';
        default: return 'bg-secondary';
    }
}
?>
