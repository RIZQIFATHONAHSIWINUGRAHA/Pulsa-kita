<?php
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['beli'])) {
    $user_id   = $_SESSION['id'];
    $produk_id = $_POST['produk_id'];
    $nomor_hp  = mysqli_real_escape_string($conn, $_POST['nomor_hp']);
    
    // Sesuaikan dengan name="kode_promo" di dashboard_user.php
    $kode_input = isset($_POST['kode_promo']) ? strtoupper(trim(mysqli_real_escape_string($conn, $_POST['kode_promo']))) : '';

    // 1. Ambil data produk
    $res_p = mysqli_query($conn, "SELECT * FROM produk_pulsa WHERE id = '$produk_id'");
    $p = mysqli_fetch_assoc($res_p);
    
    if (!$p) {
        echo "<script>alert('Produk tidak ditemukan!'); window.location='dashboard_user.php';</script>";
        exit;
    }

    $harga_asli = $p['harga']; 
    $provider   = $p['provider'];
    $nominal    = $p['nominal'];

    // 2. Logika Diskon
    $harga_akhir = $harga_asli; 
    $diskon_terpasang = false;
    $v_id = null;

    if (!empty($kode_input)) {
        // Cari voucher (Case Insensitive karena pakai strtoupper)
        $res_v = mysqli_query($conn, "SELECT * FROM diskon WHERE UPPER(kode_voucher) = '$kode_input'");
        
        if ($res_v && mysqli_num_rows($res_v) > 0) {
            $v = mysqli_fetch_assoc($res_v);
            
            // Cek Stok vs Terpakai
            if ((int)$v['stok'] > (int)$v['kuota_terpakai']) {
                $potongan = ($v['potongan_persen'] / 100) * $harga_asli;
                $harga_akhir = $harga_asli - $potongan;
                $diskon_terpasang = true;
                $v_id = $v['id'];
            } else {
                echo "<script>alert('Maaf, kuota promo [$kode_input] sudah habis!');</script>";
            }
        } else {
            echo "<script>alert('Kode promo [$kode_input] tidak valid!');</script>";
        }
    }

    // 3. Cek Saldo User
    $res_s = mysqli_query($conn, "SELECT saldo FROM saldo_user WHERE user_id = '$user_id'");
    $s = mysqli_fetch_assoc($res_s);
    $saldo_sekarang = $s['saldo'] ?? 0;

    if ($saldo_sekarang >= $harga_akhir) {
        // 4. Simpan Transaksi (Simpan harga_akhir dan kode_voucher)
        $sql = "INSERT INTO transaksi (user_id, provider, nominal, harga_akhir, kode_voucher, tujuan, status) 
                VALUES ('$user_id', '$provider', '$nominal', '$harga_akhir', '$kode_input', '$nomor_hp', 'pending')";

        if (mysqli_query($conn, $sql)) {
            // Update kuota terpakai jika sukses insert
            if ($diskon_terpasang && $v_id) {
                mysqli_query($conn, "UPDATE diskon SET kuota_terpakai = kuota_terpakai + 1 WHERE id = '$v_id'");
            }
            echo "<script>alert('Pesanan diproses! Total Bayar: Rp " . number_format($harga_akhir) . "'); window.location='dashboard_user.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Saldo tidak cukup! Harga: Rp " . number_format($harga_akhir) . "'); window.location='dashboard_user.php';</script>";
    }
}
?>