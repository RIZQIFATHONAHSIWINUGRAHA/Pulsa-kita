<?php 
include 'config.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') { header("Location: index.php"); exit; }

if (isset($_POST['tambah'])) {
    $provider = mysqli_real_escape_string($conn, $_POST['provider']);
    $nominal = $_POST['nominal'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($conn, "INSERT INTO produk_pulsa (provider, nominal, harga, stok) VALUES ('$provider', '$nominal', '$harga', '$stok')");
    header("Location: atur_pulsa.php"); exit;
}
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM produk_pulsa WHERE id='$id'");
    header("Location: atur_pulsa.php"); exit;
}
$produk = mysqli_query($conn, "SELECT * FROM produk_pulsa ORDER BY provider ASC, nominal ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Atur Pulsa - Admin</title>
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
        <a class="nav-link active" href="atur_pulsa.php"><i class="bi bi-phone me-2"></i> Produk Pulsa</a>
        <a class="nav-link" href="atur_diskon.php"><i class="bi bi-ticket-perforated me-2"></i> Kelola Diskon</a>
        <a class="nav-link" href="riwayat_transaksi.php"><i class="bi bi-clock-history me-2"></i> Riwayat Pulsa</a>
        <a class="nav-link" href="riwayat_topup_admin.php"><i class="bi bi-cash-stack me-2"></i> Riwayat Top Up</a>
        <hr>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
    </div>
</div>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Atur Produk Pulsa</h2>
        <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Produk</button>
    </div>
    <div class="card border-0 shadow-sm p-3">
        <table class="table table-hover align-middle">
            <thead><tr><th>Provider</th><th>Nominal</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php while($p = mysqli_fetch_assoc($produk)): ?>
                <tr>
                    <td class="fw-bold"><?= strtoupper($p['provider']) ?></td>
                    <td><?= number_format($p['nominal']) ?></td>
                    <td>Rp <?= number_format($p['harga']) ?></td>
                    <td><?= $p['stok'] ?></td>
                    <td><a href="?hapus=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog"><form action="" method="POST" class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Tambah Produk</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label>Provider</label><input type="text" name="provider" class="form-control" required></div>
            <div class="mb-3"><label>Nominal</label><input type="number" name="nominal" class="form-control" required></div>
            <div class="mb-3"><label>Harga</label><input type="number" name="harga" class="form-control" required></div>
            <div class="mb-3"><label>Stok</label><input type="number" name="stok" class="form-control" required></div>
        </div>
        <div class="modal-footer"><button type="submit" name="tambah" class="btn btn-primary w-100">Simpan Produk</button></div>
    </form></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>