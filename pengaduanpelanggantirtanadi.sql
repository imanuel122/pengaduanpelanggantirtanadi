-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260810.843def3cd8
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2026 at 04:58 PM
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
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(12, '2026_08_21_000002_create_tanggapan_fotos_table', 2),
(13, '2026_08_25_000001_add_biaya_dan_persetujuan_to_pengaduans_table', 3),
(14, '2026_08_25_000002_add_dokumen_biaya_dan_bukti_pembayaran_to_pengaduans_table', 4),
(15, '2026_08_25_000003_add_data_surat_status_to_pengaduans_table', 5),
(16, '2026_08_25_000004_pisah_surat_pengecekan_dan_verifikasi', 6),
(17, '2026_08_26_000001_tambah_tanggal_ditolak', 7),
(19, '2026_08_29_000001_add_edited_at_to_tanggapan_pengaduans_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduans`
--

CREATE TABLE `pengaduans` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_pengaduan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pelapor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pelanggan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rumah_patokan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori_pengaduan_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_kejadian` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `petugas_id` bigint UNSIGNED DEFAULT NULL,
  `jadwal_pengecekan` datetime DEFAULT NULL,
  `tanggal_mulai_pengecekan` datetime DEFAULT NULL,
  `petugas_pengecekan_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai_proses` datetime DEFAULT NULL,
  `pelaksana_proses_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('baru','pengecekan','menunggu_persetujuan','menunggu_verifikasi_pembayaran','diverifikasi','diproses','selesai','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baru',
  `catatan_admin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal_selesai` timestamp NULL DEFAULT NULL,
  `catatan_selesai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hasil_pemeriksaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `perlu_spkp` enum('ya','tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rincian_biaya` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rincian_biaya_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rincian_biaya_file_nama_asli` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_biaya` decimal(12,2) DEFAULT NULL,
  `status_persetujuan` enum('menunggu','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_persetujuan` timestamp NULL DEFAULT NULL,
  `catatan_persetujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_pembayaran_nama_asli` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_verifikasi_pembayaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal_ditolak` datetime DEFAULT NULL,
  `tanggal_pemeriksaan` timestamp NULL DEFAULT NULL,
  `tanggal_diverifikasi` datetime DEFAULT NULL,
  `tanggapan_pengecekan_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduans`
--

INSERT INTO `pengaduans` (`id`, `kode_pengaduan`, `nama_pelapor`, `no_pelanggan`, `no_hp`, `email`, `alamat`, `no_rumah_patokan`, `kategori_pengaduan_id`, `judul`, `deskripsi`, `lokasi_kejadian`, `petugas_id`, `jadwal_pengecekan`, `tanggal_mulai_pengecekan`, `petugas_pengecekan_nama`, `tanggal_mulai_proses`, `pelaksana_proses_nama`, `status`, `catatan_admin`, `tanggal_selesai`, `catatan_selesai`, `hasil_pemeriksaan`, `perlu_spkp`, `rincian_biaya`, `rincian_biaya_file`, `rincian_biaya_file_nama_asli`, `total_biaya`, `status_persetujuan`, `tanggal_persetujuan`, `catatan_persetujuan`, `bukti_pembayaran`, `bukti_pembayaran_nama_asli`, `catatan_verifikasi_pembayaran`, `tanggal_ditolak`, `tanggal_pemeriksaan`, `tanggal_diverifikasi`, `tanggapan_pengecekan_id`, `created_at`, `updated_at`) VALUES
(1, 'PGD-20260820-00001', 'Rudi Hartono', '0834987823', '085275363756', 'rudi.hartono82@gmail.com', 'Jl. Jamin Ginting Gg. Mawar No. 7, Padang Bulan', 'Dekat kedai sampah Pak Ucok', 7, 'Bongkar Pasang Pipa', 'Saya pengen bongkar pipa distribusi karna lagi ada kebocoran', 'Di pinggir jalan depan rumah', 2, NULL, NULL, NULL, NULL, NULL, 'selesai', NULL, '2026-08-21 08:24:20', NULL, 'Memang benar ada kebocoran di pipa distribusi', 'ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-21 08:17:32', NULL, NULL, '2026-08-20 13:30:34', '2026-08-21 08:24:20'),
(2, 'PGD-20260821-00001', 'Jonson Tampubolon', '0817654321', '0882016639966', 'jonsontampubolon@gmail.com', 'Jl. Karya Wisata No. 23, Tanjung Sari', 'Sebelah bengkel motor', 39, 'Penurunan Tagihan Air', 'Saya berharap pdam mau menurunkan harga tarif rek air saya ....', 'Di dekat sekolah', 2, NULL, NULL, NULL, NULL, NULL, 'selesai', NULL, '2026-08-22 03:26:29', NULL, 'benar ada perbedaan tarif', 'ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-21 08:31:42', NULL, NULL, '2026-08-21 07:33:41', '2026-08-22 03:26:29'),
(3, 'PGD-20260822-00001', 'Siti Aminah', '0845123967', '085275363756', 'sitiaminah03@gmail.com', 'Jl. Bunga Terompet No. 5, Padang Bulan Selayang II', 'Dekat pos ronda', 43, 'Dugaan Pencurian Air', 'Saya curiga ada yang nyambung pipa air secara ilegal di dekat rumah saya, airnya jadi kecil terus', 'Dekat gorong-gorong pinggir jalan', 2, NULL, NULL, NULL, NULL, NULL, 'selesai', NULL, '2026-08-22 03:44:44', NULL, 'Ditemukan sambungan pipa ilegal yang menyadap dari pipa dinas pelanggan', 'ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 03:43:48', NULL, NULL, '2026-08-22 03:31:37', '2026-08-22 03:44:44'),
(4, 'PGD-20260822-00002', 'Dedi Saputra', '0862390174', '0882016639966', 'dedisaputra.medan@gmail.com', 'Jl. Setia Budi Gg. Sepakat No. 12, Tanjung Sari', NULL, 39, 'Tagihan Air Naik Drastis', 'Tagihan bulan ini naik jauh dari biasanya padahal pemakaian saya sama saja', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'ditolak', 'Setelah dicek, tagihan sudah sesuai dengan angka meteran dan pemakaian aktual, tidak ada kesalahan pencatatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 03:45:31', '2026-08-22 03:46:32'),
(5, 'PGD-20260822-00003', 'Ratna Sari Dewi', '0819482756', '085275363756', 'ratnasaridewi5@gmail.com', 'Jl. Flamboyan Raya No. 9, Padang Bulan', 'Rumah cat kuning', 3, 'Air Keruh Sejak Kemarin', 'Air yang keluar dari keran rumah saya keruh dan agak kekuningan sejak kemarin sore', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'selesai', NULL, '2026-08-22 03:53:06', NULL, 'Air keruh disebabkan pengurasan pipa distribusi, sudah kembali normal setelah dibilas', 'tidak', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-22 03:51:41', NULL, NULL, '2026-08-22 03:47:57', '2026-08-22 03:53:06'),
(6, 'PGD-20260822-00004', 'Bambang Wijaya', '0873654921', '0882016639966', 'bambang.wijaya77@yahoo.com', 'Jl. Karya Bakti No. 18, Simpang Selayang', NULL, 38, 'Tutup Bak Kontrol Rusak', 'Tutup bak kontrol di depan rumah saya retak dan agak berbahaya kalau diinjak', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'diproses', NULL, NULL, NULL, 'Cover bak kontrol memang retak dan perlu diganti', 'ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-23 05:07:36', NULL, NULL, '2026-08-22 05:16:30', '2026-08-23 05:31:10'),
(7, 'PGD-20260825-00001', 'Novita Sari', '0856219473', '085275363756', 'novitasari.ns@gmail.com', 'Jl. Bunga Cempaka No. 4, Padang Bulan Selayang I', 'Dekat warung Bu Ida', 38, 'Cover Bak Kontrol Hilang', 'Tutup bak kontrol air limbah di depan rumah saya hilang, jadi terbuka begitu saja', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'selesai', NULL, '2026-08-25 03:55:57', NULL, 'Cover bak kontrol memang tidak ada, perlu dipasang cover baru', 'ya', 'Biaya pengadaan dan pemasangan cover bak kontrol baru', NULL, NULL, 1500000.00, 'disetujui', '2026-08-25 03:54:23', NULL, NULL, NULL, NULL, NULL, '2026-08-25 03:52:37', NULL, NULL, '2026-08-25 03:47:18', '2026-08-25 03:55:57'),
(8, 'PGD-20260825-00002', 'Hendra Gunawan', '0891736450', '0882016639966', 'hendragunawan91@gmail.com', 'Jl. Karya Jaya No. 31, Gedung Johor', NULL, 36, 'IC Tersumbat', 'Saluran IC (inspection chamber) di rumah saya tersumbat, air limbah jadi meluap', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'IC tersumbat limbah padat, perlu dibersihkan', 'ya', 'Biaya pembersihan IC dari sumbatan limbah padat', NULL, NULL, 1250000.00, 'disetujui', '2026-08-25 04:22:56', NULL, NULL, NULL, NULL, NULL, '2026-08-25 04:20:38', NULL, NULL, '2026-08-25 04:18:46', '2026-08-25 04:22:56'),
(9, 'PGD-20260825-00003', 'Yanti Br Sitorus', '0827450918', '085275363756', 'yantisitorus09@gmail.com', 'Jl. Bunga Sedap Malam No. 6, Padang Bulan', NULL, 44, 'Tanya Cara Bayar Tagihan Online', 'Saya mau tanya cara bayar tagihan air PDAM online, soalnya males antri di kantor', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'ditolak', 'Dibatalkan oleh pelanggan (tidak menyetujui biaya perbaikan).', NULL, NULL, 'Sudah dijelaskan cara pembayaran online melalui aplikasi mitra PDAM', 'ya', 'Biaya admin layanan informasi', NULL, NULL, 10000.00, 'ditolak', '2026-08-25 04:26:09', 'tunda dulu', NULL, NULL, NULL, NULL, '2026-08-25 04:25:23', NULL, NULL, '2026-08-25 04:24:00', '2026-08-25 04:26:09'),
(10, 'PGD-20260825-00004', 'Agus Salim', '0864921038', '0882016639966', 'agussalim.10@gmail.com', 'Jl. Berlian Sakti No. 15, Simpang Selayang', 'Dekat mesjid Al-Ikhlas', 2, 'Air Kecil Setiap Sore', 'Air di rumah saya kecil banget kalau sore, kadang sampai mati total', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Tekanan air memang kecil di jam-jam sore, kemungkinan karena pemakaian puncak', 'ya', 'sadhkjdsbaja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 04:31:30', NULL, NULL, '2026-08-25 04:29:35', '2026-08-25 04:31:30'),
(11, 'PGD-20260825-00005', 'Maria Simanjuntak', '0835672190', '085275363756', 'mariasimanjuntak@gmail.com', 'Jl. Sempurna No. 22, Medan Tuntungan', NULL, 7, 'Pipa Distribusi Bocor Lagi', 'Ada rembesan air terus menerus dari pipa distribusi dekat rumah, khawatir makin parah', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'menunggu_verifikasi_pembayaran', NULL, NULL, NULL, 'Benar ada kebocoran kecil pada pipa distribusi, perlu penambalan', 'ya', NULL, 'rincian-biaya/etIFJXdwstUY68V6Akv1sTNMm24OPTzzMOGRp0eI.docx', 'rincian biaya.docx', 500000.00, 'disetujui', '2026-08-25 07:17:10', NULL, 'bukti-pembayaran/EusM4H8pRjwyGkdbTY0BH7LYUPkTDlfpZU0a1dnd.png', 'Screenshot (3).png', NULL, NULL, '2026-08-25 07:11:15', NULL, NULL, '2026-08-25 07:05:21', '2026-08-25 07:17:10'),
(12, 'PGD-20260825-00006', 'Rizky Ramadhan', '0848210967', '0882016639966', 'rizkyramadhan12@gmail.com', 'Jl. Bunga Asoka No. 11, Padang Bulan', 'Sebelah salon Cantika', 8, 'Pipa Transmisi Bocor Besar', 'Ada semburan air lumayan besar dari arah pipa transmisi utama dekat gang rumah', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'selesai', NULL, '2026-08-25 07:31:26', NULL, 'Terjadi kebocoran besar pada pipa transmisi, perlu perbaikan segera', 'ya', NULL, 'rincian-biaya/GQfFlyPXyg7Lf9oP9QOxLTCEnDnEJpJQBzJuEILK.docx', 'rincian biaya.docx', 2000000.00, 'disetujui', '2026-08-25 07:26:14', NULL, 'bukti-pembayaran/rWdKDjYM8IAcPPpEK9VpfUo8HYTns8YNjnCOLIeR.png', 'Screenshot (4).png', NULL, NULL, '2026-08-25 07:23:25', NULL, NULL, '2026-08-25 07:21:38', '2026-08-25 07:31:26'),
(13, 'PGD-20260825-00007', 'Sri Wahyuni', '0872190384', '085275363756', 'sriwahyuni13@gmail.com', 'Jl. Karya Wisata Gg. Damai No. 3, Tanjung Sari', NULL, 4, 'Air Berbau Kaporit Menyengat', 'Air dari keran saya bau kaporit banget, sampai gak enak dipakai mandi', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'diproses', NULL, NULL, NULL, 'Kadar kaporit sedikit berlebih, sedang dilakukan penyesuaian', 'ya', NULL, 'rincian-biaya/lko5GXcCQtv9zb4f8xigbBlKHpUJLpsbrniltFSR.pdf', 'test pdf.pdf', 100000.00, 'disetujui', '2026-08-25 07:37:35', NULL, 'bukti-pembayaran/Yqq0tKY4XyRzn5r8518Q54PZvAgqS5NoJvM8bo5P.png', 'Screenshot (2).png', NULL, NULL, '2026-08-25 07:35:12', NULL, NULL, '2026-08-25 07:32:32', '2026-08-25 07:38:48'),
(14, 'PGD-20260825-00008', 'Tommy Silalahi', '0819387452', '0882016639966', 'tommysilalahi@gmail.com', 'Jl. Bunga Ester No. 8, Padang Bulan Selayang II', NULL, 39, 'Tagihan Dobel Bulan Ini', 'Saya kena tagihan dua kali dalam sebulan, padahal biasanya cuma sekali', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'diproses', NULL, NULL, NULL, 'Ditemukan duplikasi pencatatan tagihan, sedang diproses koreksinya', 'ya', NULL, 'rincian-biaya/I3DSCX7hef8wKjwsLT6VLLHwDufcqCeTORlNr0aw.docx', 'rincian biaya.docx', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 07:42:33', NULL, NULL, '2026-08-25 07:41:04', '2026-08-25 07:45:38'),
(15, 'PGD-20260825-00009', 'Dewi Anggraini', '0857463201', '085275363756', 'dewianggraini15@gmail.com', 'Jl. Rakyat Rela No. 14, Simpang Selayang', 'Dekat pangkalan ojek', 43, 'Curiga Pencurian Air Tetangga', 'Saya curiga tetangga saya nyambung pipa dari saluran saya tanpa izin', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Ditemukan indikasi penyambungan pipa tidak resmi, perlu tindak lanjut', 'ya', NULL, 'rincian-biaya/qQLxyXwy4Qda4RebSb4IzSMpObRiIS2scl33Huc7.pdf', 'test pdf.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 07:49:40', NULL, NULL, '2026-08-25 07:49:06', '2026-08-25 07:49:40'),
(16, 'PGD-20260825-00010', 'Fajar Nugroho', '0863012947', '0882016639966', 'fajarnugroho16@gmail.com', 'Jl. Jamin Ginting Gg. Melati No. 9, Padang Bulan', NULL, 6, 'Pipa Dinas Bocor Depan Rumah', 'Pipa dinas menuju rumah saya bocor, air menggenang di halaman depan', NULL, 2, NULL, NULL, NULL, NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Benar ada kebocoran pada pipa dinas menuju rumah pelanggan', 'ya', NULL, 'rincian-biaya/A1TWwpJYwYyTNsT64LKOO8MmaUpBQseLPk2IlpVe.pdf', 'test pdf.pdf', 200000.00, 'disetujui', '2026-08-25 08:09:13', NULL, 'bukti-pembayaran/TXb67IZzf5mm2Pmna6ZAChsztAV9Z2mkKeqhs7IP.png', 'Screenshot (5).png', NULL, NULL, '2026-08-25 08:02:11', NULL, NULL, '2026-08-25 08:00:51', '2026-08-25 08:10:20'),
(17, 'PGD-20260825-00011', 'Lestari Br Nababan', '0846192073', '085275363756', 'lestarinababan@gmail.com', 'Jl. Karya Setia No. 19, Gedung Johor', 'Dekat toko kelontong Sari', 43, 'Meteran Dicurigai Dimanipulasi', 'Saya curiga ada yang mengutak-atik meteran air saya, angkanya aneh', NULL, 2, '2026-08-26 15:00:00', '2026-08-25 19:13:44', 'Petugas Lapangan 1', '2026-08-25 19:20:11', 'Petugas Lapangan 1', 'selesai', NULL, '2026-08-25 12:23:37', 'Segel meteran sudah diganti baru dan diamankan', 'Ditemukan indikasi manipulasi pada segel meteran', 'ya', NULL, 'rincian-biaya/G4rw9e9InAED0Q6hyTuE82eXOC1FQYghbFOvcmvy.pdf', 'test pdf.pdf', 402000.00, 'disetujui', '2026-08-25 12:18:35', NULL, 'bukti-pembayaran/gFI8SiziQxsj3nIpPM04vihup0M5NwjQPWBZDGN9.png', 'Screenshot (3).png', NULL, NULL, '2026-08-25 12:16:38', NULL, NULL, '2026-08-25 12:09:07', '2026-08-25 12:23:37'),
(18, 'PGD-20260825-00012', 'Andi Kurniawan', '0879340216', '0882016639966', 'andikurniawan18@gmail.com', 'Jl. Bunga Wijaya Kusuma No. 2, Padang Bulan', NULL, 36, 'IC Tersumbat Sampah', 'IC di depan rumah saya tersumbat sampah, air limbah meluap ke halaman', NULL, 2, '2026-08-27 19:28:00', '2026-08-25 19:28:49', 'Petugas Lapangan 1', '2026-08-25 19:33:58', 'Petugas Lapangan 1', 'diproses', NULL, NULL, NULL, 'IC tersumbat sampah rumah tangga, perlu dibersihkan', 'ya', NULL, 'rincian-biaya/d2k5zxKGakec0M1vU3IGwYyEQpjP6OvPx3MgnIRx.pdf', 'test pdf.pdf', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 12:31:11', NULL, NULL, '2026-08-25 12:09:36', '2026-08-25 12:33:58'),
(19, 'PGD-20260825-00013', 'Putri Handayani', '0821764930', '085275363756', 'putrihandayani19@gmail.com', 'Jl. Sepakat No. 27, Medan Tuntungan', NULL, 28, 'Lubang Bor Bocor', 'Ada lubang bor di dekat rumah saya yang airnya terus menerus keluar', NULL, 2, '2026-08-28 19:34:00', '2026-08-25 19:34:27', 'Petugas Lapangan 1', NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Benar ada kebocoran pada lubang bor, perlu penutupan ulang', 'ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 12:34:56', NULL, NULL, '2026-08-25 12:10:06', '2026-08-25 12:34:56'),
(20, 'PGD-20260825-00014', 'Marco Sinaga', '0854902137', '0882016639966', 'marcosinaga20@gmail.com', 'Jl. Karya Wisata No. 16, Tanjung Sari', 'Sebelah rumah makan Padang', 9, 'Kopling Meteran Bocor', 'Ada rembesan air kecil di sekitar sambungan kopling meteran saya', NULL, 2, '2026-08-25 19:36:00', '2026-08-25 19:36:28', 'Petugas Lapangan 1', NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Kopling meteran memang sedikit bocor, sudah dikencangkan ulang', 'tidak', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 12:36:56', NULL, NULL, '2026-08-25 12:10:34', '2026-08-25 12:36:56'),
(21, 'PGD-20260826-00001', 'Wulan Puspita', '0867231954', '085275363756', 'wulanpuspita21@gmail.com', 'Jl. Bunga Rinte No. 10, Padang Bulan Selayang I', NULL, 38, 'Cover Bak Kontrol Pecah', 'Tutup bak kontrol di depan rumah saya pecah kena terlindas mobil', NULL, 2, '2026-08-27 06:25:00', '2026-08-26 06:25:30', 'Petugas Lapangan 1', '2026-08-26 06:32:47', 'Petugas Lapangan 1', 'selesai', NULL, '2026-08-25 23:33:20', 'Cover bak kontrol baru sudah dipasang', 'Cover bak kontrol memang pecah dan perlu diganti', 'ya', NULL, 'rincian-biaya/Rincian-Biaya-imanuel-hulu-PGD-20260826-00001.pdf', 'test pdf.pdf', 300000.00, 'disetujui', '2026-08-25 23:31:08', NULL, 'bukti-pembayaran/Bukti-Pembayaran-imanuel-hulu-PGD-20260826-00001.jpg', '{03AF04B9-86EF-491D-8243-57B3CBD1287B}.png.jpg', NULL, NULL, '2026-08-25 23:28:10', '2026-08-26 06:31:42', 113, '2026-08-25 23:22:38', '2026-08-25 23:33:20'),
(22, 'PGD-20260826-00002', 'Ahmad Fauzi', '0831059872', '0882016639966', 'ahmadfauzi22@gmail.com', 'Jl. Berdikari No. 5, Simpang Selayang', 'Dekat pos satpam komplek', 43, 'Laporan Sambungan Ilegal', 'Saya lihat ada selang mencurigakan tersambung ke pipa dinas dekat rumah tetangga', NULL, 2, '2026-08-28 06:34:00', '2026-08-26 06:34:43', 'Petugas Lapangan 1', NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Ditemukan selang tidak resmi tersambung ke pipa dinas', 'ya', NULL, 'rincian-biaya/Rincian-Biaya-imanuel-hulu-PGD-20260826-00002.pdf', 'test pdf.pdf', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 23:36:14', '2026-08-26 06:36:14', 119, '2026-08-25 23:23:13', '2026-08-25 23:36:14'),
(23, 'PGD-20260826-00003', 'Rina Br Panggabean', '0849127635', '085275363756', 'rinapanggabean@gmail.com', 'Jl. Karya Bakti Gg. Aman No. 7, Simpang Selayang', NULL, 43, 'Meteran Diduga Dibalik', 'Saya curiga meteran air rumah sebelah dipasang terbalik supaya angkanya lebih kecil', NULL, 2, '2026-08-27 06:37:00', '2026-08-26 06:37:41', 'Petugas Lapangan 1', NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Ditemukan indikasi pemasangan meteran yang tidak sesuai standar', 'ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 23:38:07', '2026-08-26 06:38:07', 121, '2026-08-25 23:23:46', '2026-08-25 23:38:07'),
(24, 'PGD-20260826-00004', 'Yusuf Hasibuan', '0873645029', '0882016639966', 'yusufhasibuan24@gmail.com', 'Jl. Jamin Ginting Gg. Rambutan No. 13, Padang Bulan', NULL, 9, 'Sambungan Meter Kendor', 'Sambungan di sekitar meteran saya kendor, ada rembesan air sedikit', NULL, 2, '2026-08-26 06:39:00', '2026-08-26 06:39:44', 'Petugas Lapangan 1', NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Sambungan meteran memang kendor, sudah dikencangkan kembali', 'tidak', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-25 23:40:08', '2026-08-26 06:40:08', 123, '2026-08-25 23:24:18', '2026-08-25 23:40:08'),
(25, 'PGD-20260826-00005', 'Nina Marlina', '0856710294', '085275363756', 'ninamarlina25@gmail.com', 'Jl. Bunga Sakura No. 17, Padang Bulan', 'Rumah pagar hitam', 9, 'Meteran Bunyi Aneh', 'Meteran air saya kadang bunyi berdenging, saya khawatir ada kebocoran kecil', NULL, 2, '2026-08-27 08:55:00', '2026-08-26 08:55:10', 'Petugas Lapangan 1', NULL, NULL, 'ditolak', 'Dibatalkan oleh pelanggan (tidak menyetujui biaya perbaikan).', NULL, NULL, 'Bunyi berasal dari putaran normal meteran, tidak ada kebocoran', 'ya', NULL, 'rincian-biaya/Rincian-Biaya-imanuel-hulu-PGD-20260826-00005.pdf', 'test pdf.pdf', 1000.00, 'ditolak', '2026-08-26 03:39:57', 'tunda', NULL, NULL, NULL, NULL, '2026-08-26 01:56:36', NULL, 126, '2026-08-26 01:54:27', '2026-08-26 03:39:57'),
(26, 'PGD-20260826-00006', 'Herman Siregar', '0842093176', '0882016639966', 'hermansiregar26@gmail.com', 'Jl. Karya Wisata No. 20, Tanjung Sari', 'No. 20', 39, 'Tagihan Tidak Sesuai Pemakaian', 'Tagihan saya bulan ini kok tinggi banget, padahal pemakaian air biasa aja', 'Dekat pos satpam komplek', 2, '2026-08-07 14:16:00', '2026-08-26 12:14:35', 'Petugas Lapangan 1', NULL, NULL, 'diverifikasi', NULL, NULL, NULL, 'Ditemukan selisih pencatatan meteran, sedang dikoreksi', 'ya', NULL, 'rincian-biaya/Rincian-Biaya-wiili-PGD-20260826-00006.pdf', 'test pdf.pdf', 450000.00, 'disetujui', '2026-08-26 05:22:01', NULL, 'bukti-pembayaran/Bukti-Pembayaran-wiili-PGD-20260826-00006.png', 'Screenshot (5).png', NULL, NULL, '2026-08-26 05:19:08', '2026-08-26 12:22:21', 130, '2026-08-26 05:13:31', '2026-08-26 05:22:21'),
(27, 'PGD-20260826-00007', 'Dian Permata', '0865917320', '085275363756', 'dianpermata27@gmail.com', 'Jl. Bunga Malam No. 6, Padang Bulan Selayang II', 'Dekat pertigaan gang', 25, 'Minta Bongkar Pasang Gate Valve', 'Saya mau minta gate valve di depan rumah dibongkar pasang karena macet', 'Dekat pertigaan gang', 2, '2026-08-26 15:21:00', '2026-08-26 15:21:46', 'Petugas Lapangan 1', '2026-08-26 15:32:04', 'Petugas Lapangan 1', 'selesai', NULL, '2026-08-26 08:35:14', 'Gate valve sudah dibongkar pasang dan berfungsi normal', 'Gate valve memang macet dan perlu dibongkar pasang ulang', 'ya', NULL, 'rincian-biaya/Rincian-Biaya-imanuel-hulu-PGD-20260826-00007.pdf', 'test pdf.pdf', 100000.00, 'disetujui', '2026-08-26 08:30:17', NULL, 'bukti-pembayaran/Bukti-Pembayaran-imanuel-hulu-PGD-20260826-00007.png', 'Screenshot (6).png', NULL, NULL, '2026-08-26 08:25:43', '2026-08-26 15:30:43', 135, '2026-08-26 08:20:18', '2026-08-26 08:35:14'),
(28, 'PGD-20260827-00001', 'Doni Pratama', '0827384691', '0882016639966', 'donipratama28@gmail.com', 'Jl. Sepakat Gg. Rejeki No. 9, Medan Tuntungan', NULL, 39, 'Salah Catat Angka Meteran', 'Sepertinya petugas salah catat angka meteran saya, tagihan jadi aneh', NULL, 2, '2026-08-28 11:58:00', '2026-08-27 11:58:48', 'Petugas Lapangan 1', NULL, NULL, 'menunggu_verifikasi_pembayaran', NULL, NULL, NULL, 'Benar ada kesalahan pencatatan angka meteran sebelumnya', 'ya', NULL, 'rincian-biaya/Rincian-Biaya-imanuel-hulu-PGD-20260827-00001.pdf', 'test pdf.pdf', 130000.00, 'disetujui', '2026-08-27 05:01:12', NULL, 'bukti-pembayaran/Bukti-Pembayaran-imanuel-hulu-PGD-20260827-00001.jpg', '{0142004C-7548-4681-9FEF-38DAFB233F2E}.png.jpg', NULL, NULL, '2026-08-27 04:59:52', NULL, 145, '2026-08-27 04:57:43', '2026-08-27 05:01:12'),
(29, 'PGD-20260828-00001', 'Elisabeth Br Manurung', '0839215760', '085275363756', 'elisabethmanurung@gmail.com', 'Jl. Karya Jaya No. 24, Gedung Johor', NULL, 38, 'Cover Bak Kontrol Retak', 'Tutup bak kontrol di samping rumah saya retak-retak, takut ambrol', NULL, 2, '2026-08-29 03:23:00', '2026-08-28 03:23:49', 'Petugas Lapangan 1', NULL, NULL, 'ditolak', 'Dibatalkan oleh pelanggan (tidak menyetujui biaya yang diajukan).', NULL, NULL, 'Cover bak kontrol memang retak ringan, masih bisa dipakai sementara', 'ya', NULL, 'rincian-biaya/Rincian-Biaya-imanuel-hulu-PGD-20260828-00001.pdf', 'test pdf.pdf', 123444.00, 'ditolak', '2026-08-28 06:48:47', 'Belum ada dana, mohon ditunda dulu', NULL, NULL, NULL, '2026-08-28 13:48:47', '2026-08-27 20:24:39', NULL, 149, '2026-08-27 20:23:16', '2026-08-28 06:48:47'),
(30, 'PGD-20260829-00001', 'Bayu Setiawan', '0871602953', '0882016639966', 'bayusetiawan30@gmail.com', 'Jl. Bunga Kertas No. 3, Padang Bulan', 'Rumah warna biru, gang kedua dari simpang', 1, 'Air Mati Total Sejak Pagi', 'Air di rumah saya mati total dari pagi tadi, mohon segera dicek', 'Rumah warna biru, gang kedua dari simpang', NULL, NULL, NULL, NULL, NULL, NULL, 'baru', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-28 22:31:59', '2026-08-28 22:31:59'),
(31, 'PGD-20260829-00002', 'Christine Simatupang', '0846720198', '085275363756', 'christinesimatupang@gmail.com', 'Jl. Karya Setia No. 11, Gedung Johor', NULL, 25, 'Gate Valve Rusak', 'Gate valve di depan rumah saya rusak, susah diputar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'baru', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-29 02:48:04', '2026-08-29 02:48:04'),
(32, 'PGD-20260829-00003', 'Iwan Setiadi', '0854193672', '0882016639966', 'iwansetiadi32@gmail.com', 'Jl. Jamin Ginting Gg. Anggrek No. 4, Padang Bulan', NULL, 43, 'Laporan Dugaan Pencurian Air', 'Saya menemukan pipa kecil tersembunyi menempel di pipa dinas dekat pagar', 'Menempel di pipa dinas dekat pagar rumah', 2, '2026-08-29 11:53:00', '2026-08-29 11:54:01', 'Petugas Lapangan 1', NULL, NULL, 'pengecekan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-29 04:51:26', '2026-08-29 04:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan_fotos`
--

CREATE TABLE `pengaduan_fotos` (
  `id` bigint UNSIGNED NOT NULL,
  `pengaduan_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(10, 6, 'pengaduan/13xLnfeqQKs1n8qlOmoSReZInmshc7eQlz7xJZZo.png', '2026-08-22 05:16:33', '2026-08-22 05:16:33'),
(11, 7, 'pengaduan/HRhZpPEMu6r9wPp0LUT2A7RgpMa66KyF3w71OZNj.png', '2026-08-25 03:47:24', '2026-08-25 03:47:24'),
(12, 8, 'pengaduan/NhyDqt0tiGxxo9Vj3S3gBEjoPDsKCKB0BX8rToZZ.png', '2026-08-25 04:18:47', '2026-08-25 04:18:47'),
(13, 9, 'pengaduan/Ki8fHzTnGKoUj2BXEl77lEif3nwJZUGbssOJPmQE.png', '2026-08-25 04:24:00', '2026-08-25 04:24:00'),
(14, 11, 'pengaduan/hPhsN2zi3BtsbEQXTHgNNBt21PrPIqcStLlsNYjI.png', '2026-08-25 07:05:23', '2026-08-25 07:05:23'),
(15, 12, 'pengaduan/uxEDNvGYI3kLC7YyD3zWBniVO8MMeb1gaAcp5ISt.png', '2026-08-25 07:21:38', '2026-08-25 07:21:38'),
(16, 13, 'pengaduan/ZkEuQmyP2C299r1FYpCizNjnYeOSrSpRkLqCgBo8.png', '2026-08-25 07:32:32', '2026-08-25 07:32:32'),
(17, 21, 'pengaduan/XgLslvorIGn1nMXvc8qwDXAL3sGgJcBSt05XTJVO.png', '2026-08-25 23:22:39', '2026-08-25 23:22:39'),
(18, 22, 'pengaduan/MGrMg9qamnMwrzHfDZrAZFksM9PIplvVknNV6VjA.png', '2026-08-25 23:23:13', '2026-08-25 23:23:13'),
(19, 23, 'pengaduan/tpc2pPsoUJM9EPp1B1uobDKYSSQlKfvtGeEYujpW.png', '2026-08-25 23:23:47', '2026-08-25 23:23:47'),
(20, 24, 'pengaduan/iXvCwcHCOJjkHywZC6F07gwlD7MGhHMHP1TM8bwM.png', '2026-08-25 23:24:19', '2026-08-25 23:24:19'),
(21, 26, 'pengaduan/ogc0Pz3Gkbg4QV3MyPaIZxnE6tcQ4gvVpiIjiZmB.png', '2026-08-26 05:13:33', '2026-08-26 05:13:33'),
(22, 27, 'pengaduan/hs5YguwvrzV6KoKtcYwclQ5yFLBdmWfn2mnvg0cd.png', '2026-08-26 08:20:20', '2026-08-26 08:20:20'),
(23, 28, 'pengaduan/tTa54YkIVVTV3Bg0s53N70fqOvyHb31ytHDKTHlw.png', '2026-08-27 04:57:45', '2026-08-27 04:57:45'),
(24, 31, 'pengaduan/V8l9ni92Zn6eolKwuogQRZTF47bhV54mClnEMoNw.jpg', '2026-08-29 02:48:06', '2026-08-29 02:48:06'),
(25, 32, 'pengaduan/KCFmxBlMflhbXQ7bmBVohHtWliH2sa1P65vKdKuG.png', '2026-08-29 04:51:28', '2026-08-29 04:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CYluVkmabaW37P5NxRD8V2534FKcCo9r3NQTcsKH', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJTRG5TeXJ5VzFUajhXbVlYb1BCUjhYU21iRlpubkFFamxSeXdmVlFoIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3BlbmdhZHVhbnBlbGFuZ2dhbnRpcnRhbmFkaS50ZXN0XC9kYXNoYm9hcmQiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1788022594),
('ZveethHPuwCL2PvKL3OWq63pyOz3ow0gVa4Yx7nJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJLQktFdEQ5V2JmVTlqM283YmVOVlJpcjVyTk5tQ3RIcERWaGdnczV3IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvcGVuZ2FkdWFucGVsYW5nZ2FudGlydGFuYWRpLnRlc3RcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1788004772);

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan_fotos`
--

CREATE TABLE `tanggapan_fotos` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggapan_pengaduan_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(23, 39, 'dokumentasi/DwWcD2WvQ129SGEFwlNbx0Pjw6HP75KGjWD5Ow51.png', '2026-08-23 05:32:32', '2026-08-23 05:32:32'),
(24, 42, 'dokumentasi/fOaFiMXIxYnX6uI9GhMLVH17TAr6tw1cWxNfEGi1.png', '2026-08-25 03:52:37', '2026-08-25 03:52:37'),
(25, 45, 'dokumentasi/bfWcQ5Qw1FTI9aZpSQNgfHOql6YM1tu354pHNdfl.png', '2026-08-25 03:55:35', '2026-08-25 03:55:35'),
(26, 49, 'dokumentasi/LPayJtZHwBuCR1GcnckKQlrDMtWihehYH5ZO2rvH.png', '2026-08-25 04:20:38', '2026-08-25 04:20:38'),
(27, 60, 'dokumentasi/3pgXM6bxnKpqWcO0lt5k3IELHydV7KRIu6M6xXqc.jpg', '2026-08-25 07:11:15', '2026-08-25 07:11:15'),
(28, 64, 'dokumentasi/UEJTVRsDQrfrV1m0FZ7BZhfu9VQNXtB319NVxpdM.png', '2026-08-25 07:23:25', '2026-08-25 07:23:25'),
(29, 68, 'dokumentasi/Epuw0LlTvFs3f2ucrrA7QLQbgU2wZgjEYUtgOsUU.png', '2026-08-25 07:30:52', '2026-08-25 07:30:52'),
(30, 69, 'dokumentasi/3d33kdV94Hpc8KcSF4czey23zvoiUt2QXKcec62O.png', '2026-08-25 07:31:12', '2026-08-25 07:31:12'),
(31, 73, 'dokumentasi/X2G2N243JIn1BQ1X9LLkfElFBuyRvvmdqZW9wTFr.png', '2026-08-25 07:35:12', '2026-08-25 07:35:12'),
(32, 86, 'dokumentasi/z3DRnHRgmYJBe5IXhhUMXwuObOOm4cd4dRHhYxMK.jpg', '2026-08-25 08:02:11', '2026-08-25 08:02:11'),
(33, 94, 'dokumentasi/E4mNtcpfxojY8HLr8twWAIlBcqCsqxz47nlyt3RF.jpg', '2026-08-25 12:16:38', '2026-08-25 12:16:38'),
(34, 94, 'dokumentasi/ZyAUjqzl3LYUMCPUTos2j9bT05ZNvj4ZVgkb1Yf0.png', '2026-08-25 12:16:38', '2026-08-25 12:16:38'),
(35, 98, 'dokumentasi/IyMDsebcSWuCShzpq65xBKBD8TfAumhVHu9608dq.png', '2026-08-25 12:22:40', '2026-08-25 12:22:40'),
(36, 99, 'dokumentasi/G1VxugDFSJrYR5oqQv0N2MrOLv4Iru41hFyV5Jn7.png', '2026-08-25 12:23:22', '2026-08-25 12:23:22'),
(37, 102, 'dokumentasi/pVVGIU4z5GxijuPRKq0dejDYaQXfS54NlsuQ039t.png', '2026-08-25 12:31:11', '2026-08-25 12:31:11'),
(38, 105, 'dokumentasi/FueR4NbEXIkACmOmRKznermKOJWPmpvMOGjxLqpc.png', '2026-08-25 12:34:56', '2026-08-25 12:34:56'),
(39, 107, 'dokumentasi/IrRTdTblYEeFK0ySec9cDiCFspgvorZfOPD7e6Ka.png', '2026-08-25 12:36:56', '2026-08-25 12:36:56'),
(40, 113, 'dokumentasi/ogoIoLDPx96A0Kijs1sODjkFyQlVUy7ScsyxQrjM.png', '2026-08-25 23:28:10', '2026-08-25 23:28:10'),
(41, 113, 'dokumentasi/TIABi8OZmIIWdEV7XTVdjTNGO0E3MpGjcx6YPh1s.png', '2026-08-25 23:28:10', '2026-08-25 23:28:10'),
(42, 119, 'dokumentasi/KrZcvFYZd6h6bQhomVYb6Hw9QFk7muahf3o1Uw6a.jpg', '2026-08-25 23:36:14', '2026-08-25 23:36:14'),
(43, 121, 'dokumentasi/NyvN5uie6vLLzkni0LYlzcQQ9K914vecgVWiQP46.png', '2026-08-25 23:38:07', '2026-08-25 23:38:07'),
(44, 123, 'dokumentasi/KmzuJXiQf4e8OEDJzk1nV1eyZFtODy3MDisDyMRe.png', '2026-08-25 23:40:08', '2026-08-25 23:40:08'),
(45, 126, 'dokumentasi/Dh9MJR16hCSMETqYws9ZLJfogcX8ho5SyjgUSR0N.jpg', '2026-08-26 01:56:36', '2026-08-26 01:56:36'),
(46, 130, 'dokumentasi/AQhcyvVGpOSQqc18piMoTGyMnMgENkfKkYkZEkL8.png', '2026-08-26 05:19:08', '2026-08-26 05:19:08'),
(47, 135, 'dokumentasi/b9oApIu7uqVzK3ZXa61vJ3gFMQ3gNeOzeTtffbjy.png', '2026-08-26 08:25:43', '2026-08-26 08:25:43'),
(49, 140, 'dokumentasi/qpT8LoHlXIMmh4qdT2WmOiK9k9evZFMirM40sEiU.png', '2026-08-26 08:33:32', '2026-08-26 08:33:32'),
(50, 141, 'dokumentasi/B4plPaLlF1B8M2URYdgFlkhqRnpjLu2H6K6pjali.png', '2026-08-26 08:33:51', '2026-08-26 08:33:51'),
(51, 145, 'dokumentasi/W2wMKXQi98MnB7cn3XrUr9sFTqnwx4vxmtcKwxfj.jpg', '2026-08-27 04:59:52', '2026-08-27 04:59:52'),
(52, 149, 'dokumentasi/lbhNdsJiDY0S39WepEyciSqjrcNgJAPPff1OEfhF.jpg', '2026-08-27 20:24:39', '2026-08-27 20:24:39'),
(53, 139, 'dokumentasi/TAaoNsp6zVxkHEWwRUNwMYNmkUcktVmPjkZoUrVN.png', '2026-08-29 06:39:05', '2026-08-29 06:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan_pengaduans`
--

CREATE TABLE `tanggapan_pengaduans` (
  `id` bigint UNSIGNED NOT NULL,
  `pengaduan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_baru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tanggapan_pengaduans`
--

INSERT INTO `tanggapan_pengaduans` (`id`, `pengaduan_id`, `user_id`, `pesan`, `status_baru`, `jenis_surat`, `created_at`, `edited_at`) VALUES
(1, 1, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-20 13:30:35', NULL),
(2, 2, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-21 07:33:41', NULL),
(3, 1, 1, 'Pengaduan sudah kami terima dan saat ini akan kami lakukan pengecekan secara langsung, terima kasih', 'pengecekan', NULL, '2026-08-21 07:52:09', NULL),
(4, 1, 1, 'Hasil pemeriksaan: Memang benar ada kebocoran di pipa distribusi (Perlu SPKP)', NULL, NULL, '2026-08-21 08:17:32', NULL),
(5, 1, 1, 'Pengaduan ditugaskan ke petugas: Petugas Lapangan 1.', NULL, NULL, '2026-08-21 08:18:33', NULL),
(6, 1, 1, 'Berdasarkan pengecekan memang terjadi kebocoran di pipa distribusi, maka pekerja kami akan mulai melakukan perbaikan ke tempat kebocoran atas persetujuan bapak/ibuk, terima kasih', 'diverifikasi', NULL, '2026-08-21 08:21:00', NULL),
(7, 1, 1, 'Pekerja lapangan akan melakukan perbaikan hari ini', 'diproses', NULL, '2026-08-21 08:22:21', NULL),
(8, 1, 1, 'perbaikan pertama sudah dilakaukan di hari pertama', 'diproses', NULL, '2026-08-21 08:23:08', NULL),
(9, 1, 1, 'perbaikan kedua', 'diproses', NULL, '2026-08-21 08:23:43', NULL),
(10, 1, 1, 'Perbaikan telah selesai dilakaukan terima kasih', 'selesai', NULL, '2026-08-21 08:24:20', NULL),
(11, 2, 1, 'Pengaduan ditugaskan ke petugas: Petugas Lapangan 1.', NULL, NULL, '2026-08-21 08:29:53', NULL),
(12, 2, 1, 'Petugas kami akan melakukan pengecekan secara langsung ke tempat', 'pengecekan', NULL, '2026-08-21 08:30:36', NULL),
(13, 2, 1, 'Hasil pemeriksaan: benar ada perbedaan tarif (Perlu SPKP)', NULL, NULL, '2026-08-21 08:31:42', NULL),
(14, 2, 1, 'Berdasarkan pengecekan, benar ada perbedaan tarif pada tagihan bapak/ibu', 'diverifikasi', NULL, '2026-08-21 08:37:48', NULL),
(15, 2, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', NULL, '2026-08-22 03:23:51', NULL),
(16, 2, 1, 'Sedang menghitung ulang tarif sesuai pemakaian aktual pelanggan', NULL, NULL, '2026-08-22 03:24:36', NULL),
(17, 2, 1, 'Draft koreksi tagihan sudah diajukan ke bagian keuangan untuk persetujuan', NULL, NULL, '2026-08-22 03:25:59', NULL),
(18, 2, 1, 'Perbaikan telah selesai terima kasih', 'selesai', NULL, '2026-08-22 03:26:29', NULL),
(19, 3, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-22 03:31:37', NULL),
(20, 3, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-22 03:42:41', NULL),
(21, 3, 1, 'Pengaduan telah diverifikasi. Hasil pemeriksaan: Ditemukan sambungan pipa ilegal yang menyadap dari pipa dinas pelanggan (Perlu SPKP).', 'diverifikasi', NULL, '2026-08-22 03:43:48', NULL),
(22, 3, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', NULL, '2026-08-22 03:44:06', NULL),
(23, 3, 1, 'Sudah dilakukan pemutusan sambungan ilegal di lokasi', NULL, NULL, '2026-08-22 03:44:20', NULL),
(24, 3, 1, 'Sambungan ilegal sudah dibongkar dan meteran sudah disegel ulang', 'selesai', NULL, '2026-08-22 03:44:44', NULL),
(25, 4, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-22 03:45:31', NULL),
(26, 4, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-22 03:46:11', NULL),
(27, 4, 1, 'Pengaduan ditolak. Alasan: Setelah dicek, tagihan sudah sesuai dengan angka meteran dan pemakaian aktual, tidak ada kesalahan pencatatan', 'ditolak', NULL, '2026-08-22 03:46:32', NULL),
(28, 5, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-22 03:47:57', NULL),
(29, 5, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-22 03:51:00', NULL),
(30, 5, 1, 'Pengaduan telah diverifikasi. Hasil pemeriksaan: Air keruh disebabkan pengurasan pipa distribusi, sudah kembali normal setelah dibilas (Tidak Perlu SPKP).', 'diverifikasi', NULL, '2026-08-22 03:51:41', NULL),
(31, 5, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', NULL, '2026-08-22 03:51:58', NULL),
(32, 5, 1, 'Sudah dilakukan pembilasan pipa di titik terdekat', NULL, NULL, '2026-08-22 03:52:18', NULL),
(33, 5, 1, 'Air sudah dicek ulang dan kondisinya sudah jernih kembali', NULL, NULL, '2026-08-22 03:52:35', NULL),
(34, 5, 1, 'Air sudah normal dan jernih, keluhan pelanggan sudah teratasi', 'selesai', NULL, '2026-08-22 03:53:06', NULL),
(35, 6, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-22 05:16:31', NULL),
(36, 6, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-23 05:06:57', NULL),
(37, 6, 1, 'Pengaduan telah diverifikasi. Hasil pemeriksaan: Cover bak kontrol memang retak dan perlu diganti (Perlu SPKP).', 'diverifikasi', NULL, '2026-08-23 05:07:36', NULL),
(38, 6, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', NULL, '2026-08-23 05:31:10', NULL),
(39, 6, 1, 'Sedang menyiapkan cover bak kontrol pengganti', NULL, NULL, '2026-08-23 05:32:32', NULL),
(40, 7, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 03:47:18', NULL),
(41, 7, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 03:50:06', NULL),
(42, 7, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Cover bak kontrol memang tidak ada, perlu dipasang cover baru (Perlu SPKP). Ditemukan biaya perbaikan sebesar Rp 1.500.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', NULL, '2026-08-25 03:52:37', NULL),
(43, 7, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 1.500.000. Pengaduan dilanjutkan ke tahap berikutnya.', 'diverifikasi', NULL, '2026-08-25 03:54:23', NULL),
(44, 7, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', NULL, '2026-08-25 03:54:58', NULL),
(45, 7, 1, 'Cover bak kontrol baru sudah dipasang', NULL, NULL, '2026-08-25 03:55:35', NULL),
(46, 7, 1, 'Pemasangan cover bak kontrol sudah selesai dikerjakan', 'selesai', NULL, '2026-08-25 03:55:57', NULL),
(47, 8, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 04:18:46', NULL),
(48, 8, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 04:19:26', NULL),
(49, 8, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: IC tersumbat limbah padat, perlu dibersihkan (Perlu SPKP). Ditemukan biaya perbaikan sebesar Rp 1.250.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', NULL, '2026-08-25 04:20:38', NULL),
(50, 8, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 1.250.000. Pengaduan dilanjutkan ke tahap berikutnya.', 'diverifikasi', NULL, '2026-08-25 04:22:56', NULL),
(51, 9, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 04:24:00', NULL),
(52, 9, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 04:24:25', NULL),
(53, 9, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Sudah dijelaskan cara pembayaran online melalui aplikasi mitra PDAM (Perlu SPKP). Ditemukan biaya perbaikan sebesar Rp 10.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', NULL, '2026-08-25 04:25:23', NULL),
(54, 9, NULL, 'Pelanggan tidak menyetujui biaya perbaikan, pengaduan dibatalkan. Alasan: tunda dulu', 'ditolak', NULL, '2026-08-25 04:26:09', NULL),
(55, 10, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 04:29:35', NULL),
(56, 10, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 04:30:24', NULL),
(57, 10, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Tekanan air memang kecil di jam-jam sore, kemungkinan karena pemakaian puncak (Perlu SPKP). Pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', NULL, '2026-08-25 04:31:30', NULL),
(58, 11, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 07:05:21', NULL),
(59, 11, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 07:07:52', NULL),
(60, 11, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Benar ada kebocoran kecil pada pipa distribusi, perlu penambalan (Perlu SPKP). Ditemukan biaya perbaikan sebesar Rp 500.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', NULL, '2026-08-25 07:11:15', NULL),
(61, 11, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 500.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-25 07:17:10', NULL),
(62, 12, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 07:21:38', NULL),
(63, 12, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 07:22:23', NULL),
(64, 12, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Terjadi kebocoran besar pada pipa transmisi, perlu perbaikan segera (Perlu SPKP). Ditemukan biaya perbaikan sebesar Rp 2.000.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', NULL, '2026-08-25 07:23:25', NULL),
(65, 12, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 2.000.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-25 07:26:14', NULL),
(66, 12, 1, 'Bukti pembayaran telah diverifikasi dan dinyatakan valid. Pengaduan dilanjutkan ke tahap berikutnya.', 'diverifikasi', NULL, '2026-08-25 07:28:56', NULL),
(67, 12, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', NULL, '2026-08-25 07:30:02', NULL),
(68, 12, 1, 'Penggalian titik kebocoran sudah dimulai', NULL, NULL, '2026-08-25 07:30:52', NULL),
(69, 12, 1, 'Penyambungan pipa baru sudah selesai, sedang uji tekanan', NULL, NULL, '2026-08-25 07:31:12', NULL),
(70, 12, 1, 'Perbaikan pipa transmisi sudah selesai, aliran air kembali normal', 'selesai', NULL, '2026-08-25 07:31:26', NULL),
(71, 13, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 07:32:32', NULL),
(72, 13, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 07:33:58', NULL),
(73, 13, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Kadar kaporit sedikit berlebih, sedang dilakukan penyesuaian (Perlu SPKP). Ditemukan biaya perbaikan sebesar Rp 100.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', NULL, '2026-08-25 07:35:12', NULL),
(74, 13, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 100.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-25 07:37:35', NULL),
(75, 13, 1, 'Bukti pembayaran telah diverifikasi dan dinyatakan valid. Pengaduan dilanjutkan ke tahap berikutnya.', 'diverifikasi', NULL, '2026-08-25 07:38:17', NULL),
(76, 13, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', NULL, '2026-08-25 07:38:48', NULL),
(77, 14, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 07:41:04', NULL),
(78, 14, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 07:41:25', NULL),
(79, 14, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Ditemukan duplikasi pencatatan tagihan, sedang diproses koreksinya (Perlu SPKP). Pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', NULL, '2026-08-25 07:42:33', NULL),
(80, 14, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1.', 'diproses', NULL, '2026-08-25 07:45:38', NULL),
(81, 15, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 07:49:06', NULL),
(82, 15, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 07:49:21', NULL),
(83, 15, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Ditemukan indikasi penyambungan pipa tidak resmi, perlu tindak lanjut (Perlu SPKP). Pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', NULL, '2026-08-25 07:49:41', NULL),
(84, 16, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 08:00:51', NULL),
(85, 16, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1.', 'pengecekan', NULL, '2026-08-25 08:01:32', NULL),
(86, 16, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Benar ada kebocoran pada pipa dinas menuju rumah pelanggan (Perlu SPKP). Ditemukan biaya perbaikan sebesar Rp 200.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', NULL, '2026-08-25 08:02:11', NULL),
(87, 16, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 200.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-25 08:09:13', NULL),
(88, 16, 1, 'Bukti pembayaran telah diverifikasi dan dinyatakan valid. Pengaduan dilanjutkan ke tahap berikutnya.', 'diverifikasi', NULL, '2026-08-25 08:10:20', NULL),
(89, 17, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 12:09:07', NULL),
(90, 18, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 12:09:36', NULL),
(91, 19, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 12:10:06', NULL),
(92, 20, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 12:10:34', NULL),
(93, 17, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 26 Agustus 2026, 15:00 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', NULL, '2026-08-25 12:13:44', NULL),
(94, 17, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Ditemukan indikasi manipulasi pada segel meteran (Perlu SPKP). Ditemukan biaya perbaikan sebesar Rp 402.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', NULL, '2026-08-25 12:16:38', NULL),
(95, 17, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 402.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-25 12:18:35', NULL),
(96, 17, 1, 'Bukti pembayaran telah diverifikasi dan dinyatakan valid. Pengaduan dilanjutkan ke tahap berikutnya.', 'diverifikasi', NULL, '2026-08-25 12:19:21', NULL),
(97, 17, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'diproses', NULL, '2026-08-25 12:20:11', NULL),
(98, 17, 1, 'Segel meteran lama sudah dilepas', NULL, NULL, '2026-08-25 12:22:40', NULL),
(99, 17, 1, 'Segel meteran baru sudah dipasang dan diamankan', NULL, NULL, '2026-08-25 12:23:22', NULL),
(100, 17, 1, 'Segel meteran sudah diganti baru dan diamankan Surat keterangan selesai sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'selesai', NULL, '2026-08-25 12:23:37', NULL),
(101, 18, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 27 Agustus 2026, 19:28 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', NULL, '2026-08-25 12:28:50', NULL),
(102, 18, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: IC tersumbat sampah rumah tangga, perlu dibersihkan (Perlu SPKP). Pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', NULL, '2026-08-25 12:31:11', NULL),
(103, 18, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'diproses', NULL, '2026-08-25 12:33:58', NULL),
(104, 19, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 28 Agustus 2026, 19:34 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', NULL, '2026-08-25 12:34:27', NULL),
(105, 19, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Benar ada kebocoran pada lubang bor, perlu penutupan ulang (Perlu SPKP). Pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', NULL, '2026-08-25 12:34:56', NULL),
(106, 20, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 25 Agustus 2026, 19:36 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', NULL, '2026-08-25 12:36:28', NULL),
(107, 20, 1, 'Pengaduan telah diperiksa. Hasil pemeriksaan: Kopling meteran memang sedikit bocor, sudah dikencangkan ulang (Tidak Perlu SPKP). Pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', NULL, '2026-08-25 12:36:56', NULL),
(108, 21, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 23:22:38', NULL),
(109, 22, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 23:23:13', NULL),
(110, 23, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 23:23:46', NULL),
(111, 24, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-25 23:24:19', NULL),
(112, 21, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 27 Agustus 2026, 06:25 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-25 23:25:30', NULL),
(113, 21, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Cover bak kontrol memang pecah dan perlu diganti (Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Ditemukan biaya perbaikan sebesar Rp 300.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', 'hasil_pengecekan', '2026-08-25 23:28:10', NULL),
(114, 21, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 300.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-25 23:31:08', NULL),
(115, 21, 1, 'Bukti pembayaran telah diverifikasi dan dinyatakan valid. Pengaduan dilanjutkan ke tahap berikutnya. Surat Verifikasi Pengaduan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'diverifikasi', 'verifikasi_pengaduan', '2026-08-25 23:31:42', NULL),
(116, 21, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'diproses', 'proses', '2026-08-25 23:32:47', NULL),
(117, 21, 1, 'Cover bak kontrol baru sudah dipasang Surat keterangan selesai sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'selesai', 'selesai', '2026-08-25 23:33:20', NULL),
(118, 22, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 28 Agustus 2026, 06:34 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-25 23:34:43', NULL),
(119, 22, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Ditemukan selang tidak resmi tersambung ke pipa dinas (Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Tidak ada biaya perbaikan, pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', 'hasil_pengecekan', '2026-08-25 23:36:14', NULL),
(120, 23, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 27 Agustus 2026, 06:37 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-25 23:37:41', NULL),
(121, 23, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Ditemukan indikasi pemasangan meteran yang tidak sesuai standar (Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Tidak ada biaya perbaikan, pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', 'hasil_pengecekan', '2026-08-25 23:38:07', NULL),
(122, 24, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 26 Agustus 2026, 06:39 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-25 23:39:44', NULL),
(123, 24, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Sambungan meteran memang kendor, sudah dikencangkan kembali (Tidak Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Tidak ada biaya perbaikan, pengaduan telah diverifikasi dan dilanjutkan.', 'diverifikasi', 'hasil_pengecekan', '2026-08-25 23:40:08', NULL),
(124, 25, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-26 01:54:27', NULL),
(125, 25, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 27 Agustus 2026, 08:55 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-26 01:55:10', NULL),
(126, 25, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Bunyi berasal dari putaran normal meteran, tidak ada kebocoran (Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Ditemukan biaya perbaikan sebesar Rp 1.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', 'hasil_pengecekan', '2026-08-26 01:56:36', NULL),
(127, 25, NULL, 'Pelanggan tidak menyetujui biaya perbaikan, pengaduan dibatalkan. Alasan: Belum ada dana, mohon ditunda dulu', 'ditolak', NULL, '2026-08-26 03:39:58', NULL),
(128, 26, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-26 05:13:31', NULL),
(129, 26, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 07 Agustus 2026, 14:16 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-26 05:14:35', NULL),
(130, 26, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Ditemukan selisih pencatatan meteran, sedang dikoreksi (Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Ditemukan biaya perbaikan sebesar Rp 450.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', 'hasil_pengecekan', '2026-08-26 05:19:08', NULL),
(131, 26, NULL, 'Pelanggan menyetujui biaya perbaikan sebesar Rp 450.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-26 05:22:01', NULL),
(132, 26, 1, 'Bukti pembayaran telah diverifikasi dan dinyatakan valid. Pengaduan dilanjutkan ke tahap berikutnya. Surat Verifikasi Pengaduan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'diverifikasi', 'verifikasi_pengaduan', '2026-08-26 05:22:21', NULL),
(133, 27, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-26 08:20:19', NULL),
(134, 27, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 26 Agustus 2026, 15:21 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-26 08:21:47', NULL),
(135, 27, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Gate valve memang macet dan perlu dibongkar pasang ulang (Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Ditemukan biaya sebesar Rp 100.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', 'hasil_pengecekan', '2026-08-26 08:25:43', NULL),
(136, 27, NULL, 'Pelanggan menyetujui biaya sebesar Rp 100.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-26 08:30:17', NULL),
(137, 27, 1, 'Bukti pembayaran telah diverifikasi dan dinyatakan valid. Pengaduan dilanjutkan ke tahap berikutnya. Surat Verifikasi Pengaduan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'diverifikasi', 'verifikasi_pengaduan', '2026-08-26 08:30:43', NULL),
(138, 27, 1, 'Pengaduan mulai dikerjakan oleh: Petugas Lapangan 1. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'diproses', 'proses', '2026-08-26 08:32:04', NULL),
(139, 27, 1, 'Gate valve lama sudah dilepas dari posisinya', NULL, NULL, '2026-08-26 08:32:23', '2026-08-29 06:39:06'),
(140, 27, 1, 'Gate valve baru sedang dipasang', NULL, NULL, '2026-08-26 08:33:31', NULL),
(141, 27, 1, 'Pengujian buka tutup gate valve baru berjalan lancar', NULL, NULL, '2026-08-26 08:33:51', NULL),
(142, 27, 1, 'Gate valve sudah dibongkar pasang dan berfungsi normal Surat keterangan selesai sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'selesai', 'selesai', '2026-08-26 08:35:14', NULL),
(143, 28, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-27 04:57:43', NULL),
(144, 28, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 28 Agustus 2026, 11:58 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-27 04:58:48', NULL),
(145, 28, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Benar ada kesalahan pencatatan angka meteran sebelumnya (Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Ditemukan biaya sebesar Rp 130.000, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', 'hasil_pengecekan', '2026-08-27 04:59:52', NULL),
(146, 28, NULL, 'Pelanggan menyetujui biaya sebesar Rp 130.000 dan mengunggah bukti pembayaran. Menunggu verifikasi admin.', 'menunggu_verifikasi_pembayaran', NULL, '2026-08-27 05:01:12', NULL),
(147, 29, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-27 20:23:16', NULL),
(148, 29, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 29 Agustus 2026, 03:23 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-27 20:23:49', NULL),
(149, 29, 1, 'Pengecekan lapangan telah selesai dilakukan. Hasil pemeriksaan: Cover bak kontrol memang retak ringan, masih bisa dipakai sementara (Perlu SPKP). Surat Hasil Pengecekan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan. Ditemukan biaya sebesar Rp 123.444, menunggu persetujuan pelanggan sebelum dilanjutkan.', 'menunggu_persetujuan', 'hasil_pengecekan', '2026-08-27 20:24:39', NULL),
(150, 29, NULL, 'Pelanggan tidak menyetujui biaya yang diajukan, pengaduan dibatalkan. Alasan: Belum ada dana, mohon ditunda dulu Surat pemberitahuan sudah bisa dilihat/diunduh di halaman Lacak Pengaduan.', 'ditolak', 'ditolak', '2026-08-28 06:48:47', NULL),
(151, 30, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-28 22:31:59', NULL),
(152, 31, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-29 02:48:04', NULL),
(153, 32, NULL, 'Pengaduan berhasil dikirim dan menunggu diverifikasi.', 'baru', NULL, '2026-08-29 04:51:27', NULL),
(154, 32, 1, 'Pengaduan diteruskan untuk pengecekan lapangan oleh petugas: Petugas Lapangan 1. Jadwal rencana pengecekan: 29 Agustus 2026, 11:53 WIB. Surat pemberitahuan sudah bisa dilihat/diunduh pelanggan di halaman Lacak Pengaduan.', 'pengecekan', 'pengecekan', '2026-08-29 04:54:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nipp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','petugas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nipp`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin PDAM Padang Bulan', '19850101202201001', 'admin@pdamtirtanadi.test', NULL, 'admin', NULL, '$2y$12$rXy85kzzAsLOIXLaCNtDx.sD/T3m5LHAr7h/fJhJCgRIktH2iaoC.', 'Vnb9x5KZXDUCmzCgG6femj7zNP5Tra5ThlIJ5SGmuGFG3wqGvqMeqqjWT2JE', '2026-08-20 12:32:03', '2026-08-20 12:32:03'),
(2, 'Petugas Lapangan 1', '19900202202201002', 'petugas@pdamtirtanadi.test', '081233464545', 'petugas', NULL, '$2y$12$7WL2W.usZr.CI/mcz0hbyO4MRrWh/iCucjgnL5attIIl8fqu8dDFu', NULL, '2026-08-20 12:32:03', '2026-08-28 18:04:20');

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pengaduans`
--
ALTER TABLE `pengaduans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `pengaduan_fotos`
--
ALTER TABLE `pengaduan_fotos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tanggapan_fotos`
--
ALTER TABLE `tanggapan_fotos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tanggapan_pengaduans`
--
ALTER TABLE `tanggapan_pengaduans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
