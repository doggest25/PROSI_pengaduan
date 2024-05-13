-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2024 at 01:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prosi_pengaduan`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengaduan`
--

CREATE TABLE `jenis_pengaduan` (
  `id_jenis_pengaduan` bigint UNSIGNED NOT NULL,
  `pengaduan_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengaduan_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_pengaduan`
--

INSERT INTO `jenis_pengaduan` (`id_jenis_pengaduan`, `pengaduan_kode`, `pengaduan_nama`, `created_at`, `updated_at`) VALUES
(1, 'I-001', 'Jalan Rusak', NULL, '2024-04-13 20:21:37'),
(3, 'I-002', 'Got Bermasalah', '2024-04-08 21:34:54', '2024-04-08 21:34:54'),
(4, 'L-001', 'Pohon Tumbang', '2024-04-08 21:35:29', '2024-04-08 21:35:29'),
(5, 'L-002', 'Sampah Berserakan', '2024-04-08 21:36:16', '2024-04-08 21:36:16'),
(6, 'S-001', 'Kebisingan Warga', '2024-04-08 21:38:31', '2024-04-08 21:38:31'),
(7, 'S-002', 'Pertikaian Warga', '2024-04-08 21:39:11', '2024-04-08 21:39:11'),
(8, 'L-003', 'Penumpukan Sampah di TPS', '2024-04-08 21:43:04', '2024-04-08 21:43:04'),
(9, 'I-003', 'Lampu Jalan Mati', '2024-04-08 21:44:26', '2024-04-08 21:44:26'),
(10, 'K-001', 'Kriminalitas', '2024-04-08 21:47:09', '2024-04-08 22:41:10'),
(11, 'S-003', 'Warga Asing', '2024-04-08 22:00:26', '2024-04-08 22:00:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2024_04_06_075927_create_barang_table', 1),
(13, '2024_04_06_075955_create_v_level_table', 1),
(14, '2024_04_06_080049_create_v_user_table', 1),
(15, '2024_04_08_131157_create_jenis_pengaduan_table', 2),
(16, '2024_04_08_160406_create_v_pengaduan_table', 3),
(17, '2024_04_09_134511_create_status_pengaduan_table', 4),
(18, '2024_04_09_134919_create_detail_pengaduan_table', 5),
(19, '2024_04_09_135733_create_v_pengaduan_table', 6),
(20, '2024_04_09_135959_create_detail_pengaduan_table', 7),
(21, '2024_04_13_090641_create_v_pengaduan_table', 8),
(22, '2024_05_08_064914_create_v_pengaduan_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_pengaduan`
--

CREATE TABLE `status_pengaduan` (
  `id_status_pengaduan` bigint UNSIGNED NOT NULL,
  `status_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_pengaduan`
--

INSERT INTO `status_pengaduan` (`id_status_pengaduan`, `status_kode`, `status_nama`, `created_at`, `updated_at`) VALUES
(1, 'ON GOING', 'Diproses', NULL, NULL),
(2, 'ACCEPT', 'Diterima', NULL, NULL),
(3, 'DENIED', 'Ditolak', NULL, NULL),
(4, 'FINISH', 'Selesai', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `v_level`
--

CREATE TABLE `v_level` (
  `level_id` bigint UNSIGNED NOT NULL,
  `level_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `v_level`
--

INSERT INTO `v_level` (`level_id`, `level_kode`, `level_nama`, `created_at`, `updated_at`) VALUES
(1, 'WAR', 'Warga', NULL, NULL),
(2, 'ADM', 'Admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `v_pengaduan`
--

CREATE TABLE `v_pengaduan` (
  `id_pengaduan` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `id_jenis_pengaduan` bigint UNSIGNED NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_status_pengaduan` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `v_pengaduan`
--

INSERT INTO `v_pengaduan` (`id_pengaduan`, `user_id`, `id_jenis_pengaduan`, `deskripsi`, `lokasi`, `bukti_foto`, `id_status_pengaduan`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 'Pohon tumbang menghalangi jalan', 'jalan', 'public/bukti_foto/Uft8v6SKa8RBGXR3JiCeKLHn863uhyfg6eWM4phW.jpg', 4, '2024-05-08 14:05:52', '2024-05-10 14:50:29'),
(2, 6, 5, 'rame', 'jalan kembang', 'public/bukti_foto/L7erV0NdBt6eAbp0kyxsdCIFy64Js2kdZLJo1iUa.jpg', 4, '2024-05-09 14:07:15', '2024-05-10 14:50:43'),
(7, 6, 1, 'koko', 'eqeqewqe', 'public/bukti_foto/C12g7IGnEL8EayicDLg5kXxkAQe9nM9jhXLgWrp2.png', 1, '2024-05-12 14:06:38', '2024-05-12 14:12:04'),
(8, 6, 4, 'dsadasd', 'sasadas', 'public/bukti_foto/L6PmVHomfOd5GxPaoSrRZEgGa2HtvYHCheeJebjZ.jpg', 4, '2024-05-12 14:11:11', '2024-05-12 14:16:04'),
(9, 6, 1, 'fdgdfg', 'gfdg', 'public/bukti_foto/vnM4B7xgqEmfCLG9viIUd4jfc6a84eoX0sbglCzp.jpg', 1, '2024-05-12 14:21:15', '2024-05-12 14:21:15'),
(13, 6, 4, 'ffqfwqfwq', 'eqwe', 'public/bukti_foto/BcLoAf6N3Wr06nLKQ51GDrxpsfSTsbbah2gutlx6.jpg', 1, '2024-05-12 15:18:30', '2024-05-12 15:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `v_user`
--

CREATE TABLE `v_user` (
  `user_id` bigint UNSIGNED NOT NULL,
  `level_id` bigint UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ktp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `v_user`
--

INSERT INTO `v_user` (`user_id`, `level_id`, `username`, `nama`, `password`, `ktp`, `alamat`, `telepon`, `created_at`, `updated_at`) VALUES
(1, 1, 'yoga', 'Agusty Labdanayoga', '123', '3523132510030002', 'Merakurak, Tuban Jawa Timur', '089512097078', NULL, NULL),
(2, 1, 'adi', 'Adi Baskoro', '$2y$12$QBepAK4OU.8SYFliAQohNezXxSqtWUWfAbmXsKWw1LTefRcsNTphi', '252858582958292852', 'MALANG', '0827189521758', '2024-04-07 03:54:15', '2024-04-07 04:17:58'),
(3, 2, 'Edo', 'Edo Handoko', '$2y$12$.vAlAQKkZXYhRfUBfD2Zd.kRcAn.X.XN74KXvKL4wRRts2wGGs/g2', '6648374785738579', 'Lumajang', '089524129812', '2024-04-07 03:56:14', '2024-04-07 03:56:14'),
(5, 2, 'admin', 'AGUSTY LABDANAYOGA', '$2y$12$kYfyJ0Z6UfZv4xu9ieMYgOuU5/jHtM8GemQgiMUDtdM6yrILrZDyG', '6648374785738574', 'MALANG', '0827189521758', '2024-04-24 17:25:21', '2024-04-24 17:25:21'),
(6, 1, 'warga', 'Adi Nugroho', '$2y$12$Eswk/gwvi.v5taJRLk2mv.VS.yf0HV4gEHihRUGxrB8P0fc7oly4e', '6648374785738567', 'Lumajang', '089524129812', '2024-04-24 17:25:54', '2024-04-24 17:25:54'),
(7, 2, 'admin2', 'AGUSTY', '$2y$12$cMihe1H9wln2ceYKnwQTeOEMcQBR1Ljr0yUn/zx/5Yq7l7a7Yx5gK', '6648374785738544', 'MALANG', '0827189521758', '2024-04-25 14:00:55', '2024-04-25 14:00:55'),
(8, 1, 'warga2', 'Agusty Labdanayoga', '$2y$12$y0m9RvF7EruGbdGKGtPpjesGA/2Hou2BBuqLHpUkr/JmTbjtmylfS', '9323242452834724', 'TUBAN', '0827189521758', '2024-04-27 20:51:56', '2024-04-27 20:51:56'),
(9, 1, 'warga35', 'Adi Nugroho', '$2y$12$IxpDSjdeNOwQx22V9qLp.uNRqTZw6MKhlPLJewyCKMBc2T5eSOoXC', '6648374785738566', 'TUBAN', '0827189521758', '2024-04-27 21:13:47', '2024-05-04 17:49:46'),
(14, 1, 'warga232', 'AGUSTY LABDANAYOGA', '$2y$12$Bez7xzPLnHDOuwKG/aiIt.e6N8DVejRfy7zKpV2ADrj9Zhc0Awxze', '6648374785744', 'TUBAN', '0827189521758', '2024-05-08 12:36:23', '2024-05-08 12:36:23'),
(15, 1, 'ibad', 'ashalul ibad', '$2y$12$1DiTeiuMwW0dqIOvhufNL.NA/kGzmXfAo9sM6vIy1ybkvWkSU.EP6', '3449288293293', 'latsari,tuban', '0989372893', '2024-05-10 18:23:11', '2024-05-10 18:23:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_pengaduan`
--
ALTER TABLE `jenis_pengaduan`
  ADD PRIMARY KEY (`id_jenis_pengaduan`),
  ADD UNIQUE KEY `jenis_pengaduan_pengaduan_kode_unique` (`pengaduan_kode`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `status_pengaduan`
--
ALTER TABLE `status_pengaduan`
  ADD PRIMARY KEY (`id_status_pengaduan`),
  ADD UNIQUE KEY `status_pengaduan_status_kode_unique` (`status_kode`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `v_level`
--
ALTER TABLE `v_level`
  ADD PRIMARY KEY (`level_id`),
  ADD UNIQUE KEY `v_level_level_kode_unique` (`level_kode`);

--
-- Indexes for table `v_pengaduan`
--
ALTER TABLE `v_pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `v_pengaduan_user_id_foreign` (`user_id`),
  ADD KEY `v_pengaduan_id_jenis_pengaduan_foreign` (`id_jenis_pengaduan`),
  ADD KEY `v_pengaduan_id_status_pengaduan_foreign` (`id_status_pengaduan`);

--
-- Indexes for table `v_user`
--
ALTER TABLE `v_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `v_user_username_unique` (`username`),
  ADD UNIQUE KEY `v_user_ktp_unique` (`ktp`),
  ADD KEY `v_user_level_id_foreign` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_pengaduan`
--
ALTER TABLE `jenis_pengaduan`
  MODIFY `id_jenis_pengaduan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_pengaduan`
--
ALTER TABLE `status_pengaduan`
  MODIFY `id_status_pengaduan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `v_level`
--
ALTER TABLE `v_level`
  MODIFY `level_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `v_pengaduan`
--
ALTER TABLE `v_pengaduan`
  MODIFY `id_pengaduan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `v_user`
--
ALTER TABLE `v_user`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `v_pengaduan`
--
ALTER TABLE `v_pengaduan`
  ADD CONSTRAINT `v_pengaduan_id_jenis_pengaduan_foreign` FOREIGN KEY (`id_jenis_pengaduan`) REFERENCES `jenis_pengaduan` (`id_jenis_pengaduan`),
  ADD CONSTRAINT `v_pengaduan_id_status_pengaduan_foreign` FOREIGN KEY (`id_status_pengaduan`) REFERENCES `status_pengaduan` (`id_status_pengaduan`),
  ADD CONSTRAINT `v_pengaduan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `v_user` (`user_id`);

--
-- Constraints for table `v_user`
--
ALTER TABLE `v_user`
  ADD CONSTRAINT `v_user_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `v_level` (`level_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
