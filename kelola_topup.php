<?php
include 'config.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') { header("Location: index.php"); exit; }

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $aksi = $_GET['aksi'];

    $q = mysqli_query($conn, "SELECT * FROM topup WHERE id = '$id'");
    $data = mysqli_fetch_assoc($q);
    
    if (!$data) { header("Location: dashboard_admin.php"); exit; }

    $u_id = $data['user_id'];
    $nominal = $data['nominal'];

    if ($aksi == 'approve' && $data['status'] == 'pending') {
        // 1. Sukseskan status topup
        mysqli_query($conn, "UPDATE topup SET status='success' WHERE id='$id'");
        // 2. Tambahkan saldo ke akun user
        mysqli_query($conn, "UPDATE saldo_user SET saldo = saldo + $nominal WHERE user_id = '$u_id'");
        echo "<script>alert('Top Up Berhasil Dikonfirmasi!'); window.location='dashboard_admin.php';</script>";
    } elseif ($aksi == 'decline') {
        mysqli_query($conn, "UPDATE topup SET status='declined' WHERE id='$id'");
        header("Location: dashboard_admin.php");
    }
}
?>