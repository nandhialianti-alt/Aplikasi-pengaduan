<?php
// includes/notification_model.php

/**
 * Add a notification
 */
function add_notification($id_user, $pesan, $tipe) {
    global $conn;
    $id_user = mysqli_real_escape_string($conn, $id_user);
    $pesan   = mysqli_real_escape_string($conn, $pesan);
    $tipe    = mysqli_real_escape_string($conn, $tipe);

    $query = "INSERT INTO notifikasi (id_user, pesan, tipe) VALUES ('$id_user', '$pesan', '$tipe')";
    return mysqli_query($conn, $query);
}

/**
 * Get all notifications for a user
 */
function get_user_notifications($id_user, $limit = 5) {
    global $conn;
    $id_user = mysqli_real_escape_string($conn, $id_user);
    $query = "SELECT * FROM notifikasi WHERE id_user = '$id_user' ORDER BY tanggal DESC LIMIT $limit";
    $result = mysqli_query($conn, $query);
    
    $notifications = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }
    return $notifications;
}

/**
 * Mark a notification as read
 */
function mark_notif_as_read($id_notifikasi) {
    global $conn;
    $id_notifikasi = mysqli_real_escape_string($conn, $id_notifikasi);
    $query = "UPDATE notifikasi SET is_read = TRUE WHERE id_notifikasi = '$id_notifikasi'";
    return mysqli_query($conn, $query);
}

/**
 * Mark all notifications as read for a user
 */
function mark_all_notif_read($id_user) {
    global $conn;
    $id_user = mysqli_real_escape_string($conn, $id_user);
    $query = "UPDATE notifikasi SET is_read = TRUE WHERE id_user = '$id_user'";
    return mysqli_query($conn, $query);
}

/**
 * Count unread notifications
 */
function count_unread_notif($id_user) {
    global $conn;
    $id_user = mysqli_real_escape_string($conn, $id_user);
    $query = "SELECT COUNT(*) as total FROM notifikasi WHERE id_user = '$id_user' AND is_read = FALSE";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
?>
