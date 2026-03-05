<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

check_login();
check_role('siswa');

$user_id = $_SESSION['user_id'];

// Get all complaints for this student
$query = "SELECT a.*, k.nama_kategori 
          FROM aspirasi a 
          JOIN kategori k ON a.id_kategori = k.id_kategori 
          WHERE a.id_user = $user_id 
          ORDER BY a.tanggal DESC";
$aspirasi_list = mysqli_query($conn, $query);
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<div class="main-content flex-grow-1 overflow-auto">
    <div class="topbar">
        <h4 class="mb-0">Histori Aspirasi</h4>
    </div>
    
    <div class="p-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Isi Pengaduan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($aspirasi_list) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($aspirasi_list)): ?>
                                    <tr>
                                        <td><span class="fw-bold">#<?= $row['id_aspirasi'] ?></span></td>
                                        <td><small class="text-muted fw-bold"><?= format_date($row['tanggal']) ?></small></td>
                                        <td><span class="badge bg-light text-primary border"><?= $row['nama_kategori'] ?></span></td>
                                        <td class="text-truncate" style="max-width: 300px;"><?= $row['isi'] ?></td>
                                        <td><span class="badge rounded-pill <?= get_status_class($row['status']) ?> px-3 text-capitalize"><?= $row['status'] ?></span></td>
                                        <td>
                                            <a href="detail_aspirasi.php?id=<?= $row['id_aspirasi'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Detail</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada aspirasi yang dibuat.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
