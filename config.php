<?php
$host = "localhost"; // Coba hapus :3307 nya jika pakai XAMPP standar
$user = "root";
$pass = "";
$db   = "penjualan_pulsa";

$conn = mysqli_connect($host, $user, $pass);

// Buat database dan pilih
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $db");
mysqli_select_db($conn, $db);

// Tabel Users
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user'
)");

// Tabel Transaksi
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS transaksi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    provider VARCHAR(50),
    nominal INT,
    tujuan VARCHAR(20),
    status ENUM('pending', 'success', 'declined', 'approved') DEFAULT 'pending',
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Tabel Produk Pulsa (INI YANG BARU)
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS produk_pulsa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    provider VARCHAR(50),
    nominal INT,
    harga INT,
    stok INT DEFAULT 100
)");

// Isi Data Dummy Produk jika kosong
$check_produk = mysqli_query($conn, "SELECT id FROM produk_pulsa LIMIT 1");
if (mysqli_num_rows($check_produk) == 0) {
    mysqli_query($conn, "INSERT INTO produk_pulsa (provider, nominal, harga, stok) VALUES 
    ('Telkomsel', 5000, 7000, 100),
    ('Telkomsel', 10000, 12000, 100),
    ('Telkomsel', 50000, 52000, 100),
    ('XL Axiata', 10000, 11500, 100),
    ('XL Axiata', 25000, 26500, 100),
    ('Indosat', 5000, 6800, 100),
    ('Indosat', 20000, 21800, 100),
    ('Tri', 10000, 11000, 100)");
}

session_start();
?>