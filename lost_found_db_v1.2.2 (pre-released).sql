-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 05:32 AM
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
(3, 'Kucing Oranye', 'Kucing jantan oranye, nama Mochi, pakai kalung merah', 'Pets', NULL, 'Stasiun Tanah Abang Baru', '2025-01-12 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(4, 'Tas Ransel Biru Navy', 'Tas ransel merk Eiger warna biru, ada pin anime', 'Bags', NULL, 'Stasiun Duri', '2025-01-13 00:00:00', 'resolved', 'found', 1, '2026-03-12 03:48:53'),
(5, 'Kunci Motor Yamaha', 'Gantungan kunci bentuk bola, ada chip motor Yamaha NMAX', 'Keys', NULL, 'Parkiran Stasiun Manggarai', '2025-01-14 00:00:00', 'open', 'lost', 1, '2026-03-12 03:48:53'),
(6, 'Gelang Perak', 'Gelang perak ukiran bunga, ada inisial \"R.A\" di dalam', 'Jewelry', NULL, 'Stasiun Tanjung Priuk', '2025-01-15 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(7, 'Kartu Pelajar SMA 17', 'Kartu pelajar atas nama Budi Santoso kelas XII IPA 2', 'Documents', NULL, 'Stasiun Cisauk deket alfamart', '2025-01-16 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(8, 'AirPods Pro Gen 2', 'AirPods Pro putih, case ada stiker planet saturnus', 'Electronics', NULL, 'Cafe Kopi Kenangan Sudirman', '2025-01-17 00:00:00', 'open', 'lost', 1, '2026-03-12 03:48:53'),
(9, 'Jaket Hoodie Abu-abu', 'Hoodie polos abu-abu ukuran L, merk Uniqlo', 'Clothing', NULL, 'Stasiun Manggarai ', '2025-01-18 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(10, 'Buku Catatan Cokelat', 'Buku catatan hardcover cokelat, isi coretan kuliah', 'Other', NULL, 'Stasiun Universitas Indonesia Depok', '2025-01-19 00:00:00', 'open', 'lost', 1, '2026-03-12 03:48:53'),
(11, 'Sepeda Lipat Brompton', 'Sepeda lipat warna hijau army, ada stiker nama owner', 'Other', NULL, 'Stasiun Rangkasbelitung', '2025-01-20 00:00:00', 'resolved', 'found', 1, '2026-03-12 03:48:53'),
(12, 'Power Bank Xiaomi', 'Power bank 20000mAh warna putih, ada nama \"Dian\" di belakang', 'Electronics', NULL, 'Stasiun Sudirman', '2025-01-21 00:00:00', 'open', 'found', 1, '2026-03-12 03:48:53'),
(13, 'Sata Andagi', 'Sata Andagi enak banget', 'Other', 'barang_69ba4b10e1345.jpg', 'Stasiun Lempuangan', '2026-03-18 00:00:00', 'open', 'found', 5, '2026-03-18 06:49:52'),
(14, 'Sata Andagi', 'Sata Andagi enak banget', 'Other', 'barang_69ba4ee7bdceb.jpg', 'Stasiun Lempuangan', '2026-03-18 00:00:00', 'open', 'found', 5, '2026-03-18 07:06:15'),
(15, 'Sata Andagi', 'Sata Andagi enak banget', 'Other', 'barang_69ba4effc107b.jpg', 'Stasiun Lempuangan', '2026-03-18 00:00:00', 'open', 'found', 5, '2026-03-18 07:06:39'),
(16, 'Sata Andagi (makanan)', 'Warananya coklat, sejenis donat jepang', 'Other', 'barang_69ba902024a9e.jpg', 'Stasiun Sudirman', '2026-03-18 00:00:00', 'resolved', 'found', 5, '2026-03-18 11:44:32'),
(17, 'Ipod Touch 4', 'Warna putih trus ada goresan di layarnya', 'Electronics', 'barang_69bec15ecfd39.jpg', 'Stasiun Bogor', '2026-03-21 00:00:00', 'resolved', 'found', 5, '2026-03-21 16:03:42'),
(18, 'Tumbler Tuku Stainless Biru', 'Warna biru, yang lagi viral', 'Other', 'barang_69bec1bd4ad28.jpg', 'Stasiun Rangkas Belitung', '2026-03-21 00:00:00', 'open', 'lost', 5, '2026-03-21 16:05:17'),
(19, 'crown burger king', 'berwarna coklat, topi raja burger king', 'Accessories', 'barang_69bffe74db528.jpg', 'Stasiun Karet - Peron 2', '2026-03-21 00:00:00', 'resolved', 'found', 7, '2026-03-22 14:36:36');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_kehilangan`
--

CREATE TABLE `laporan_kehilangan` (
  `id_laporan` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `category` varchar(80) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `lokasi_kehilangan` varchar(150) NOT NULL,
  `tanggal_kehilangan` datetime NOT NULL,
  `status` enum('open','resolved','closed') DEFAULT 'open',
  `type` enum('lost','found') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_pelapor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_kehilangan`
--

INSERT INTO `laporan_kehilangan` (`id_laporan`, `nama_barang`, `deskripsi`, `category`, `image`, `lokasi_kehilangan`, `tanggal_kehilangan`, `status`, `type`, `created_at`, `id_pelapor`) VALUES
(1, 'Dompet Kulit Hitam', 'Dompet warna hitam berisi KTP dan kartu ATM BCA', 'Accessories\n', NULL, 'Stasiun Tanah Abang Gerbong 3', '2026-03-10 00:00:00', 'open', 'lost', '2026-03-15 16:32:42', 3),
(2, 'Apple Airpods', 'twsnya apple warna putih', 'Electronics', NULL, 'Stasiun Nambo', '2026-03-16 00:00:00', 'open', 'found', '2026-03-16 04:15:54', 3),
(4, 'Buku Japanese Culture Through VideoGames by Rachael Huthinson', 'Buku bacaan jepang', 'Other', 'laporan_69b912415f2b6.jpg', 'Stasiun Cikarang', '2026-03-17 00:00:00', 'resolved', 'found', '2026-03-17 08:35:13', 3),
(5, 'CD Single Lagu Jepang', 'Aimer', 'Other', NULL, 'Stasiun Tanah Abang', '2026-02-14 00:00:00', 'open', 'found', '2026-03-17 14:16:52', 4),
(6, 'album aimer yang ke 4', 'album lagu aku ilang', 'Other', 'laporan_69ba9a285520b.jpg', 'Stasiun Jakarta Kota', '2026-03-17 00:00:00', 'open', 'lost', '2026-03-17 16:00:14', 4),
(7, 'album weezer', 'album weezer limited yang ada csm nya ilang, ini kalo ga ketemu ganti rugi woiiii', 'Documents', NULL, 'Stasiun Jakarta Kota', '2026-03-17 00:00:00', 'open', 'found', '2026-03-17 16:00:47', 4),
(8, 'Sata Andagi', 'coklat donat manis, ilang\r\n\r\nkurang lebih kaya digambar thanks', 'Other', 'laporan_69bacd6ee5a2c.jpg', 'Stasiun Sudirman', '2026-03-18 00:00:00', 'open', 'found', '2026-03-18 16:06:06', 4),
(9, 'Sata Andagi', 'bulet kaya takoyaki, tapii kek donat versi jepang manis trus coklat yang suka dimakan sama osaka-san di azumanga daioh', 'Other', 'laporan_69bacfd715d15.jpg', 'Stasiun Sudirman', '2026-03-18 00:00:00', 'closed', 'found', '2026-03-18 16:16:23', 4),
(10, 'Ipod Touch 4', 'Handphone apple yang hanya digunakan untuk musikan aja, kecil mungil trus ada goresan dikit di layarnya', 'Electronics', 'laporan_69bec115153ef.png', 'Stasiun Bogor', '2026-03-19 00:00:00', 'closed', 'found', '2026-03-21 16:02:29', 4),
(11, 'crown burger king', 'crown burger king yang warna gold itu hilang', 'Accessories', 'laporan_69bff31ab4504.jpg', 'Stasiun Lempuangan', '2026-03-13 00:00:00', 'resolved', 'found', '2026-03-22 13:48:10', 6),
(12, 'asdsad', 'asdsad', 'Electronics', NULL, 'asdasdas', '2026-03-22 00:00:00', 'resolved', 'lost', '2026-03-22 16:50:47', 6);

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

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id_news`, `title`, `body`, `author_id`, `created_at`) VALUES
(10, 'Update Sistem: Notifikasi Real-time', 'Kami telah memperbarui sistem notifikasi. Pengguna kini akan mendapatkan update real-time melalui email ketika ada barang temuan yang cocok dengan laporan kehilangan mereka.', 5, '2026-03-18 11:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `pencocokan`
--

CREATE TABLE `pencocokan` (
  `id_pencocokan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_laporan` int(11) NOT NULL,
  `tanggal_pencocokan` datetime DEFAULT current_timestamp(),
  `note` varchar(300) DEFAULT NULL,
  `status_verifikasi` enum('process','approved','rejected') DEFAULT 'process',
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pencocokan`
--

INSERT INTO `pencocokan` (`id_pencocokan`, `id_barang`, `id_laporan`, `tanggal_pencocokan`, `note`, `status_verifikasi`, `id_petugas`) VALUES
(2, 8, 2, '2026-03-18 22:44:10', NULL, '', 5),
(3, 16, 8, '2026-03-18 23:07:07', 'ini tuh punya saya', 'rejected', 5),
(4, 16, 9, '2026-03-18 23:17:28', 'seperti punya saya, because rasanya sama dan lokasi hilangnya sama, pak pls hubungi saya', 'approved', 5),
(5, 17, 10, '2026-03-21 23:09:47', 'Ciri cirinya mirip dan lokasi ditemukannya sama dengan laporan saya, mohon di selidiki sepertinya ini barang saya', 'approved', 5),
(6, 19, 11, '2026-03-22 21:39:21', 'Ciri cirinya sama seperti di laporan saya namun kenapa nyasarnya sampai di stasiun karet ya?', 'approved', 7),
(7, 18, 12, '2026-03-23 01:13:50', NULL, 'rejected', 7);

-- --------------------------------------------------------

--
-- Table structure for table `serah_terima`
--

CREATE TABLE `serah_terima` (
  `id_serah_terima` int(11) NOT NULL,
  `id_pencocokan` int(11) NOT NULL,
  `tanggal_serah_terima` datetime DEFAULT current_timestamp(),
  `nama_penerima` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_pelapor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `serah_terima`
--

INSERT INTO `serah_terima` (`id_serah_terima`, `id_pencocokan`, `tanggal_serah_terima`, `nama_penerima`, `keterangan`, `id_petugas`, `id_pelapor`) VALUES
(1, 4, '2026-03-18 23:19:45', 'aimer my doiii', 'Temui aimyon, di stasiun sudirman untuk serah terima sata andagi yang tertinggal\r\n\r\nJam 15:45 di peron 1\r\nTerima kasih telah menggunakan LostnFoun KRL Commuterlink', 5, 4),
(2, 5, '2026-03-21 23:12:59', 'aimer my doiii', 'Temui saya, di stasiun bogor untuk serah terima ipodnya yang tertinggal Jam 21:45 di peron 3 Terima kasih telah menggunakan LostnFound KRL Commuterlink ????????', 5, 4),
(3, 6, '2026-03-22 22:55:10', 'kinechi', 'Temui saya di Stasiun Karet di dekat pos pada jam 12:10 siang, saya tunggu kehadirannya. Terima Kasih telah menggunakan jasa LostnFound ????', 7, 6);

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
(1, NULL, 'Joshua', 'joshua@gmail.com', '$2y$10$T6pKQM8IJ27gsQ.O.h2yQetLMwin1cDxs6GnmC4TADAfMAvrMZB/2', 'staff', 'email', NULL, '2026-03-12 03:48:53'),
(2, NULL, 'John Doe', 'johndoe@gmail.com', 'johndoe@gmail.com', 'user', 'email', NULL, '2026-03-14 18:16:29'),
(3, NULL, 'johndoe', 'johndoee@gmail.com', '$2y$10$7IZYs5hidiU2o1waHfo.v.4ry8ZHoFoKwJUV/9Qt01AxcNd1Nkzi.', 'user', 'email', NULL, '2026-03-15 07:47:47'),
(4, 'avatars/avatar_4_1773834735.jpg', 'aimer my doiii', 'aimermyayank@gmail.com', '$2y$10$wWLnMwfW5gxyW3AHxKA0Xefz5Xy660vzpRxIYROc5nZgztpgod8am', 'user', 'email', NULL, '2026-03-17 14:16:16'),
(5, 'avatars/avatar_5_1773815291.jpg', 'aimyon', 'aimyonstaff@gmail.com', '$2y$10$cfTlXQAiRBSLDhAarF6i4u2e3A1hQQsVtlalVLXBObXzB6HeW7xnC', 'staff', 'email', NULL, '2026-03-17 16:30:30'),
(6, 'avatars/avatar_6_1774196238.jpg', 'kinechi', 'kinechi@gmail.com', '$2y$10$Aym.zSusA3NJKPTpYJIdgORn3MJK.GMzVW5htvMP2VUTHNha7FkMa', 'user', 'email', NULL, '2026-03-22 13:45:31'),
(7, 'avatars/avatar_7_1774190292.jpg', 'hikari', 'hikari.fl@gmail.com', '$2y$10$DdHC1WT3b0mtYxGPP9p/m.lEkPDYnfDsz1p/sKOQLTlkITe1rKCkm', 'staff', 'email', NULL, '2026-03-22 13:50:43');

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
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_pelapor` (`id_pelapor`);

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
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `laporan_kehilangan`
--
ALTER TABLE `laporan_kehilangan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pencocokan`
--
ALTER TABLE `pencocokan`
  MODIFY `id_pencocokan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `serah_terima`
--
ALTER TABLE `serah_terima`
  MODIFY `id_serah_terima` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `laporan_kehilangan_ibfk_1` FOREIGN KEY (`id_pelapor`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `pencocokan_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `serah_terima`
--
ALTER TABLE `serah_terima`
  ADD CONSTRAINT `serah_terima_ibfk_1` FOREIGN KEY (`id_pencocokan`) REFERENCES `pencocokan` (`id_pencocokan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `serah_terima_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `serah_terima_ibfk_3` FOREIGN KEY (`id_pelapor`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
