<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

check_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Join with users and kategori
$query = "SELECT a.*, k.nama_kategori, u.nama as nama_siswa 
          FROM aspirasi a 
          JOIN kategori k ON a.id_kategori = k.id_kategori 
          JOIN users u ON a.id_user = u.id_user 
          WHERE a.id_aspirasi = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    redirect('index.php');
}

$data = mysqli_fetch_assoc($result);

// Security: If student, check if it's their own
if ($role === 'siswa' && $data['id_user'] != $user_id) {
    redirect('index.php');
}

// Get feedback
$q_feedback = mysqli_query($conn, "SELECT * FROM umpan_balik WHERE id_aspirasi = $id ORDER BY tanggal ASC");
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<div class="main-content flex-grow-1 overflow-auto">
    <div class="topbar">
        <h4 class="mb-0">Detail Aspirasi #<?= $id ?></h4>
    </div>
    
    <div class="p-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Main Aspirasi Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge bg-light text-primary border px-3 py-2 text-capitalize fs-6">
                                <i class="fas fa-tag me-2"></i><?= $data['nama_kategori'] ?>
                            </span>
                            <span class="badge rounded-pill <?= get_status_class($data['status']) ?> px-4 py-2 fs-6 text-capitalize">
                                <?= $data['status'] ?>
                            </span>
                        </div>
                        
                        <h6 class="text-muted small text-uppercase fw-bold mb-1">Diajukan oleh:</h6>
                        <p class="fs-5 fw-bold mb-4"><?= $data['nama_siswa'] ?> <span class="text-muted small fw-normal">| <?= format_date($data['tanggal']) ?></span></p>
                        
                        <hr class="opacity-10 mb-4">
                        
                        <h6 class="text-muted small text-uppercase fw-bold mb-2">Isi Aspirasi:</h6>
                        <div class="bg-light p-4 rounded-3 mb-4">
                            <p class="mb-0 fs-6" style="line-height: 1.8;"><?= nl2br($data['isi']) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Feedback Section -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold"><i class="fas fa-comments me-2 text-primary"></i>Umpan Balik Admin</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if (mysqli_num_rows($q_feedback) > 0): ?>
                            <div class="timeline">
                                <?php while($fb = mysqli_fetch_assoc($q_feedback)): ?>
                                    <div class="mb-4 border-start border-primary border-4 ps-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold text-primary">Administrator</span>
                                            <small class="text-muted"><?= format_date($fb['tanggal']) ?></small>
                                        </div>
                                        <p class="mb-0 bg-light p-3 rounded-3"><?= nl2br($fb['balasan']) ?></p>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4 bg-light rounded-4">
                                <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada umpan balik dari admin.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <?php if ($role === 'admin'): ?>
                <!-- Admin Actions -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold">Kelola Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="process_admin.php" method="POST">
                            <input type="hidden" name="id_aspirasi" value="<?= $id ?>">
                            <div class="mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Ubah Status</label>
                                <select name="status" class="form-select">
                                    <option value="baru" <?= ($data['status'] == 'baru') ? 'selected' : '' ?>>Baru</option>
                                    <option value="diproses" <?= ($data['status'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                    <option value="selesai" <?= ($data['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                </select>
                            </div>
                            <button type="submit" name="update_status" class="btn btn-primary w-100 rounded-pill">Update Status</button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold">Beri Umpan Balik</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="process_admin.php" method="POST">
                            <input type="hidden" name="id_aspirasi" value="<?= $id ?>">
                            <div class="mb-3">
                                <textarea name="balasan" class="form-control" rows="4" placeholder="Tulis balasan di sini..." required></textarea>
                            </div>
                            <button type="submit" name="submit_feedback" class="btn btn-success w-100 rounded-pill">Kirim Balasan</button>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                <!-- Student Info Card -->
                <div class="card border-0 bg-info text-white shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                        <p class="small mb-0">Status aspirasi Anda saat ini adalah <strong><?= $data['status'] ?></strong>. Mohon tunggu tim admin untuk memproses dan memberikan umpan balik.</p>
                    </div>
                </div>
                <?php endif; ?>
                
                <a href="<?= ($role == 'admin') ? 'list_aspirasi.php' : 'histori_aspirasi.php' ?>" class="btn btn-light w-100 mt-4 rounded-pill border shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
