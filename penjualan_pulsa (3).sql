-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Apr 2026 pada 10.04
-- Versi server: 8.0.40
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan_pulsa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `diskon`
--

CREATE TABLE `diskon` (
  `id` int NOT NULL,
  `kode_voucher` varchar(20) NOT NULL,
  `potongan_persen` int NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tanggal_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `stok` int DEFAULT '0',
  `kuota_terpakai` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `diskon`
--

INSERT INTO `diskon` (`id`, `kode_voucher`, `potongan_persen`, `status`, `tanggal_dibuat`, `stok`, `kuota_terpakai`) VALUES
(1, 'PROMO15', 15, 'aktif', '2026-04-03 03:49:04', 2, 2),
(2, 'HEMAT15', 15, 'aktif', '2026-04-03 03:57:07', 5, 0),
(3, 'DISKON15', 15, 'aktif', '2026-04-03 04:13:18', 10, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_pulsa`
--

CREATE TABLE `produk_pulsa` (
  `id` int NOT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `nominal` int DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `stok` int DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `produk_pulsa`
--

INSERT INTO `produk_pulsa` (`id`, `provider`, `nominal`, `harga`, `stok`) VALUES
(1, 'Telkomsel', 5000, 7000, 100),
(2, 'Telkomsel', 10000, 12000, 97),
(3, 'Telkomsel', 50000, 52000, 99),
(4, 'XL Axiata', 10000, 11500, 100),
(5, 'XL Axiata', 25000, 26500, 100),
(6, 'Indosat', 5000, 6800, 100),
(7, 'Indosat', 20000, 21800, 100),
(8, 'Tri', 10000, 11000, 100),
(9, 'Telkomsel', 15000, 16500, 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `saldo_user`
--

CREATE TABLE `saldo_user` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `jumlah_stok` int DEFAULT '0',
  `saldo` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `saldo_user`
--

INSERT INTO `saldo_user` (`id`, `user_id`, `provider`, `jumlah_stok`, `saldo`) VALUES
(1, 1, NULL, 0, 0),
(2, 2, NULL, 0, 515800);

-- --------------------------------------------------------

--
-- Struktur dari tabel `topup`
--

CREATE TABLE `topup` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nominal` int NOT NULL,
  `metode` varchar(50) NOT NULL,
  `status` enum('pending','success','declined') DEFAULT 'pending',
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `topup`
--

INSERT INTO `topup` (`id`, `user_id`, `nominal`, `metode`, `status`, `tanggal`) VALUES
(1, 2, 100000, 'Tunai', 'success', '2026-04-03 07:22:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `nominal` int DEFAULT NULL,
  `harga_akhir` int DEFAULT NULL,
  `kode_voucher` varchar(20) DEFAULT NULL,
  `tujuan` varchar(20) DEFAULT NULL,
  `status` enum('pending','success','declined','approved') DEFAULT 'pending',
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `provider`, `nominal`, `harga_akhir`, `kode_voucher`, `tujuan`, `status`, `tanggal`) VALUES
(1, 2, 'Telkomsel', 50000, NULL, NULL, '081387642800', 'success', '2026-03-29 10:35:40'),
(2, 2, 'Telkomsel', 10000, NULL, NULL, '081387642800', 'success', '2026-04-03 03:50:10'),
(3, 2, 'Telkomsel', 10000, NULL, NULL, '123', 'success', '2026-04-03 03:54:04'),
(4, 2, 'Telkomsel', 10000, 12000, NULL, '122', 'declined', '2026-04-03 03:57:25'),
(5, 2, 'Telkomsel', 10000, 12000, NULL, '122', 'declined', '2026-04-03 03:58:14'),
(6, 2, 'Telkomsel', 10000, 12000, NULL, '122', 'declined', '2026-04-03 04:00:54'),
(7, 2, 'Telkomsel', 10000, 12000, NULL, '122', 'declined', '2026-04-03 04:01:33'),
(8, 2, 'Telkomsel', 10000, 12000, NULL, '122', 'declined', '2026-04-03 04:02:40'),
(9, 2, 'Telkomsel', 10000, 12000, NULL, '122', 'declined', '2026-04-03 04:03:41'),
(10, 2, 'Telkomsel', 10000, 12000, NULL, '08', 'declined', '2026-04-03 04:05:33'),
(11, 2, 'Telkomsel', 10000, 10200, 'DISKON15', '08', 'success', '2026-04-03 04:13:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nomor_hp` varchar(15) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.png',
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `nomor_hp`, `foto_profil`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@mail.com', 'admin123', NULL, 'default.png', 'admin', '2026-03-29 10:22:32'),
(2, 'Rizqi User', 'user@mail.com', 'user123', NULL, 'default.png', 'user', '2026-03-29 10:22:32');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `diskon`
--
ALTER TABLE `diskon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_voucher` (`kode_voucher`);

--
-- Indeks untuk tabel `produk_pulsa`
--
ALTER TABLE `produk_pulsa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `saldo_user`
--
ALTER TABLE `saldo_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `diskon`
--
ALTER TABLE `diskon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `produk_pulsa`
--
ALTER TABLE `produk_pulsa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `saldo_user`
--
ALTER TABLE `saldo_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `topup`
--
ALTER TABLE `topup`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `saldo_user`
--
ALTER TABLE `saldo_user`
  ADD CONSTRAINT `saldo_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
