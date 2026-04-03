<?php 
include 'config.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') { header("Location: index.php"); exit; }
$user_id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM topup WHERE user_id = '$user_id' ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Saldo - PulsaKita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --primary: #4361ee; }
        body { background: #f4f7fe; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .sidebar { width: 250px; height: 100vh; position: fixed; background: #fff; border-right: 1px solid #e0e4e8; padding: 20px; }
        .main-content { margin-left: 250px; padding: 40px; }
        .nav-link { color: #64748b; font-weight: 500; padding: 12px; border-radius: 10px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover { background: #f8f9ff; color: var(--primary); }
        .nav-link.active { background: var(--primary); color: white !important; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="sidebar">
    <h4 class="fw-bold text-primary mb-4 px-2">PulsaKita</h4>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard_user.php"><i class="bi bi-house-door me-2"></i> Dashboard</a>
        <a class="nav-link" href="topup.php"><i class="bi bi-wallet2 me-2"></i> Top Up Saldo</a>
        <a class="nav-link active" href="riwayat_saldo.php"><i class="bi bi-currency-dollar me-2"></i> Riwayat Saldo</a>
        <a class="nav-link" href="riwayat_user.php"><i class="bi bi-clock-history me-2"></i> Riwayat Pulsa</a>
        <hr>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
    </nav>
</div>
<div class="main-content">
    <h2 class="fw-bold mb-4">Riwayat Saldo</h2>
    <div class="card card-custom bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Tanggal</th><th>Nominal</th><th>Metode</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                    <td class="fw-bold text-success">Rp <?= number_format($row['nominal']); ?></td>
                    <td><?= $row['metode']; ?></td>
                    <td><span class="badge rounded-pill <?= $row['status'] == 'success' ? 'bg-success' : ($row['status'] == 'pending' ? 'bg-warning' : 'bg-danger') ?>"><?= $row['status']; ?></span></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>