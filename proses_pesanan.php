<?php
include 'config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); exit;
}

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id_trx = mysqli_real_escape_string($conn, $_GET['id']);
    $aksi = $_GET['aksi'];

    // Ambil data transaksi lengkap
    $q = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = '$id_trx'");
    $d = mysqli_fetch_assoc($q);
    
    if (!$d) { header("Location: dashboard_admin.php"); exit; }

    $u_id = $d['user_id'];
    // PRIORITAS: Gunakan harga_akhir jika tersedia (> 0)
    $harga_potong = ($d['harga_akhir'] > 0) ? $d['harga_akhir'] : $d['nominal'];

    if ($aksi == 'approve') {
        // 1. Sukseskan Transaksi
        mysqli_query($conn, "UPDATE transaksi SET status='success' WHERE id='$id_trx'");
        
        // 2. Potong Saldo (Harga Diskon)
        mysqli_query($conn, "UPDATE saldo_user SET saldo = saldo - $harga_potong WHERE user_id = '$u_id'");
        
        // 3. Kurangi Stok Produk
        mysqli_query($conn, "UPDATE produk_pulsa SET stok = stok - 1 WHERE provider = '".$d['provider']."' AND nominal = '".$d['nominal']."'");
        
        echo "<script>alert('Pesanan Berhasil di-Approve!'); window.location='dashboard_admin.php';</script>";

    } elseif ($aksi == 'decline') {
        // 1. Batalkan Transaksi
        mysqli_query($conn, "UPDATE transaksi SET status='declined' WHERE id='$id_trx'");

        // 2. Kembalikan Kuota Voucher (Jika saat beli pakai voucher)
        if (!empty($d['kode_voucher'])) {
            $kv = $d['kode_voucher'];
            mysqli_query($conn, "UPDATE diskon SET kuota_terpakai = kuota_terpakai - 1 WHERE UPPER(kode_voucher) = UPPER('$kv') AND kuota_terpakai > 0");
        }
        
        echo "<script>alert('Pesanan Ditolak & Kuota Voucher Dikembalikan'); window.location='dashboard_admin.php';</script>";
    }
}
?>