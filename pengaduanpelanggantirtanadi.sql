-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260810.843def3cd8
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 24, 2026 at 06:42 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengaduanpelanggantirtanadi`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pengaduans`
--

CREATE TABLE `kategori_pengaduans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_pengaduans`
--

INSERT INTO `kategori_pengaduans` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Air Mati', 'Air tidak mengalir sama sekali ke rumah pelanggan', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(2, 'Air Kecil', 'Aliran air kecil / tidak lancar', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(3, 'Air Keruh', 'Kualitas air keruh atau berwarna', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(4, 'Air Berbau', 'Air berbau tidak sedap', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(5, 'Air Tidak Normal', 'Kondisi air tidak normal lainnya', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(6, 'Bocor Pipa Dinas', 'Kebocoran pipa dinas menuju rumah pelanggan', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(7, 'Bocor Pipa Distribusi', 'Kebocoran pipa distribusi utama', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(8, 'Bocor Pipa Transmisi', 'Kebocoran pipa transmisi', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(9, 'Bocor Sekitar Meter/Kopling Bocor', 'Kebocoran di sekitar meteran atau sambungan kopling', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(10, 'Rehab Pipa Dinas', 'Perbaikan/rehabilitasi pipa dinas', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(11, 'Meter Mati', 'Meteran air tidak berfungsi/mati', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(12, 'Meter Pecah', 'Meteran air pecah', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(13, 'Meter Kabur', 'Angka pada meteran tidak terbaca jelas', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(14, 'Meter Kadaluarsa', 'Meteran sudah melewati masa pakai/tera', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(15, 'Meter Hilang', 'Meteran air hilang', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(16, 'Meter Labil', 'Putaran meteran tidak stabil', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(17, 'Meter Ragu', 'Pelanggan ragu keakuratan meteran', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(18, 'Pindah Letak Meter', 'Permintaan pemindahan letak meteran', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(19, 'Tinggikan Letak Meter', 'Permintaan peninggian letak meteran', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(20, 'Pasang Box Meter', 'Pemasangan box pelindung meteran', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(21, 'Pengaman Meter Tidak Ada', 'Pengaman/pelindung meteran tidak ada', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(22, 'Segel Meter/Kopling Putus', 'Segel meteran atau kopling putus', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(23, 'Pasang Kembali', 'Permintaan pemasangan kembali meteran', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(24, 'Stop Kran Tidak Berfungsi', 'Stop kran rusak atau tidak berfungsi', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(25, 'Bongkar Pasang Gate Valve', 'Bongkar pasang gate valve', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(26, 'Perbaikan Lubang Bor', 'Perbaikan lubang bor', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(27, 'Tutup Lobang Bor', 'Penutupan lubang bor', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(28, 'Bocor Lobang Bor', 'Kebocoran pada lubang bor', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(29, 'Pindah Lobang Bor', 'Permintaan pemindahan lubang bor', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(30, 'Tryhole', 'Pengecekan tryhole', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(31, 'Mencari Stratpot', 'Pencarian stratpot', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(32, 'Meninggikan Stratpot', 'Peninggian stratpot', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(33, 'Pemasangan Stratpot', 'Pemasangan stratpot baru', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(34, 'Saluran Air Limbah (SAL) Tersumbat Limbah Padat', 'SAL tersumbat limbah padat', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(35, 'Bak Kontrol Tersumbat Limbah Padat', 'Bak kontrol tersumbat limbah padat', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(36, 'IC Tersumbat Limbah Padat', 'IC (inspection chamber) tersumbat limbah padat', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(37, 'Pipa Limbah Rumah/Bak Kontrol/IC: Bocor/Pecah', 'Pipa limbah rumah, bak kontrol, atau IC bocor/pecah', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(38, 'Cover Bak Kontrol/IC: Rusak-Bocor-Tidak Ada', 'Cover bak kontrol/IC rusak, bocor, atau tidak ada', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(39, 'Komplain Tagihan', 'Kesalahan atau ketidaksesuaian tagihan', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(40, 'Pencatat Meter Tidak Datang', 'Petugas pencatat meter tidak datang sesuai jadwal', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(41, 'Konfirmasi No. Pelanggan', 'Konfirmasi nomor pelanggan (NPA)', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(42, 'Pasang Baru', 'Permohonan pemasangan sambungan baru', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(43, 'Kasus Pencurian Air', 'Laporan dugaan pencurian air', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(44, 'Bertanya Informasi', 'Pertanyaan umum seputar layanan PDAM', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(45, 'Lain-Lain', 'Keluhan di luar kategori di atas', '2026-08-20 12:32:03', '2026-08-20 12:32:03');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_12_000001_add_fields_to_users_table', 1),
(5, '2026_08_12_000002_create_kategori_pengaduans_table', 1),
(6, '2026_08_12_000003_create_pengaduans_table', 1),
(7, '2026_08_12_000004_create_tanggapan_pengaduans_table', 1),
(8, '2026_08_18_000001_create_pengaduan_fotos_table', 1),
(9, '2026_08_18_000002_drop_foto_column_from_pengaduans_table', 1),
(10, '2026_08_20_000001_add_nipp_to_users_table', 1),
(11, '2026_08_21_000001_add_pengecekan_status_to_pengaduans_table', 2),
(12, '2026_08_21_000002_create_tanggapan_fotos_table', 2);

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
-- Table structure for table `pengaduans`
--

CREATE TABLE `pengaduans` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pengaduan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pelapor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rumah_patokan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori_pengaduan_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_kejadian` text COLLATE utf8mb4_unicode_ci,
  `petugas_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('baru','pengecekan','diverifikasi','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baru',
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `tanggal_selesai` timestamp NULL DEFAULT NULL,
  `hasil_pemeriksaan` text COLLATE utf8mb4_unicode_ci,
  `perlu_spkp` enum('ya','tidak') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pemeriksaan` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduans`
--

INSERT INTO `pengaduans` (`id`, `kode_pengaduan`, `nama_pelapor`, `no_pelanggan`, `no_hp`, `email`, `alamat`, `no_rumah_patokan`, `kategori_pengaduan_id`, `judul`, `deskripsi`, `lokasi_kejadian`, `petugas_id`, `status`, `catatan_admin`, `tanggal_selesai`, `hasil_pemeriksaan`, `perlu_spkp`, `tanggal_pemeriksaan`, `created_at`, `updated_at`) VALUES
(1, 'PGD-20260820-00001', 'Imanuel Hulu', '0811231112', '085275363756', 'imanuelhulu01@gmail.com', 'Jl. Bkkbn No.1', 'No. 20', 7, 'Bongkar Pasang Pipa', 'Saya pengen bongkar pipa distribusi karna lagi ada kebocoran', 'Di pinggir jalan depan rumah', 2, 'selesai', NULL, '2026-08-21 08:24:20', 'Memang benar ada kebocoran di pipa distribusi', 'ya', '2026-08-21 08:17:32', '2026-08-20 13:30:34', '2026-08-21 08:24:20'),
(2, 'PGD-20260821-00001', 'Jonson Tampubolon', '0812998823', '089123453345', 'jonson@gmail.com', 'Jl. Hiu no. 23', 'No. 23', 39, 'Penurunan Tagihan Air', 'Saya berharap pdam mau menurunkan harga tarif rek air saya ....', 'Di dekat sekolah', 2, 'selesai', NULL, '2026-08-22 03:26:29', 'benar ada perbedaan tarif', 'ya', '2026-08-21 08:31:42', '2026-08-21 07:33:41', '2026-08-22 03:26:29'),
(3, 'PGD-20260822-00001', 'Imanuel Hulu', '1583513698', '085275363756', 'imanuelhulu01@gmail.com', 'Jl. Bkkbn No.1', 'bjssad', 43, 'Pipa bocor', 'qwodighogqodwgogdwqogowqgogogdqw', 'uguc', 2, 'selesai', NULL, '2026-08-22 03:44:44', 'Terjadi kebocoran', 'ya', '2026-08-22 03:43:48', '2026-08-22 03:31:37', '2026-08-22 03:44:44'),
(4, 'PGD-20260822-00002', 'Imanuel Hulu', NULL, '085275363756', 'imanuelhulu01@gmail.com', 'Jl. Bkkbn No.1', NULL, 39, 'adkjadfasfsaas', 'asdugousgaougdousagousgoudsa', NULL, 2, 'ditolak', 'tidak ada kebocoran', NULL, NULL, NULL, NULL, '2026-08-22 03:45:31', '2026-08-22 03:46:32'),
(5, 'PGD-20260822-00003', 'Imanuel Hulu', NULL, '085275363756', 'imanuelhulu01@gmail.com', 'Jl. Bkkbn No.1', NULL, 3, 'jyududutdutd', 'uyfffffffffffffffffffffffffffff', NULL, 2, 'selesai', NULL, '2026-08-22 03:53:06', 'kvvvjjv', 'tidak', '2026-08-22 03:51:41', '2026-08-22 03:47:57', '2026-08-22 03:53:06'),
(6, 'PGD-20260822-00004', 'Imanuel Hulu', NULL, '085275363756', 'imanuelhulu01@gmail.com', 'Jl. Bkkbn No.1', NULL, 38, 'iadgci', 'caohosfdfsdfsdsssssssssssssssssss', NULL, 2, 'diproses', NULL, NULL, 'Memang ada masalah', 'ya', '2026-08-23 05:07:36', '2026-08-22 05:16:30', '2026-08-23 05:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan_fotos`
--

CREATE TABLE `pengaduan_fotos` (
  `id` bigint UNSIGNED NOT NULL,
  `pengaduan_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduan_fotos`
--

INSERT INTO `pengaduan_fotos` (`id`, `pengaduan_id`, `path`, `created_at`, `updated_at`) VALUES
(1, 1, 'pengaduan/ArSVeYM6RGS7nm18hVyqe0yvkrNjcQGwlFG6RTbe.png', '2026-08-20 13:30:36', '2026-08-20 13:30:36'),
(2, 1, 'pengaduan/CXR0ln66vmGWVtTIoVDNfHJ2hgl6iVyCYT7TIkGa.png', '2026-08-20 13:30:36', '2026-08-20 13:30:36'),
(3, 1, 'pengaduan/s4IRCc4H74qPK6SjRGrk8cIiX6I59Fmao8ga97hm.png', '2026-08-20 13:30:36', '2026-08-20 13:30:36'),
(4, 1, 'pengaduan/IJrNalamni9wEHH4DAV4nBGdwo76ltgV4m3fwuK9.png', '2026-08-20 13:30:36', '2026-08-20 13:30:36'),
(5, 2, 'pengaduan/p0t91StOPvNQsfpO7LkJxEHdY9lgYETzdSIMLRqC.png', '2026-08-21 07:33:42', '2026-08-21 07:33:42'),
(6, 2, 'pengaduan/UmWxy5ikCTgKV27EdgG6iEn34zW1l5sS8kaExD5g.png', '2026-08-21 07:33:42', '2026-08-21 07:33:42'),
(7, 3, 'pengaduan/4TidGulAJOtFaixr4e5f0D13fPxJdPYU9I9rn76G.png', '2026-08-22 03:31:37', '2026-08-22 03:31:37'),
(8, 6, 'pengaduan/43AOOVI6N7lm4QEnEH8vePprJf9mZ7ggPQ8e5kFy.png', '2026-08-22 05:16:33', '2026-08-22 05:16:33'),
(9, 6, 'pengaduan/WOw2jSRQm6I8AdhPZRg6bp2kKmIlKLTRKFmo8HH9.png', '2026-08-22 05:16:33', '2026-08-22 05:16:33'),
(10, 6, 'pengaduan/13xLnfeqQKs1n8qlOmoSReZInmshc7eQlz7xJZZo.png', '2026-08-22 05:16:33', '2026-08-22 05:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('18FXVpy9BQQ0y9xkr70wEIvoxzA1LoHEc7L0WM8W', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJkRW43SWx0ZTY3UDE3Z2hsNnBPR0pUSXRXU3VNRFdKbVRaVVFzSDY4IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvcGVuZ2FkdWFucGVsYW5nZ2FudGlydGFuYWRpLnRlc3RcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1787465283),
('HYihKCxBPq3leYewr1Uucb0tmGA0j3L3r0eNR2Wt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIzYWpFbVg5dnBJbW1sSWdzRGFZZFhmczJQdkU3MmZkaXBsUlJtd1g0IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvcGVuZ2FkdWFucGVsYW5nZ2FudGlydGFuYWRpLnRlc3RcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1787528757),
('RgBfYfAtYZxCWoEkV9q6Uc7jwEveeiVSajyIYc8C', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJqOHJsdjJPMU5PTmlYVzRFaTlFUWs4TWh5QVlYWEhKZkpwcmJ4enZxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3BlbmdhZHVhbnBlbGFuZ2dhbnRpcnRhbmFkaS50ZXN0XC9sYWNhaz9rb2RlPVBHRC0yMDI2MDgyMC0wMDAwMSIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1787549334),
('YcjvCAVNNr9X89f1eYd4khH9IwZ8OkVxQ8xQOI3A', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIzQnlURGN1d3FJcVY2aXNyRHplSVRxdUJqbVRkRFVSWjIxWVZOQ3ZTIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3BlbmdhZHVhbnBlbGFuZ2dhbnRpcnRhbmFkaS50ZXN0LlwvbGFjYWs/a29kZT1QR0QtMjAyNjA4MjItMDAwMDEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787461873);

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan_fotos`
--

CREATE TABLE `tanggapan_fotos` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggapan_pengaduan_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tanggapan_fotos`
--

INSERT INTO `tanggapan_fotos` (`id`, `tanggapan_pengaduan_id`, `path`, `created_at`, `updated_at`) VALUES
(1, 3, 'dokumentasi/samxYTgXOBPM8HGqwg9Eg6bDA8UyZ7dURx9TzjTV.png', '2026-08-21 07:52:09', '2026-08-21 07:52:09'),
(2, 3, 'dokumentasi/CWLGEPuNVVZFb6BeT5WbrJYbHpbcmxqtVueyZDN4.png', '2026-08-21 07:52:09', '2026-08-21 07:52:09'),
(3, 3, 'dokumentasi/TJMTeof0tzUAmCDDaUn6wxD9OxEqDrB4hzrmjaBb.png', '2026-08-21 07:52:09', '2026-08-21 07:52:09'),
(4, 3, 'dokumentasi/KQFBcWAx5of9gLuCWVjqSANpmGPL0hFRLtQDssoj.png', '2026-08-21 07:52:09', '2026-08-21 07:52:09'),
(5, 3, 'dokumentasi/2yaVgUNA9gaSwQhgicEPwM0ww40sLIV0wO2Mzhqn.png', '2026-08-21 07:52:09', '2026-08-21 07:52:09'),
(6, 6, 'dokumentasi/dfJJptyRQoZqrPHZx6NZXPhYgWJTRG3xqA7Zd83s.png', '2026-08-21 08:21:00', '2026-08-21 08:21:00'),
(7, 6, 'dokumentasi/iSw9UHkZyXsFl0CrOS6uQncaKAqopPyeH1JAV24Y.png', '2026-08-21 08:21:00', '2026-08-21 08:21:00'),
(8, 8, 'dokumentasi/EEvlt8HyCY4AQP9T0eacviUD1apZrJlbehW5wWvX.png', '2026-08-21 08:23:08', '2026-08-21 08:23:08'),
(9, 8, 'dokumentasi/xPZQz31PhbGXGvbavEvkclQVa4JlvxH5ltdwzq3u.png', '2026-08-21 08:23:08', '2026-08-21 08:23:08'),
(10, 9, 'dokumentasi/KvKWgtL2NdKDRTfn71TAt9TFajBWbZQ1ib4t8Cl0.png', '2026-08-21 08:23:43', '2026-08-21 08:23:43'),
(11, 10, 'dokumentasi/SK8nfJ5aK0zE1VVeWrABeLclZRIDKIB4miVrS1x3.png', '2026-08-21 08:24:20', '2026-08-21 08:24:20'),
(12, 10, 'dokumentasi/aqsnD8cWJJ2Dy8yzffVei1W8r1KoQJNzq2LocY1U.png', '2026-08-21 08:24:20', '2026-08-21 08:24:20'),
(13, 16, 'dokumentasi/ZEXMxmnL1bSXv18TDWFDhGYoon9RizqwxZI80FB3.png', '2026-08-22 03:24:37', '2026-08-22 03:24:37'),
(14, 16, 'dokumentasi/KNfHJZgZKm2TVH74OWuZb9z92vXYWcctGxceetH7.png', '2026-08-22 03:24:37', '2026-08-22 03:24:37'),
(15, 17, 'dokumentasi/STPz32iuBkLFqlDOx3DI8DPC48YYPsfNmSzvtPIW.png', '2026-08-22 03:25:59', '2026-08-22 03:25:59'),
(16, 21, 'dokumentasi/Y872pMFdhK868L5VXTPySTxFSVMpu370qIFGMbKg.png', '2026-08-22 03:43:48', '2026-08-22 03:43:48'),
(17, 21, 'dokumentasi/0io8xNg4fgjkSPGhJuGSL4IUu22b1XwKvdlBdon1.png', '2026-08-22 03:43:48', '2026-08-22 03:43:48'),
(18, 23, 'dokumentasi/3FEne8M5si9mJte25boKUBBD5iWtf3egpTBaQJnA.png', '2026-08-22 03:44:20', '2026-08-22 03:44:20'),
(19, 30, 'dokumentasi/2nkVcQpq1mTBHbDBsGZNQvVFMHDNtbp19PZGr1Xn.png', '2026-08-22 03:51:41', '2026-08-22 03:51:41'),
(20, 32, 'dokumentasi/i4WjzzcXloTG2Sr0SeJfL5BoXoUEtrFEWOpVn2NA.png', '2026-08-22 03:52:18', '2026-08-22 03:52:18'),
(21, 33, 'dokumentasi/3sZRuOUz4iV003o1vR9oP91BQ7hWDC7l4i4HeUiM.png', '2026-08-22 03:52:35', '2026-08-22 03:52:35'),
(22, 37, 'dokumentasi/wjpRlfLGG5HlyNKewDSC4kzhtBf8OTHUlX5D1Xy2.png', '2026-08-23 05:07:37', '2026-08-23 05:07:37'),
(23, 39, 'dokumentasi/DwWcD2WvQ129SGEFwlNbx0Pjw6HP75KGjWD5Ow51.png', '2026-08-23 05:32:32', '2026-08-23 05:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan_pengaduans`
--

CREATE TABLE `tanggapan_pengaduans` (
  `id` bigint UNSIGNED NOT NULL,
  `pengaduan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_baru` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tanggapan_pengaduans`
--

INSERT INTO `tanggapan_pengaduans` (`id`, `pengaduan_id`, `user_id`, `pesan`, `status_baru`, `created_at`) VALUES
(1, 1, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', '2026-08-20 13:30:35'),
(2, 2, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', '2026-08-21 07:33:41'),
(3, 1, 1, 'Pengaduan sudah kami terima dan saat ini akan kami lakukan pengecekan secara langsung, terima kasih', 'pengecekan', '2026-08-21 07:52:09'),
(4, 1, 1, 'Hasil pemeriksaan: Memang benar ada kebocoran di pipa distribusi (Perlu SPKP)', NULL, '2026-08-21 08:17:32'),
(5, 1, 1, 'Pengaduan ditugaskan ke petugas: Petugas Lapangan 1.', NULL, '2026-08-21 08:18:33'),
(6, 1, 1, 'Berdasarkan pengecekan memang terjadi kebocoran di pipa distribusi, maka pekerja kami akan mulai melakukan perbaikan ke tempat kebocoran atas persetujuan bapak/ibuk, terima kasih', 'diverifikasi', '2026-08-21 08:21:00'),
(7, 1, 1, 'Pekerja lapangan akan melakukan perbaikan hari ini', 'diproses', '2026-08-21 08:22:21'),
(8, 1, 1, 'perbaikan pertama sudah dilakaukan di hari pertama', 'diproses', '2026-08-21 08:23:08'),
(9, 1, 1, 'perbaikan kedua', 'diproses', '2026-08-21 08:23:43'),
(10, 1, 1, 'Perbaikan telah selesai dilakaukan terima kasih', 'selesai', '2026-08-21 08:24:20'),
(11, 2, 1, 'Pengaduan ditugaskan ke petugas: Petugas Lapangan 1.', NULL, '2026-08-21 08:29:53'),
(12, 2, 1, 'Petugas kami akan melakukan pengecekan secara langsung ke tempat', 'pengecekan', '2026-08-21 08:30:36'),
(13, 2, 1, 'Hasil pemeriksaan: benar ada perbedaan tarif (Perlu SPKP)', NULL, '2026-08-21 08:31:42'),
(14, 2, 1, 'berdasarkan pengecekan asjokjk', 'diverifikasi', '2026-08-21 08:37:48'),
(15, 2, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', '2026-08-22 03:23:51'),
(16, 2, 1, 'perbaikan 1', NULL, '2026-08-22 03:24:36'),
(17, 2, 1, 'perbaikan 2', NULL, '2026-08-22 03:25:59'),
(18, 2, 1, 'Perbaikan telah selesai terima kasih', 'selesai', '2026-08-22 03:26:29'),
(19, 3, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', '2026-08-22 03:31:37'),
(20, 3, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', '2026-08-22 03:42:41'),
(21, 3, 1, 'Pengaduan telah diverifikasi. Hasil pemeriksaan: Terjadi kebocoran (Perlu SPKP).', 'diverifikasi', '2026-08-22 03:43:48'),
(22, 3, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', '2026-08-22 03:44:06'),
(23, 3, 1, 'avkjvas', NULL, '2026-08-22 03:44:20'),
(24, 3, 1, 'asoguasodg', 'selesai', '2026-08-22 03:44:44'),
(25, 4, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', '2026-08-22 03:45:31'),
(26, 4, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', '2026-08-22 03:46:11'),
(27, 4, 1, 'Pengaduan ditolak. Alasan: tidak ada kebocoran', 'ditolak', '2026-08-22 03:46:32'),
(28, 5, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', '2026-08-22 03:47:57'),
(29, 5, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', '2026-08-22 03:51:00'),
(30, 5, 1, 'Pengaduan telah diverifikasi. Hasil pemeriksaan: kvvvjjv (Tidak Perlu SPKP).', 'diverifikasi', '2026-08-22 03:51:41'),
(31, 5, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', '2026-08-22 03:51:58'),
(32, 5, 1, 'jhcihcic', NULL, '2026-08-22 03:52:18'),
(33, 5, 1, 'jvovov', NULL, '2026-08-22 03:52:35'),
(34, 5, 1, 'vvuvouv', 'selesai', '2026-08-22 03:53:06'),
(35, 6, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', '2026-08-22 05:16:31'),
(36, 6, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', '2026-08-23 05:06:57'),
(37, 6, 1, 'Pengaduan telah diverifikasi. Hasil pemeriksaan: Memang ada masalah (Perlu SPKP).', 'diverifikasi', '2026-08-23 05:07:36'),
(38, 6, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', '2026-08-23 05:31:10'),
(39, 6, 1, 'asjbkjga', NULL, '2026-08-23 05:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nipp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nipp`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin PDAM Padang Bulan', '19850101202201001', 'admin@pdamtirtanadi.test', NULL, 'admin', NULL, '$2y$12$rXy85kzzAsLOIXLaCNtDx.sD/T3m5LHAr7h/fJhJCgRIktH2iaoC.', 'iFi7bStWkaMC8Ijjv0ZwIns7SFPP45cDjxxlGSU8HmYxJQN52tDp4CwminOU', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(2, 'Petugas Lapangan 1', '19900202202201002', 'petugas@pdamtirtanadi.test', NULL, 'petugas', NULL, '$2y$12$7WL2W.usZr.CI/mcz0hbyO4MRrWh/iCucjgnL5attIIl8fqu8dDFu', NULL, '2026-08-20 12:32:03', '2026-08-20 12:32:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_pengaduans`
--
ALTER TABLE `kategori_pengaduans`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `pengaduans`
--
ALTER TABLE `pengaduans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengaduans_kode_pengaduan_unique` (`kode_pengaduan`),
  ADD KEY `pengaduans_kategori_pengaduan_id_foreign` (`kategori_pengaduan_id`),
  ADD KEY `pengaduans_petugas_id_foreign` (`petugas_id`);

--
-- Indexes for table `pengaduan_fotos`
--
ALTER TABLE `pengaduan_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_fotos_pengaduan_id_foreign` (`pengaduan_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tanggapan_fotos`
--
ALTER TABLE `tanggapan_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggapan_fotos_tanggapan_pengaduan_id_foreign` (`tanggapan_pengaduan_id`);

--
-- Indexes for table `tanggapan_pengaduans`
--
ALTER TABLE `tanggapan_pengaduans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggapan_pengaduans_pengaduan_id_foreign` (`pengaduan_id`),
  ADD KEY `tanggapan_pengaduans_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nipp_unique` (`nipp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_pengaduans`
--
ALTER TABLE `kategori_pengaduans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengaduans`
--
ALTER TABLE `pengaduans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengaduan_fotos`
--
ALTER TABLE `pengaduan_fotos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tanggapan_fotos`
--
ALTER TABLE `tanggapan_fotos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tanggapan_pengaduans`
--
ALTER TABLE `tanggapan_pengaduans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengaduans`
--
ALTER TABLE `pengaduans`
  ADD CONSTRAINT `pengaduans_kategori_pengaduan_id_foreign` FOREIGN KEY (`kategori_pengaduan_id`) REFERENCES `kategori_pengaduans` (`id`),
  ADD CONSTRAINT `pengaduans_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pengaduan_fotos`
--
ALTER TABLE `pengaduan_fotos`
  ADD CONSTRAINT `pengaduan_fotos_pengaduan_id_foreign` FOREIGN KEY (`pengaduan_id`) REFERENCES `pengaduans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tanggapan_fotos`
--
ALTER TABLE `tanggapan_fotos`
  ADD CONSTRAINT `tanggapan_fotos_tanggapan_pengaduan_id_foreign` FOREIGN KEY (`tanggapan_pengaduan_id`) REFERENCES `tanggapan_pengaduans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tanggapan_pengaduans`
--
ALTER TABLE `tanggapan_pengaduans`
  ADD CONSTRAINT `tanggapan_pengaduans_pengaduan_id_foreign` FOREIGN KEY (`pengaduan_id`) REFERENCES `pengaduans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tanggapan_pengaduans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
