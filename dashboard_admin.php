<?php 
include 'config.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') { header("Location: index.php"); exit; }

// Statistik Penjualan Pulsa
$q_sales = mysqli_query($conn, "SELECT SUM(harga_akhir) as total FROM transaksi WHERE status='success'");
$total_pulsa = mysqli_fetch_assoc($q_sales)['total'] ?? 0;

// Statistik Top Up Saldo Masuk
$q_topup = mysqli_query($conn, "SELECT SUM(nominal) as total FROM topup WHERE status='success'");
$total_topup = mysqli_fetch_assoc($q_topup)['total'] ?? 0;

// Statistik Total Transaksi
$q_count = mysqli_query($conn, "SELECT COUNT(*) as jml FROM transaksi");
$total_trx = mysqli_fetch_assoc($q_count)['jml'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - PulsaKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .sidebar { width: 250px; height: 100vh; position: fixed; background: #fff; border-right: 1px solid #dee2e6; padding: 20px; z-index: 100; }
        .main-content { margin-left: 250px; padding: 30px; min-height: 100vh; }
        .nav-link { color: #4b5563; font-weight: 500; padding: 12px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover { background-color: #f8f9ff; color: #4361ee; }
        .nav-link.active { background-color: #4361ee; color: white !important; shadow: 0 4px 6px rgba(67, 97, 238, 0.3); }
        .card-stat { border: none; border-radius: 12px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="fw-bold text-primary mb-4 px-2">PulsaKita</h4>
    <div class="nav flex-column">
        <a class="nav-link active" href="dashboard_admin.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a class="nav-link" href="atur_pulsa.php"><i class="bi bi-phone me-2"></i> Produk Pulsa</a>
        <a class="nav-link" href="atur_diskon.php"><i class="bi bi-ticket-perforated me-2"></i> Kelola Diskon</a>
        <a class="nav-link" href="riwayat_transaksi.php"><i class="bi bi-clock-history me-2"></i> Riwayat Pulsa</a>
        <a class="nav-link" href="riwayat_topup_admin.php"><i class="bi bi-cash-stack me-2"></i> Riwayat Top Up</a>
        <hr>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
    </div>
</div>

<div class="main-content">
    <h2 class="fw-bold mb-4">Ringkasan Penjualan</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-stat bg-primary text-white p-4 shadow-sm text-center">
                <small class="opacity-75">Total Penjualan Pulsa</small>
                <h3 class="fw-bold m-0">Rp <?= number_format($total_pulsa); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat bg-success text-white p-4 shadow-sm text-center">
                <small class="opacity-75">Total Top Up Masuk</small>
                <h3 class="fw-bold m-0">Rp <?= number_format($total_topup); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat bg-dark text-white p-4 shadow-sm text-center">
                <small class="opacity-75">Total Transaksi</small>
                <h3 class="fw-bold m-0"><?= $total_trx; ?> Pesanan</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 fw-bold text-primary">Pending: Pulsa</div>
                <div class="p-2 table-responsive">
                    <table class="table table-sm align-middle">
                        <thead><tr><th>User</th><th>Produk</th><th>Aksi</th></tr></thead>
                        <tbody>
                            <?php 
                            $qp = mysqli_query($conn, "SELECT t.*, u.nama FROM transaksi t JOIN users u ON t.user_id = u.id WHERE t.status = 'pending'");
                            while($rp = mysqli_fetch_assoc($qp)): ?>
                            <tr>
                                <td><?= $rp['nama'] ?></td>
                                <td><small><?= $rp['provider'] ?> <?= number_format($rp['nominal']) ?></small></td>
                                <td>
                                    <a href="proses_pesanan.php?id=<?= $rp['id'] ?>&aksi=approve" class="btn btn-sm btn-success">✓</a>
                                    <a href="proses_pesanan.php?id=<?= $rp['id'] ?>&aksi=decline" class="btn btn-sm btn-outline-danger">✕</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 fw-bold text-success">Pending: Top Up</div>
                <div class="p-2 table-responsive">
                    <table class="table table-sm align-middle">
                        <thead><tr><th>User</th><th>Nominal</th><th>Aksi</th></tr></thead>
                        <tbody>
                            <?php 
                            $qt = mysqli_query($conn, "SELECT t.*, u.nama FROM topup t JOIN users u ON t.user_id = u.id WHERE t.status = 'pending'");
                            while($rt = mysqli_fetch_assoc($qt)): ?>
                            <tr>
                                <td><?= $rt['nama'] ?></td>
                                <td><small>Rp <?= number_format($rt['nominal']) ?></small></td>
                                <td>
                                    <a href="kelola_topup.php?id=<?= $rt['id'] ?>&aksi=approve" class="btn btn-sm btn-success">✓</a>
                                    <a href="kelola_topup.php?id=<?= $rt['id'] ?>&aksi=decline" class="btn btn-sm btn-outline-danger">✕</a>
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
</body>
</html>