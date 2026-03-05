<?php
// modules/siswa/dashboard.php
$user_id = $_SESSION['user_id'];

// Get counts for dashboard stats
$q_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE id_user = $user_id");
$total = mysqli_fetch_assoc($q_total)['total'];

$q_selesai = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE id_user = $user_id AND status = 'selesai'");
$selesai = mysqli_fetch_assoc($q_selesai)['total'];

$q_proses = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE id_user = $user_id AND status = 'diproses'");
$proses = mysqli_fetch_assoc($q_proses)['total'];

// Recent complaints
$query_recent = "SELECT a.*, k.nama_kategori 
                 FROM aspirasi a 
                 JOIN kategori k ON a.id_kategori = k.id_kategori 
                 WHERE a.id_user = $user_id 
                 ORDER BY a.tanggal DESC LIMIT 5";
$recent_aspirasi = mysqli_query($conn, $query_recent);
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<div class="main-content flex-grow-1 overflow-auto">
    <div class="topbar">
        <h4 class="mb-0">Dashboard Siswa</h4>
    </div>
    
    <div class="p-4">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-primary fw-bold text-uppercase mb-1">Total Aspirasi</h6>
                                <h2 class="fw-bold mb-0"><?= $total ?></h2>
                            </div>
                            <div class="icon-shape bg-primary text-white rounded-circle p-3">
                                <i class="fas fa-paper-plane fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-dashboard border-warning">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-warning fw-bold text-uppercase mb-1">Diproses</h6>
                                <h2 class="fw-bold mb-0"><?= $proses ?></h2>
                            </div>
                            <div class="icon-shape bg-warning text-white rounded-circle p-3">
                                <i class="fas fa-spinner fa-2x"></i>
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
                                <h6 class="text-success fw-bold text-uppercase mb-1">Selesai</h6>
                                <h2 class="fw-bold mb-0"><?= $selesai ?></h2>
                            </div>
                            <div class="icon-shape bg-success text-white rounded-circle p-3">
                                <i class="fas fa-check-double fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Aspirasi Terbaru</h5>
                            <a href="form_aspirasi.php" class="btn btn-primary rounded-pill btn-sm px-3">
                                <i class="fas fa-plus me-1"></i> Buat Baru
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-modern align-middle">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>Isi Pengaduan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($recent_aspirasi) > 0): ?>
                                        <?php while($row = mysqli_fetch_assoc($recent_aspirasi)): ?>
                                            <tr>
                                                <td><small class="text-muted fw-bold"><?= format_date($row['tanggal']) ?></small></td>
                                                <td><span class="badge bg-light text-primary border"><?= $row['nama_kategori'] ?></span></td>
                                                <td class="text-truncate" style="max-width: 300px;"><?= $row['isi'] ?></td>
                                                <td><span class="badge rounded-pill <?= get_status_class($row['status']) ?> px-3"><?= $row['status'] ?></span></td>
                                                <td>
                                                    <a href="detail_aspirasi.php?id=<?= $row['id_aspirasi'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">Belum ada aspirasi yang dibuat.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
