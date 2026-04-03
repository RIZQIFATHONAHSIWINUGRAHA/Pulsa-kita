<?php 
include 'config.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') { header("Location: index.php"); exit; }

$user_id = $_SESSION['id'];
if (isset($_POST['request_topup'])) {
    $nominal = mysqli_real_escape_string($conn, $_POST['nominal']);
    $metode  = mysqli_real_escape_string($conn, $_POST['metode']);
    mysqli_query($conn, "INSERT INTO topup (user_id, nominal, metode, status) VALUES ('$user_id', '$nominal', '$metode', 'pending')");
    echo "<script>alert('Permintaan terkirim!'); window.location='riwayat_saldo.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Top Up - PulsaKita</title>
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
        <a class="nav-link active" href="topup.php"><i class="bi bi-wallet2 me-2"></i> Top Up Saldo</a>
        <a class="nav-link" href="riwayat_saldo.php"><i class="bi bi-currency-dollar me-2"></i> Riwayat Saldo</a>
        <a class="nav-link" href="riwayat_user.php"><i class="bi bi-clock-history me-2"></i> Riwayat Pulsa</a>
        <hr>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
    </nav>
</div>
<div class="main-content">
    <h2 class="fw-bold mb-4">Isi Saldo</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-custom p-4 bg-white">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nominal</label>
                        <input type="number" name="nominal" class="form-control bg-light border-0" placeholder="Min. 10.000" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Metode</label>
                        <select name="metode" class="form-select bg-light border-0" required>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>
                    <button type="submit" name="request_topup" class="btn btn-primary w-100 fw-bold shadow">Kirim Request</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>