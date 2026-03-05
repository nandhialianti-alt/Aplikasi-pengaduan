<?php
// modules/admin/dashboard.php

// Stats
$q_all = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi");
$total_all = mysqli_fetch_assoc($q_all)['total'];

$q_baru = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE status = 'baru'");
$total_baru = mysqli_fetch_assoc($q_baru)['total'];

$q_users = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'siswa'");
$total_siswa = mysqli_fetch_assoc($q_users)['total'];

// Most recent
$query_recent = "SELECT a.*, k.nama_kategori, u.nama 
                 FROM aspirasi a 
                 JOIN kategori k ON a.id_kategori = k.id_kategori 
                 JOIN users u ON a.id_user = u.id_user 
                 ORDER BY a.tanggal DESC LIMIT 10";
$recent_all = mysqli_query($conn, $query_recent);
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<div class="main-content flex-grow-1 overflow-auto">
    <div class="topbar">
        <h4 class="mb-0 text-danger fw-bold">Admin Panel</h4>
    </div>
    
    <div class="p-4">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-primary fw-bold text-uppercase mb-1">Seluruh Aspirasi</h6>
                                <h2 class="fw-bold mb-0"><?= $total_all ?></h2>
                            </div>
                            <div class="icon-shape bg-primary text-white rounded-circle p-3">
                                <i class="fas fa-database fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-dashboard border-info">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-danger fw-bold text-uppercase mb-1">Aspirasi Baru</h6>
                                <h2 class="fw-bold mb-0"><?= $total_baru ?></h2>
                            </div>
                            <div class="icon-shape bg-info text-white rounded-circle p-3">
                                <i class="fas fa-envelope-open fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-dashboard border-success">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-success fw-bold text-uppercase mb-1">Total Siswa</h6>
                                <h2 class="fw-bold mb-0"><?= $total_siswa ?></h2>
                            </div>
                            <div class="icon-shape bg-success text-white rounded-circle p-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Antrean Aspirasi Terbaru</h5>
                <a href="list_aspirasi.php" class="btn btn-primary rounded-pill btn-sm px-3">Lihat Semua</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Isi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($recent_all)): ?>
                                <tr>
                                    <td><span class="fw-bold"><?= $row['nama'] ?></span></td>
                                    <td><small class="text-muted fw-bold"><?= format_date($row['tanggal']) ?></small></td>
                                    <td><span class="badge bg-light text-primary border"><?= $row['nama_kategori'] ?></span></td>
                                    <td class="text-truncate" style="max-width: 250px;"><?= $row['isi'] ?></td>
                                    <td><span class="badge rounded-pill <?= get_status_class($row['status']) ?> px-3 text-capitalize"><?= $row['status'] ?></span></td>
                                    <td>
                                        <a href="detail_aspirasi.php?id=<?= $row['id_aspirasi'] ?>" class="btn btn-sm btn-outline-primary rounded-pill">Kelola</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
