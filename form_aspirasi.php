<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

check_login();
check_role('siswa');

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

if (isset($_POST['submit'])) {
    $id_kategori = sanitize($_POST['id_kategori']);
    $isi         = sanitize($_POST['isi']);
    $tanggal     = date('Y-m-d H:i:s');

    $query = "INSERT INTO aspirasi (id_user, id_kategori, tanggal, isi, status) 
              VALUES ($user_id, $id_kategori, '$tanggal', '$isi', 'baru')";
              
    if (mysqli_query($conn, $query)) {
        $success = "Aspirasi berhasil dikirim!";
    } else {
        $error = "Gagal mengirim aspirasi: " . mysqli_error($conn);
    }
}

$categories = mysqli_query($conn, "SELECT * FROM kategori");
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<div class="main-content flex-grow-1 overflow-auto">
    <div class="topbar">
        <h4 class="mb-0">Buat Aspirasi</h4>
    </div>
    
    <div class="p-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <?php if ($success): ?>
                            <div class="alert alert-success border-0 shadow-sm mb-4">
                                <i class="fas fa-check-circle me-2"></i> <?= $success ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($error): ?>
                            <div class="alert alert-danger border-0 shadow-sm mb-4">
                                <i class="fas fa-exclamation-circle me-2"></i> <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Kategori Sarana</label>
                                <select name="id_kategori" class="form-select form-select-lg" required>
                                    <option value="">Pilih Kategori...</option>
                                    <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?= $cat['id_kategori'] ?>"><?= $cat['nama_kategori'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Detail Pengaduan / Aspirasi</label>
                                <textarea name="isi" class="form-control" rows="6" placeholder="Jelaskan secara detail mengenai sarana yang dikeluhkan..." required></textarea>
                                <div class="form-text mt-2">Berikan informasi yang jelas agar memudahkan admin dalam menindaklanjuti.</div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Aspirasi
                                </button>
                                <a href="index.php" class="btn btn-light btn-lg rounded-pill px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 bg-primary text-white rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-lightbulb me-2"></i> Tips Melapor</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Sebutkan lokasi sarana yang dimaksud.</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Jelaskan kondisi saat ini secara rinci.</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Sertakan usulan/saran jika ada.</li>
                            <li><i class="fas fa-check-circle me-2"></i> Gunakan bahasa yang sopan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
