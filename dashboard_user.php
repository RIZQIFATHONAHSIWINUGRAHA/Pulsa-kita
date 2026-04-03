<?php 
include 'config.php'; 

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['id'];
$query_saldo = mysqli_query($conn, "SELECT saldo FROM saldo_user WHERE user_id = '$user_id'");
$data_saldo = mysqli_fetch_assoc($query_saldo);
$saldo = $data_saldo['saldo'] ?? 0;

$produk = mysqli_query($conn, "SELECT * FROM produk_pulsa WHERE stok > 0 ORDER BY provider ASC, nominal ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - PulsaKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --primary: #4361ee; }
        body { background: #f4f7fe; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .sidebar { width: 250px; height: 100vh; position: fixed; background: #fff; border-right: 1px solid #e0e4e8; padding: 20px; z-index: 100; }
        .main-content { margin-left: 250px; padding: 40px; min-height: 100vh; }
        .nav-link { color: #64748b; font-weight: 500; padding: 12px; border-radius: 10px; margin-bottom: 5px; text-decoration: none; display: block; transition: 0.3s; }
        .nav-link:hover { background: #f8f9ff; color: var(--primary); }
        .nav-link.active { background: var(--primary); color: white !important; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="fw-bold text-primary mb-4 px-2">PulsaKita</h4>
    <nav class="nav flex-column">
        <a class="nav-link active" href="dashboard_user.php"><i class="bi bi-house-door me-2"></i> Dashboard</a>
        <a class="nav-link" href="topup.php"><i class="bi bi-wallet2 me-2"></i> Top Up Saldo</a>
        <a class="nav-link" href="riwayat_saldo.php"><i class="bi bi-currency-dollar me-2"></i> Riwayat Saldo</a>
        <a class="nav-link" href="riwayat_user.php"><i class="bi bi-clock-history me-2"></i> Riwayat Pulsa</a>
        <hr>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
    </nav>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Halo, <?= $_SESSION['nama']; ?>!</h2>
        <div class="bg-white p-3 rounded-4 shadow-sm border-start border-primary border-4">
            <small class="text-muted d-block">Saldo Kamu</small>
            <span class="fs-4 fw-bold text-primary">Rp <?= number_format($saldo); ?></span>
        </div>
    </div>

    <div class="card card-custom p-4 bg-white mb-4">
        <h5 class="fw-bold mb-4"><i class="bi bi-cart-plus me-2 text-primary"></i> Beli Pulsa</h5>
        <form action="proses_pesanan_user.php" method="POST">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Nomor HP</label>
                    <input type="number" name="nomor_hp" class="form-control form-control-lg bg-light border-0" placeholder="08xxx" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pilih Produk</label>
                    <select name="produk_id" class="form-select form-select-lg bg-light border-0" required>
                        <option value="">-- Pilih --</option>
                        <?php while($p = mysqli_fetch_assoc($produk)): ?>
                            <option value="<?= $p['id']; ?>">
                                <?= strtoupper($p['provider']); ?> - <?= number_format($p['nominal']); ?> (Rp <?= number_format($p['harga']); ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-primary">Kode Promo</label>
                    <input type="text" name="kode_promo" class="form-control form-control-lg bg-light border-0 text-primary" placeholder="Ketik kode">
                </div>
                <div class="col-12 mt-4 text-end">
                    <button type="submit" name="beli" class="btn btn-primary btn-lg px-5 fw-bold shadow">Beli Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>