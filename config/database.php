<?php
// config/database.php

// Helper to safely get environment variables from Vercel/Aiven
function get_env_var($key, $default = "") {
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') return $_ENV[$key];
    if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') return $_SERVER[$key];
    $val = getenv($key);
    if ($val !== false && $val !== '') return $val;
    return $default;
}

// Support for Aiven / Vercel Environment Variables
$host = get_env_var('DB_HOST', "localhost");
$user = get_env_var('DB_USER', "root");
// Support both DB_PASSWORD and DB_PASS naming conventions
$pass = get_env_var('DB_PASSWORD', get_env_var('DB_PASS', ""));
$db   = get_env_var('DB_NAME', "pengaduan_sekolah");
$port = get_env_var('DB_PORT', "3306");

// Initialize connection
if ($host !== "localhost") {
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

