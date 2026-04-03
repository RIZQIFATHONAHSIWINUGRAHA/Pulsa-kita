<?php
include 'config.php';

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // DEBUG: Cek apakah koneksi database error
    if (mysqli_connect_errno()) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    
    // DEBUG: Lihat berapa baris yang ditemukan
    $jumlah_data = mysqli_num_rows($query);

    if ($jumlah_data === 1) {
        $row = mysqli_fetch_assoc($query);
        
        if ($password === $row['password'] || password_verify($password, $row['password'])) {
            $_SESSION['id']    = $row['id'];
            $_SESSION['nama']  = $row['nama'];
            $_SESSION['role']  = $row['role'];
            $_SESSION['login'] = true;

            header("Location: " . ($row['role'] == 'admin' ? 'dashboard_admin.php' : 'dashboard_user.php'));
            exit;
        } else {
            echo "<script>alert('Password Salah!'); window.location='index.php';</script>";
        }
    } else {
        // PESAN ERROR DETAIL
        echo "<script>
            alert('DEBUG: PHP mencari email [$email] tapi database mengembalikan $jumlah_data data. Pastikan nama database di config.php SUDAH BENAR.'); 
            window.location='index.php';
        </script>";
    }
}
?>