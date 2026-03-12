-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2026 at 03:46 PM
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
-- Database: `lost_found_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_temuan`
--

CREATE TABLE `barang_temuan` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `category` varchar(80) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `lokasi_ditemukan` varchar(150) NOT NULL,
  `tanggal_ditemukan` datetime NOT NULL,
  `status` enum('open','resolved','closed') DEFAULT 'open',
  `type` enum('lost','found') NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_temuan`
--

INSERT INTO `barang_temuan` (`id_barang`, `nama_barang`, `deskripsi`, `category`, `image`, `lokasi_ditemukan`, `tanggal_ditemukan`, `status`, `type`, `id_petugas`, `created_at`) VALUES
(1, 'Dompet Kulit Hitam', 'Dompet warna hitam berisi KTP dan kartu ATM BCA', 'Accessories', NULL, 'Stasiun Jatinegara ', '2025-01-10 00:00:00', 'open', 'lost', 1, '2026-03-12 03:48:53'),
(2, 'iPhone 14 Pro', 'HP warna space black, ada case bening, wallpaper kucing', 'Electronics', NULL, 'Stasiun Tanah Abang Baru', '2025-01-11 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(3, 'Kucing Oranye', 'Kucing jantan oranye, nama Mochi, pakai kalung merah', 'Pets', NULL, 'Stasiun Tanah Abang Baru', '2025-01-12 00:00:00', 'open', 'lost', 1, '2026-03-12 03:48:53'),
(4, 'Tas Ransel Biru Navy', 'Tas ransel merk Eiger warna biru, ada pin anime', 'Bags', NULL, 'Stasiun Duri', '2025-01-13 00:00:00', 'resolved', 'found', 1, '2026-03-12 03:48:53'),
(5, 'Kunci Motor Yamaha', 'Gantungan kunci bentuk bola, ada chip motor Yamaha NMAX', 'Keys', NULL, 'Parkiran Stasiun Manggarai', '2025-01-14 00:00:00', 'open', 'lost', 1, '2026-03-12 03:48:53'),
(6, 'Gelang Perak', 'Gelang perak ukiran bunga, ada inisial \"R.A\" di dalam', 'Jewelry', NULL, 'Stasiun Tanjung Priuk', '2025-01-15 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(7, 'Kartu Pelajar SMA 17', 'Kartu pelajar atas nama Budi Santoso kelas XII IPA 2', 'Documents', NULL, 'Stasiun Cisauk deket alfamart', '2025-01-16 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(8, 'AirPods Pro Gen 2', 'AirPods Pro putih, case ada stiker planet saturnus', 'Electronics', NULL, 'Cafe Kopi Kenangan Sudirman', '2025-01-17 00:00:00', 'open', 'lost', 1, '2026-03-12 03:48:53'),
(9, 'Jaket Hoodie Abu-abu', 'Hoodie polos abu-abu ukuran L, merk Uniqlo', 'Clothing', NULL, 'Stasiun Manggarai ', '2025-01-18 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(10, 'Buku Catatan Cokelat', 'Buku catatan hardcover cokelat, isi coretan kuliah', 'Other', NULL, 'Stasiun Universitas Indonesia Depok', '2025-01-19 00:00:00', 'open', 'lost', 1, '2026-03-12 03:48:53'),
(11, 'Sepeda Lipat Brompton', 'Sepeda lipat warna hijau army, ada stiker nama owner', 'Other', NULL, 'Stasiun Rangkasbelitung', '2025-01-20 00:00:00', 'resolved', 'found', 1, '2026-03-12 03:48:53'),
(12, 'Power Bank Xiaomi', 'Power bank 20000mAh warna putih, ada nama \"Dian\" di belakang', 'Electronics', NULL, 'Stasiun Sudirman', '2025-01-21 00:00:00', 'resolved', 'found', 1, '2026-03-12 03:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_kehilangan`
--

CREATE TABLE `laporan_kehilangan` (
  `id_laporan` int(11) NOT NULL,
  `id_pelapor` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `lokasi_kehilangan` varchar(150) NOT NULL,
  `tanggal_kehilangan` datetime NOT NULL,
  `status` enum('menunggu','diproses','cocok','selesai') DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id_news` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pencocokan`
--

CREATE TABLE `pencocokan` (
  `id_pencocokan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_laporan` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `tanggal_pencocokan` datetime DEFAULT current_timestamp(),
  `status_verifikasi` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `serah_terima`
--

CREATE TABLE `serah_terima` (
  `id_serah_terima` int(11) NOT NULL,
  `id_pencocokan` int(11) NOT NULL,
  `tanggal_serah_terima` datetime DEFAULT current_timestamp(),
  `nama_penerima` varchar(100) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('staff','user') NOT NULL,
  `oauth_provider` varchar(50) DEFAULT NULL,
  `oauth_uid` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `avatar`, `nama`, `email`, `password`, `role`, `oauth_provider`, `oauth_uid`, `created_at`) VALUES
(1, NULL, 'Joshua', 'joshua@gmail.com', '$2y$10$T6pKQM8IJ27gsQ.O.h2yQetLMwin1cDxs6GnmC4TADAfMAvrMZB/2', 'staff', 'email', NULL, '2026-03-12 03:48:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_temuan`
--
ALTER TABLE `barang_temuan`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `laporan_kehilangan`
--
ALTER TABLE `laporan_kehilangan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_pelapor` (`id_pelapor`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_news`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `pencocokan`
--
ALTER TABLE `pencocokan`
  ADD PRIMARY KEY (`id_pencocokan`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_laporan` (`id_laporan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `serah_terima`
--
ALTER TABLE `serah_terima`
  ADD PRIMARY KEY (`id_serah_terima`),
  ADD KEY `id_pencocokan` (`id_pencocokan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_temuan`
--
ALTER TABLE `barang_temuan`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `laporan_kehilangan`
--
ALTER TABLE `laporan_kehilangan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pencocokan`
--
ALTER TABLE `pencocokan`
  MODIFY `id_pencocokan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serah_terima`
--
ALTER TABLE `serah_terima`
  MODIFY `id_serah_terima` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_temuan`
--
ALTER TABLE `barang_temuan`
  ADD CONSTRAINT `barang_temuan_ibfk_1` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laporan_kehilangan`
--
ALTER TABLE `laporan_kehilangan`
  ADD CONSTRAINT `laporan_kehilangan_ibfk_1` FOREIGN KEY (`id_pelapor`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `pencocokan`
--
ALTER TABLE `pencocokan`
  ADD CONSTRAINT `pencocokan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang_temuan` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pencocokan_ibfk_2` FOREIGN KEY (`id_laporan`) REFERENCES `laporan_kehilangan` (`id_laporan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pencocokan_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `serah_terima`
--
ALTER TABLE `serah_terima`
  ADD CONSTRAINT `serah_terima_ibfk_1` FOREIGN KEY (`id_pencocokan`) REFERENCES `pencocokan` (`id_pencocokan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `serah_terima_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
