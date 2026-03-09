<?php
// config/database.php

// Support for Aiven / Vercel Environment Variables
$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASSWORD') ?: "";
$db   = getenv('DB_NAME') ?: "pengaduan_sekolah";
$port = getenv('DB_PORT') ?: "3306";

// Initialize connection
if (getenv('DB_HOST')) {
    // Aiven / Remote Connection (usually requires SSL or specific port)
    $conn = mysqli_connect($host, $user, $pass, $db, $port);
} else {
    // Local Connection
    $conn = mysqli_connect($host, $user, $pass, $db);
}

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

