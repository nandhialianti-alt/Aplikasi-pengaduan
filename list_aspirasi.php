<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

check_login();
check_role('admin');

// Handle Filters
$where = "WHERE 1=1 ";
if (!empty($_GET['tanggal'])) {
    $tgl = sanitize($_GET['tanggal']);
    $where .= " AND DATE(a.tanggal) = '$tgl'";
}
if (!empty($_GET['bulan'])) {
    $bln = sanitize($_GET['bulan']);
    $where .= " AND MONTH(a.tanggal) = '$bln'";
}
if (!empty($_GET['id_user'])) {
    $usr = (int)$_GET['id_user'];
    $where .= " AND a.id_user = $usr";
}
if (!empty($_GET['id_kategori'])) {
    $kat = (int)$_GET['id_kategori'];
    $where .= " AND a.id_kategori = $kat";
}

$query = "SELECT a.*, k.nama_kategori, u.nama 
          FROM aspirasi a 
          JOIN kategori k ON a.id_kategori = k.id_kategori 
          JOIN users u ON a.id_user = u.id_user 
          $where 
          ORDER BY a.tanggal DESC";
$list = mysqli_query($conn, $query);

// Data for filter selects
$students = mysqli_query($conn, "SELECT id_user, nama FROM users WHERE role = 'siswa'");
$categories = mysqli_query($conn, "SELECT * FROM kategori");
?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<div class="main-content flex-grow-1 overflow-auto">
    <div class="topbar">
        <h4 class="mb-0" style="font-family: 'Times New Roman', Times, serif; text-transform: uppercase;">Manajemen Aspirasi</h4>
    </div>
    
    <div class="p-4">
        <!-- Filter Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form action="" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $_GET['tanggal'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Bulan</label>
                        <select name="bulan" class="form-select">
                            <option value="">Semua Bulan</option>
                            <?php 
                            $months = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                            foreach($months as $num => $month): ?>
                                <option value="<?= $num ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $num) ? 'selected' : '' ?>><?= $month ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Siswa</label>
                        <select name="id_user" class="form-select">
                            <option value="">Semua Siswa</option>
                            <?php while($s = mysqli_fetch_assoc($students)): ?>
                                <option value="<?= $s['id_user'] ?>" <?= (isset($_GET['id_user']) && $_GET['id_user'] == $s['id_user']) ? 'selected' : '' ?>><?= $s['nama'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Kategori</label>
                        <select name="id_kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <?php while($c = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?= $c['id_kategori'] ?>" <?= (isset($_GET['id_kategori']) && $_GET['id_kategori'] == $c['id_kategori']) ? 'selected' : '' ?>><?= $c['nama_kategori'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill"><i class="fas fa-filter me-2"></i>Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm rounded-4">
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
                            <?php if (mysqli_num_rows($list) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($list)): ?>
                                    <tr>
                                        <td><span class="fw-bold"><?= $row['nama'] ?></span></td>
                                        <td><small class="text-muted fw-bold"><?= format_date($row['tanggal']) ?></small></td>
                                        <td><span class="badge bg-light text-primary border"><?= $row['nama_kategori'] ?></span></td>
                                        <td class="text-truncate" style="max-width: 250px;"><?= $row['isi'] ?></td>
                                        <td><span class="badge rounded-pill <?= get_status_class($row['status']) ?> px-3 text-capitalize"><?= $row['status'] ?></span></td>
                                        <td>
                                            <a href="detail_aspirasi.php?id=<?= $row['id_aspirasi'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Detail & Aksi</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">Data tidak ditemukan.</td>
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
