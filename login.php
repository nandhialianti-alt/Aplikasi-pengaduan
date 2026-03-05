<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/notification_model.php';

if (isset($_SESSION['user_id'])) {
    redirect('index.php');
}

$error = '';

if (isset($_POST['login'])) {
    $username = sanitize($_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password_md5 = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['username']= $user['username'];

        // Add login notification
        $nama_user = $user['nama'];
        add_notification($user['id_user'], "Anda berhasil login ke sistem.", "login");

        redirect('index.php');
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pengaduan Sarana Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { background: #fff5f7; }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="col-md-5">
            <div class="card card-login">
                <div class="login-header">
                    <h3 class="mb-0">Pengaduan Sekolah</h3>
                    <p class="text-white-50 small mb-0">Silakan login untuk melanjutkan</p>
                </div>
                <div class="login-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="" method="POST">
                        <div class="mb-4">
                            <label class="form-label small text-muted">Username</label>
                            <input type="text" name="username" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-muted">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100 btn-lg rounded-pill">Login Now</button>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <p class="small text-muted mb-2">Belum punya akun? <a href="register.php" class="text-primary text-decoration-none fw-semibold">Daftar di sini</a></p>
                        <p class="small text-muted mb-0">&copy; 2024 Nandhia - UKK Project</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
