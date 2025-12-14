-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2025 at 04:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gunshop_fc`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(20) NOT NULL,
  `user_id` int(20) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status_pesanan` enum('sudah_menunggu_formalisasi','sedang_diproses','selesai') DEFAULT 'sedang_diproses',
  `metode_pembayaran` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `user_id`, `nama`, `no_telepon`, `alamat`, `status_pesanan`, `metode_pembayaran`, `created_at`, `updated_at`) VALUES
(2, 1, 'asta', '088219882386', 'Cilandak', '', 'Qris', '2025-05-08 12:51:28', '2025-05-08 12:51:28'),
(10, 2, 'asta', '088219882386', 'Cilandak', 'sudah_menunggu_formalisasi', 'QRIS', '2025-05-08 13:03:20', '2025-05-08 13:03:20'),
(11, 14, 'rudi', '085714629511', 'grogol', 'sudah_menunggu_formalisasi', 'QRIS', '2025-05-27 07:26:56', '2025-05-27 07:26:56'),
(12, 13, 'riki', '8571111198976', 'haji slamet', 'sudah_menunggu_formalisasi', 'COD', '2025-05-27 07:28:07', '2025-05-27 07:28:07'),
(13, 12, 'toto', '085714629511', 'jalan kebenaran', 'sudah_menunggu_formalisasi', 'QRIS', '2025-05-27 07:28:53', '2025-05-27 07:28:53'),
(14, 11, 'yayan', '085714629511', 'bintaro', 'sudah_menunggu_formalisasi', 'COD', '2025-05-27 07:30:04', '2025-05-27 07:30:04'),
(15, 10, 'akmal', '085714629511', 'ciputat', 'sudah_menunggu_formalisasi', 'QRIS', '2025-05-27 07:30:55', '2025-05-27 07:30:55'),
(19, 15, 'febrio', '085714629511', 'pamulang', 'sudah_menunggu_formalisasi', 'QRIS', '2025-05-27 07:52:11', '2025-05-27 07:52:11'),
(20, 16, 'halim', '085714629511', 'Jl.Kebenaran Rt 01/Rw11, Manchester Barat,Jawa tenggara', 'sudah_menunggu_formalisasi', 'COD', '2025-05-27 07:55:01', '2025-05-27 07:55:01'),
(22, 20, 'anton', '08571462100000', 'jalan sesat', 'sudah_menunggu_formalisasi', 'COD', '2025-05-28 03:57:46', '2025-05-28 03:57:46'),
(24, 29, 'aan vlog', '088210948830', 'Gunung Sindur', 'sudah_menunggu_formalisasi', 'QRIS', '2025-12-08 03:20:01', '2025-12-08 03:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `detail_order`
--

CREATE TABLE `detail_order` (
  `id` int(10) NOT NULL,
  `transaksi_id` int(10) DEFAULT NULL,
  `idproduk` int(25) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `harga` int(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_order`
--

INSERT INTO `detail_order` (`id`, `transaksi_id`, `idproduk`, `quantity`, `harga`, `created_at`, `updated_at`) VALUES
(36, 33, 5, 1, 26000, '2025-05-27 07:41:10', '2025-05-27 07:41:10'),
(41, 38, 6, 3, 25000, '2025-05-27 07:45:47', '2025-05-27 07:45:47'),
(46, 43, 2, 3, 70000, '2025-05-27 07:52:11', '2025-05-27 07:52:11'),
(54, 49, 1, 4, 20000, '2025-05-28 03:57:46', '2025-05-28 03:57:46'),
(55, 49, 2, 2, 70000, '2025-05-28 03:57:46', '2025-05-28 03:57:46'),
(56, 49, 3, 2, 100000, '2025-05-28 03:57:46', '2025-05-28 03:57:46'),
(67, 55, 1, 1, 20000000, '2025-12-07 04:12:33', '2025-12-07 04:12:33'),
(68, 56, 2, 2, 7000000, '2025-12-08 03:20:01', '2025-12-08 03:20:01'),
(69, 56, 6, 1, 250000000, '2025-12-08 03:20:01', '2025-12-08 03:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(25) NOT NULL,
  `namakategori` varchar(25) NOT NULL,
  `tgblatihan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(20) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `role` varchar(15) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `password`, `name`, `role`, `no_telepon`, `alamat`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@gunshop', '12345', 'Admin GunSHop', 'admin', NULL, NULL, '2025-04-24 07:21:30', '2025-12-07 04:09:32', NULL),
(2, 'asta@gunshop', '12345', 'asta', 'pelanggan', '088219882386', 'Cilandak', '2025-04-26 09:47:35', '2025-12-07 04:09:06', NULL),
(3, 'owner@gunshop', '12345', 'Owner', 'owner', NULL, NULL, '2025-04-30 06:49:40', '2025-12-07 04:09:44', NULL),
(4, 'karyawan@gunshop', '12345', 'Karyawan', 'karyawan', NULL, NULL, '2025-04-30 06:50:20', '2025-12-07 04:09:56', NULL),
(10, 'akmal@yahoo.com', '12345', 'akmal', 'pelanggan', NULL, NULL, '2025-05-27 07:20:24', '2025-05-29 07:13:30', '2025-05-29 02:13:30'),
(11, 'yayan@yahoo.com', '12345', 'yayan', 'pelanggan', NULL, NULL, '2025-05-27 07:21:18', '2025-05-29 07:13:54', '2025-05-29 02:13:54'),
(12, 'toto@yahoo.com', '12345', 'toto', 'pelanggan', NULL, NULL, '2025-05-27 07:23:18', '2025-05-29 07:13:33', '2025-05-29 02:13:33'),
(13, 'riki@yahoo.com', '12345', 'riki', 'pelanggan', NULL, NULL, '2025-05-27 07:23:56', '2025-05-29 07:13:36', '2025-05-29 02:13:36'),
(14, 'rudi@yahoo.com', '12345', 'rudi', 'pelanggan', NULL, NULL, '2025-05-27 07:24:26', '2025-05-29 07:13:39', '2025-05-29 02:13:39'),
(15, 'febrio@yahoo.com', '12345', 'febrio', 'pelanggan', '085714629511', 'jalan kebenaran', '2025-05-27 07:51:51', '2025-05-27 07:51:51', NULL),
(16, 'halim@yahoo.com', '12345', 'halim', 'pelanggan', '085714629511', 'bintaro', '2025-05-27 07:54:37', '2025-05-27 07:54:37', NULL),
(20, 'anton@yahoo.com', '12345', 'anton', 'pelanggan', NULL, NULL, '2025-05-28 03:44:17', '2025-05-29 07:13:43', '2025-05-29 02:13:43'),
(28, 'blake@gunshop', '12345', 'blake', 'pelanggan', '03928', 'jalan jalan', '2025-12-08 02:56:27', '2025-12-08 02:56:27', NULL),
(29, 'aan@gunshop', '12345', 'aan vlog', 'pelanggan', '9082136319r', 'gunung sindur', '2025-12-08 03:19:12', '2025-12-08 03:19:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(10) NOT NULL,
  `idkategori` int(25) DEFAULT NULL,
  `namaproduk` varchar(25) NOT NULL,
  `gambarproduk` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(50) DEFAULT NULL,
  `tgblatihan` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `idkategori`, `namaproduk`, `gambarproduk`, `deskripsi`, `harga`, `tgblatihan`, `foto`, `stok`) VALUES
(1, NULL, 'Hand Gun M1911', NULL, NULL, 20000000, '2025-04-27 09:05:43', 'produk_6934f94db1004.jpg', 79),
(2, NULL, 'Hand Gun Cabot 1911', NULL, NULL, 7000000, '2025-04-27 09:40:37', 'produk_6934f9f3d7137.jpg', 59),
(3, NULL, 'Assault Rifle M4A1', 'produk_6837f34c1bd89.jpg', NULL, 10000000, '2025-04-27 09:41:00', 'produk_6934fa8b68ebd.jpg', 17),
(4, NULL, 'Shotgun Mossberg 940', NULL, NULL, 40000000, '2025-05-12 10:34:03', 'produk_6934fb62cdf02.jpg', 51),
(5, NULL, 'Submachine Gun P90', NULL, NULL, 26000000, '2025-05-12 10:36:24', 'produk_6934fbfa1ca4d.jpg', 54),
(6, NULL, 'Sniper Rifle Datei L115A3', NULL, NULL, 250000000, '2025-05-12 10:39:38', 'produk_6934fc5f33890.jpg', 74),
(7, NULL, 'Palu', NULL, NULL, 100000, '2025-12-08 03:18:33', '69364389a2b2d.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `tanggal_rating` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `transaksi_id`, `user_id`, `rating`, `komentar`, `tanggal_rating`) VALUES
(1, 49, 20, 3, 'barang tidak sesuai yang datang', '2025-05-28 12:10:23'),
(2, 38, 2, 5, 'barang bagus ', '2025-05-28 12:23:02'),
(3, 43, 15, 1, 'barang bocor semua', '2025-05-28 12:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `stok_history`
--

CREATE TABLE `stok_history` (
  `id` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `jenis` enum('masuk','keluar') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_history`
--

INSERT INTO `stok_history` (`id`, `idproduk`, `jenis`, `jumlah`, `keterangan`, `tanggal`) VALUES
(1, 1, 'masuk', 1, 'barang masuk', '2025-05-15 08:05:14'),
(2, 2, 'keluar', 2, 'barang rusak', '2025-05-15 08:15:45'),
(3, 1, 'masuk', 20, 'tambah stok', '2025-05-28 03:22:01'),
(4, 1, 'keluar', 11, 'rusa bos\r\n', '2025-11-20 08:42:25'),
(5, 3, 'keluar', 156, '', '2025-12-07 03:54:51'),
(6, 7, 'masuk', 1, '', '2025-12-08 03:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `metode_pembayaran` varchar(30) DEFAULT NULL,
  `status_pembayaran` enum('belum_bayar','menunggu_verifikasi','sudah_bayar') NOT NULL DEFAULT 'belum_bayar',
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_pengiriman` enum('belum_dikirim','dikirim','barang_sudah_sampai','selesai') DEFAULT 'belum_dikirim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `total_harga`, `metode_pembayaran`, `status_pembayaran`, `tanggal_transaksi`, `keterangan`, `deleted_at`, `bukti_pembayaran`, `status_pengiriman`) VALUES
(33, 9, 26000.00, 'QRIS', 'menunggu_verifikasi', '2025-05-27 07:41:10', NULL, NULL, 'bukti_68356ca804522.png', 'belum_dikirim'),
(38, 2, 75000.00, 'COD', 'sudah_bayar', '2025-05-27 07:45:47', NULL, NULL, NULL, 'barang_sudah_sampai'),
(43, 15, 210000.00, 'QRIS', 'menunggu_verifikasi', '2025-05-27 07:52:11', NULL, NULL, NULL, 'belum_dikirim'),
(49, 20, 420000.00, 'COD', 'sudah_bayar', '2025-05-28 03:57:46', NULL, NULL, NULL, 'barang_sudah_sampai'),
(55, 2, 20000000.00, 'QRIS', 'menunggu_verifikasi', '2025-12-07 04:12:33', NULL, NULL, NULL, 'belum_dikirim'),
(56, 29, 264000000.00, 'QRIS', 'sudah_bayar', '2025-12-08 03:20:01', NULL, NULL, 'bukti_693643f0466e7.jpg', 'dikirim');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_user` (`user_id`);

--
-- Indexes for table `detail_order`
--
ALTER TABLE `detail_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idproduk` (`idproduk`),
  ADD KEY `fk_detail_order_transaksi` (`transaksi_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`),
  ADD KEY `idkategori` (`idkategori`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stok_history`
--
ALTER TABLE `stok_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idproduk` (`idproduk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_ibfk_1` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `detail_order`
--
ALTER TABLE `detail_order`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stok_history`
--
ALTER TABLE `stok_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer_user` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_order`
--
ALTER TABLE `detail_order`
  ADD CONSTRAINT `detail_order_ibfk_2` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`),
  ADD CONSTRAINT `fk_detail_order_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`idkategori`) REFERENCES `login` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `customer` (`user_id`);

--
-- Constraints for table `stok_history`
--
ALTER TABLE `stok_history`
  ADD CONSTRAINT `stok_history_ibfk_1` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
