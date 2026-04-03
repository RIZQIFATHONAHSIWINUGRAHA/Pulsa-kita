<?php 
include 'config.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') { header("Location: index.php"); exit; }

if (isset($_POST['tambah'])) {
    $kode = strtoupper(mysqli_real_escape_string($conn, $_POST['kode_voucher']));
    $potongan = $_POST['potongan'];
    $stok = $_POST['stok'];
    mysqli_query($conn, "INSERT INTO diskon (kode_voucher, potongan_persen, stok) VALUES ('$kode', '$potongan', '$stok')");
    header("Location: atur_diskon.php"); exit;
}
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM diskon WHERE id='$id'");
    header("Location: atur_diskon.php"); exit;
}
$diskon = mysqli_query($conn, "SELECT * FROM diskon ORDER BY tanggal_dibuat DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Diskon - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .sidebar { width: 250px; height: 100vh; position: fixed; background: #fff; border-right: 1px solid #dee2e6; padding: 20px; }
        .main-content { margin-left: 250px; padding: 30px; }
        .nav-link { color: #4b5563; font-weight: 500; padding: 12px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover { background-color: #f8f9ff; color: #4361ee; }
        .nav-link.active { background-color: #4361ee; color: white !important; }
    </style>
</head>
<body>
<div class="sidebar">
    <h4 class="fw-bold text-primary mb-4 px-2">PulsaKita</h4>
    <div class="nav flex-column">
        <a class="nav-link" href="dashboard_admin.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a class="nav-link" href="atur_pulsa.php"><i class="bi bi-phone me-2"></i> Produk Pulsa</a>
        <a class="nav-link active" href="atur_diskon.php"><i class="bi bi-ticket-perforated me-2"></i> Kelola Diskon</a>
        <a class="nav-link" href="riwayat_transaksi.php"><i class="bi bi-clock-history me-2"></i> Riwayat Pulsa</a>
        <a class="nav-link" href="riwayat_topup_admin.php"><i class="bi bi-cash-stack me-2"></i> Riwayat Top Up</a>
        <hr>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
    </div>
</div>
<div class="main-content">
    <h2 class="fw-bold mb-4">Kelola Voucher Diskon</h2>
    <div class="card border-0 shadow-sm p-4 mb-4">
        <form action="" method="POST" class="row g-3">
            <div class="col-md-4"><label>Kode Voucher</label><input type="text" name="kode_voucher" class="form-control" placeholder="MISAL: HEMAT10" required></div>
            <div class="col-md-3"><label>Potongan (%)</label><input type="number" name="potongan" class="form-control" required></div>
            <div class="col-md-3"><label>Stok</label><input type="number" name="stok" class="form-control" required></div>
            <div class="col-md-2 d-flex align-items-end"><button type="submit" name="tambah" class="btn btn-primary w-100">Simpan</button></div>
        </form>
    </div>
    <div class="card border-0 shadow-sm p-3">
        <table class="table table-hover align-middle">
            <thead><tr><th>Kode</th><th>Potongan</th><th>Terpakai / Stok</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php while($d = mysqli_fetch_assoc($diskon)): ?>
                <tr>
                    <td><span class="badge bg-light text-primary fs-6">#<?= $d['kode_voucher'] ?></span></td>
                    <td><?= $d['potongan_persen'] ?>%</td>
                    <td><?= $d['kuota_terpakai'] ?> / <?= $d['stok'] ?></td>
                    <td><a href="?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-outline-danger">Hapus</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>