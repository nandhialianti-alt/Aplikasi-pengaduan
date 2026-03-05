<?php
$role = $_SESSION['role'];
?>
<div class="sidebar d-flex flex-column flex-shrink-0" style="width: 280px;">
    <div class="p-4 d-flex align-items-center gap-2">
        <i class="fas fa-school fa-2x"></i>
        <span class="fs-4 fw-bold">E-Pengaduan</span>
    </div>
    <hr class="mx-3 my-0 opacity-25">
    <ul class="nav flex-column mb-auto mt-3">
        <li>
            <a href="index.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </li>
        
        <?php if ($role === 'siswa'): ?>
        <li>
            <a href="form_aspirasi.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'form_aspirasi.php') ? 'active' : '' ?>">
                <i class="fas fa-edit"></i>
                Buat Aspirasi
            </a>
        </li>
        <li>
            <a href="histori_aspirasi.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'histori_aspirasi.php') ? 'active' : '' ?>">
                <i class="fas fa-history"></i>
                Histori Saya
            </a>
        </li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
        <li>
            <a href="list_aspirasi.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'list_aspirasi.php') ? 'active' : '' ?>">
                <i class="fas fa-list-ul"></i>
                Daftar Aspirasi
            </a>
        </li>
        <?php endif; ?>
    </ul>
    <hr class="mx-3 opacity-25">
    <div class="p-3">
        <div class="bg-white bg-opacity-10 rounded p-3 mb-3">
            <p class="small mb-1 text-white-50">Logged in as:</p>
            <p class="fw-bold mb-0"><?= $_SESSION['nama'] ?></p>
            <span class="badge bg-secondary text-capitalize"><?= $role ?></span>
        </div>
        <a href="logout.php" class="btn btn-outline-light w-100 rounded-pill">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>
