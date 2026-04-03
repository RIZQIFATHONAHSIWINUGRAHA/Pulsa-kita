<?php 
include 'config.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') { header("Location: index.php"); exit; }
$query = mysqli_query($conn, "SELECT t.*, u.nama FROM transaksi t JOIN users u ON t.user_id = u.id WHERE t.status != 'pending' ORDER BY t.tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pulsa - Admin</title>
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
        <a class="nav-link" href="atur_diskon.php"><i class="bi bi-ticket-perforated me-2"></i> Kelola Diskon</a>
        <a class="nav-link active" href="riwayat_transaksi.php"><i class="bi bi-clock-history me-2"></i> Riwayat Pulsa</a>
        <a class="nav-link" href="riwayat_topup_admin.php"><i class="bi bi-cash-stack me-2"></i> Riwayat Top Up</a>
        <hr>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
    </div>
</div>
<div class="main-content">
    <h2 class="fw-bold mb-4">Histori Penjualan Pulsa</h2>
    <div class="card border-0 shadow-sm p-3">
        <table class="table table-hover align-middle">
            <thead><tr><th>Tanggal</th><th>User</th><th>Produk</th><th>Harga Final</th><th>Status</th></tr></thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                    <td class="fw-bold"><?= $row['nama']; ?></td>
                    <td><?= $row['provider']; ?> <?= number_format($row['nominal']); ?></td>
                    <td>Rp <?= number_format($row['harga_akhir']); ?></td>
                    <td><span class="badge rounded-pill bg-<?= $row['status'] == 'success' ? 'success' : 'danger' ?>"><?= $row['status'] ?></span></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>