-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2020 at 01:45 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siapkerja_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `capaian_individu`
--

CREATE TABLE `capaian_individu` (
  `id` varchar(36) NOT NULL,
  `nip_lama` varchar(10) DEFAULT NULL,
  `mitra_id` varchar(36) DEFAULT NULL,
  `seksi_id` varchar(3) NOT NULL,
  `kegiatan_id` varchar(36) NOT NULL,
  `kegiatan_tahapan_id` varchar(36) NOT NULL,
  `target_all` smallint(5) UNSIGNED NOT NULL,
  `tujuan` varchar(100) NOT NULL,
  `is_mulai` varchar(1) NOT NULL,
  `yang_isi` varchar(1) NOT NULL,
  `status_user` varchar(1) NOT NULL,
  `bulan_awal` tinyint(3) UNSIGNED NOT NULL,
  `bulan_akhir` tinyint(3) UNSIGNED NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `capaian_tahapan_id` varchar(36) DEFAULT NULL,
  `target_01` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_02` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_03` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_04` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_05` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_06` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_07` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_08` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_09` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_10` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_11` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_12` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_01` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_02` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_03` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_04` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_05` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_06` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_07` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_08` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_09` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_10` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_11` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_12` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `capaian_tahapan`
--

CREATE TABLE `capaian_tahapan` (
  `id` varchar(36) NOT NULL,
  `seksi_id` varchar(3) NOT NULL,
  `kegiatan_id` varchar(36) NOT NULL,
  `kegiatan_tahapan_id` varchar(36) NOT NULL,
  `target_all` smallint(5) UNSIGNED NOT NULL,
  `is_mulai` varchar(1) NOT NULL,
  `yang_isi` varchar(1) NOT NULL,
  `bulan_awal` tinyint(3) UNSIGNED NOT NULL,
  `bulan_akhir` tinyint(3) UNSIGNED NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `target_01` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_02` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_03` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_04` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_05` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_06` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_07` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_08` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_09` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_10` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_11` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `target_12` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_01` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_02` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_03` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_04` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_05` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_06` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_07` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_08` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_09` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_10` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_11` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `realisasi_12` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `capaian_tahapan`
--

INSERT INTO `capaian_tahapan` (`id`, `seksi_id`, `kegiatan_id`, `kegiatan_tahapan_id`, `target_all`, `is_mulai`, `yang_isi`, `bulan_awal`, `bulan_akhir`, `tahun`, `target_01`, `target_02`, `target_03`, `target_04`, `target_05`, `target_06`, `target_07`, `target_08`, `target_09`, `target_10`, `target_11`, `target_12`, `realisasi_01`, `realisasi_02`, `realisasi_03`, `realisasi_04`, `realisasi_05`, `realisasi_06`, `realisasi_07`, `realisasi_08`, `realisasi_09`, `realisasi_10`, `realisasi_11`, `realisasi_12`, `created_at`, `updated_at`) VALUES
('23f3a7f0-0b71-11eb-bb1e-17725385436a', '036', '69f9b7e0-09d3-11eb-96aa-597490b0644b', '23f12930-0b71-11eb-a41b-fb7ef985fc72', 0, '0', '0', 10, 10, '2020', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-10-11 03:23:32', '2020-10-11 03:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `ckp`
--

CREATE TABLE `ckp` (
  `id` varchar(36) NOT NULL,
  `nip_lama` varchar(10) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `target` smallint(6) NOT NULL,
  `realisasi` smallint(6) NOT NULL,
  `status` varchar(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dl`
--

CREATE TABLE `dl` (
  `id` varchar(36) NOT NULL,
  `nip_lama` varchar(10) NOT NULL,
  `seksi_id` varchar(3) NOT NULL,
  `status_spd` varchar(3) NOT NULL,
  `kegiatan_id` varchar(36) NOT NULL,
  `kegiatan_tahapan_id` varchar(36) NOT NULL,
  `kegiatan_tahapan_alokasi_dl_id` varchar(36) NOT NULL,
  `tanggal` varchar(2) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` varchar(36) NOT NULL,
  `seksi_id` varchar(3) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `anggaran` int(10) UNSIGNED NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `capaian_01` double(6,3) DEFAULT NULL,
  `capaian_02` double(6,3) DEFAULT NULL,
  `capaian_03` double(6,3) DEFAULT NULL,
  `capaian_04` double(6,3) DEFAULT NULL,
  `capaian_05` double(6,3) DEFAULT NULL,
  `capaian_06` double(6,3) DEFAULT NULL,
  `capaian_07` double(6,3) DEFAULT NULL,
  `capaian_08` double(6,3) DEFAULT NULL,
  `capaian_09` double(6,3) DEFAULT NULL,
  `capaian_10` double(6,3) DEFAULT NULL,
  `capaian_11` double(6,3) DEFAULT NULL,
  `capaian_12` double(6,3) DEFAULT NULL,
  `capaian_total` double(6,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `seksi_id`, `nama`, `anggaran`, `tahun`, `capaian_01`, `capaian_02`, `capaian_03`, `capaian_04`, `capaian_05`, `capaian_06`, `capaian_07`, `capaian_08`, `capaian_09`, `capaian_10`, `capaian_11`, `capaian_12`, `capaian_total`, `created_at`, `updated_at`) VALUES
('30a28440-0b59-11eb-a7fe-cb483e96bfd1', '036', 'Clustering BS 2020', 1300, '2020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.000, '2020-10-11 00:32:06', '2020-10-11 00:32:06'),
('69f9b7e0-09d3-11eb-96aa-597490b0644b', '036', 'Pengumpulan Data KCA', 1250000, '2020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.000, NULL, NULL, 0.000, '2020-10-09 02:01:58', '2020-10-11 03:23:32'),
('e3bca1e0-0b62-11eb-977c-f92131d604cc', '036', 'MFD 2020 A', 5000000, '2020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.000, '2020-10-11 01:41:32', '2020-10-11 02:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_pj`
--

CREATE TABLE `kegiatan_pj` (
  `id` varchar(36) NOT NULL,
  `kegiatan_id` varchar(36) NOT NULL,
  `nip_lama` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kegiatan_pj`
--

INSERT INTO `kegiatan_pj` (`id`, `kegiatan_id`, `nip_lama`, `created_at`, `updated_at`) VALUES
('b64efbc0-0b61-11eb-80d6-efc6d1ca6779', '30a28440-0b59-11eb-a7fe-cb483e96bfd1', '340058426', '2020-10-11 01:33:06', '2020-10-11 01:33:06'),
('fb1d7560-0aa3-11eb-a0e2-add5d86df117', '69f9b7e0-09d3-11eb-96aa-597490b0644b', '340058426', '2020-10-10 02:54:57', '2020-10-10 02:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_tahapan`
--

CREATE TABLE `kegiatan_tahapan` (
  `id` varchar(36) NOT NULL,
  `seksi_id` varchar(3) NOT NULL,
  `kegiatan_id` varchar(36) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `target_all` int(11) NOT NULL,
  `ref_kode` varchar(10) NOT NULL,
  `bobot_kegiatan_tahapan` smallint(5) UNSIGNED NOT NULL,
  `awal` date NOT NULL,
  `akhir` date NOT NULL,
  `bulan_awal` tinyint(3) UNSIGNED NOT NULL,
  `bulan_akhir` tinyint(3) UNSIGNED NOT NULL,
  `is_mulai` varchar(1) NOT NULL,
  `yang_isi` varchar(1) NOT NULL,
  `status_spd` varchar(1) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `capaian_01` double(6,3) DEFAULT NULL,
  `capaian_02` double(6,3) DEFAULT NULL,
  `capaian_03` double(6,3) DEFAULT NULL,
  `capaian_04` double(6,3) DEFAULT NULL,
  `capaian_05` double(6,3) DEFAULT NULL,
  `capaian_06` double(6,3) DEFAULT NULL,
  `capaian_07` double(6,3) DEFAULT NULL,
  `capaian_08` double(6,3) DEFAULT NULL,
  `capaian_09` double(6,3) DEFAULT NULL,
  `capaian_10` double(6,3) DEFAULT NULL,
  `capaian_11` double(6,3) DEFAULT NULL,
  `capaian_12` double(6,3) DEFAULT NULL,
  `capaian_total` double(6,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kegiatan_tahapan`
--

INSERT INTO `kegiatan_tahapan` (`id`, `seksi_id`, `kegiatan_id`, `nama`, `target_all`, `ref_kode`, `bobot_kegiatan_tahapan`, `awal`, `akhir`, `bulan_awal`, `bulan_akhir`, `is_mulai`, `yang_isi`, `status_spd`, `tahun`, `capaian_01`, `capaian_02`, `capaian_03`, `capaian_04`, `capaian_05`, `capaian_06`, `capaian_07`, `capaian_08`, `capaian_09`, `capaian_10`, `capaian_11`, `capaian_12`, `capaian_total`, `created_at`, `updated_at`) VALUES
('23f12930-0b71-11eb-a41b-fb7ef985fc72', '036', '69f9b7e0-09d3-11eb-96aa-597490b0644b', 'Pembuatan Tabel', 0, 'PerPen', 1, '2020-10-01', '2020-10-31', 10, 10, '0', '0', '0', '2020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.000, '2020-10-11 03:23:32', '2020-10-11 03:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_tahapan_alokasi_dl`
--

CREATE TABLE `kegiatan_tahapan_alokasi_dl` (
  `id` varchar(36) NOT NULL,
  `nip_lama` varchar(10) NOT NULL,
  `seksi_id` varchar(3) NOT NULL,
  `status_spd` varchar(3) NOT NULL,
  `kegiatan_id` varchar(36) NOT NULL,
  `kegiatan_tahapan_id` varchar(36) NOT NULL,
  `jumlah_dl` int(11) NOT NULL,
  `real_jumlah_dl` int(11) NOT NULL,
  `awal` date NOT NULL,
  `akhir` date NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_tahapan_spd`
--

CREATE TABLE `kegiatan_tahapan_spd` (
  `id` varchar(36) NOT NULL,
  `seksi_id` varchar(3) NOT NULL,
  `kegiatan_id` varchar(36) NOT NULL,
  `kegiatan_tahapan_id` varchar(36) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `target_all` int(11) NOT NULL,
  `ref_kode` varchar(10) NOT NULL,
  `status_spd` varchar(3) NOT NULL,
  `spd_tanggal_awal` date NOT NULL,
  `spd_tanggal_akhir` date NOT NULL,
  `spd_nomor_awal` int(11) NOT NULL,
  `spd_nomor_akhir` int(11) NOT NULL,
  `program` varchar(20) NOT NULL,
  `keg_out_komp` varchar(20) NOT NULL,
  `rate_penginapan` int(11) NOT NULL,
  `rate_uang_harian` int(11) NOT NULL,
  `tanggal_pembuatan` date NOT NULL,
  `tanggal_ttd_kuitansi` date NOT NULL,
  `status_penginapan` varchar(1) NOT NULL,
  `status_tanggal_pembuatan` varchar(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_08_31_011257_create_capaian_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `id` varchar(36) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ref_kegiatan_tahapan`
--

CREATE TABLE `ref_kegiatan_tahapan` (
  `id` int(10) UNSIGNED NOT NULL,
  `ref_kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bobot` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ref_kegiatan_tahapan`
--

INSERT INTO `ref_kegiatan_tahapan` (`id`, `ref_kode`, `nama`, `bobot`) VALUES
(1, 'PelPet', 'Pelatihan Petugas', 2),
(2, 'PerPem', 'Persiapan Pemutakhiran', 1),
(3, 'Pem', 'Pemutakhiran', 3),
(4, 'PerPen', 'Persiapan Pencacahan', 1),
(5, 'Pen', 'Pencacahan', 10),
(6, 'Bat', 'Batching', 1),
(7, 'EdiCod', 'Editing Coding', 5),
(8, 'Pel', 'Pelatihan Data Entry', 2),
(9, 'DatEnt', 'Data Entry', 5),
(10, 'Val', 'Validasi', 10),
(11, 'Kirdat', 'Kirim data', 2);

-- --------------------------------------------------------

--
-- Table structure for table `seksi`
--

CREATE TABLE `seksi` (
  `id` varchar(3) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seksi`
--

INSERT INTO `seksi` (`id`, `nama`) VALUES
('030', 'Kepala BPS Kabupaten'),
('031', 'Sub Bagian Tata Usaha'),
('032', 'Seksi Statistik Sosial'),
('033', 'Seksi Statistik Produksi'),
('034', 'Seksi Statistik Distibusi'),
('035', 'Seksi Nerwilis'),
('036', 'Seksi IPDS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `nip_baru` varchar(30) NOT NULL,
  `nip_lama` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `golongan_terakhir` varchar(30) NOT NULL,
  `status_kendaraan` varchar(1) NOT NULL,
  `seksi_id` varchar(3) DEFAULT NULL,
  `is_kasi_plt` varchar(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nip_baru`, `nip_lama`, `nama`, `jabatan`, `golongan_terakhir`, `status_kendaraan`, `seksi_id`, `is_kasi_plt`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'anasir', '19751210 199712 1 001', '340015522', 'Achmad Nasir, S.Si, MM', 'Kepala BPS Kabupaten Mamasa', 'IV/a', '1', '030', '1', '$2y$10$0LpLLVCIIJj/K8FsKHvnie8X8mthQZoETwNTX27VXY/1FhfqGZGmW', NULL, '2020-10-09 02:01:41', '2020-10-09 02:01:41'),
(2, 'heraw', '19840408 200604 2 002', '340018167', 'Herawaty, S.Si', 'Kasubbag TU', 'III/d', '1', '031', '1', '$2y$10$jirxekjVcqQQOqjZUX6r1e/TICywbUhmEXKHcn5.Vvs/KQduSnbVW', NULL, '2020-10-09 02:01:41', '2020-10-09 02:01:41'),
(3, 'serly', '19831005201101 2 019', '340055540', 'Serly,SE', 'Kepala Seksi Statistik Distribusi', 'III/c', '1', '034', '1', '$2y$10$vosmK4jA1MEjoM8pK2fSAOQTXy/ymMDG8YmS0ogLuHnDjbkj0LVy2', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(4, 'herni2', '19800402 201101 2 003', '340055535', 'Herni, SE', 'Kepala Seksi Statistik Produksi', 'III/c', '0', '033', '1', '$2y$10$GSipmEQMlmjzd05L2I0HG.T/Y/30ribvzhUlA/NI/vko6bjx79HKS', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(5, 'evi.arianti', '19930430 201602 2 001', '340057367', 'Evi Arianti, S.ST', 'Staf Seksi Nerwilis', 'III/a', '1', '035', '2', '$2y$10$KS3cjMnHQgKBKBB/VrXzwut2FaclsgHjgEp7NsLFacZS4xvf2wUH2', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(6, 'julian.emba', '19930722 201602 1 001', '340057442', 'Julian Emba Mangosa\', S.ST', 'Staf Seksi Statistik Sosial', 'III/a', '1', '032', '2', '$2y$10$rpY1igrnztE4f/kThqNTceE.bPwXYlXl8izQG72AwOK8tMiqZfqxq', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(7, 'budi.akkas', '19950408 201802 1 001', '340058179', 'Budi Setiawan Akkas, S.ST', 'Staf Seksi IPDS', 'III/a', '0', '036', '2', '$2y$10$xCsIhGhCXetXGer7hmt2Numps3hCoMmUZKVoMork5GZJDQC6WQZlC', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(8, 'anthon', '19790601 200901 1 007', '340052033', 'Antonius Ta\'dung, SE', 'Staf Subbag TU', 'III/a', '0', '031', '0', '$2y$10$RmB0dzRh5LYO8Q5HeMKcf.an2Qmh.uy7txTL0rI2HE0w6PYdZ6w5G', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(9, 'prasetyo.audina', '19950610 201802 2 001', '340058426', 'Prasetyo Audina Vera Utami, S.ST', 'Staf Subbag TU', 'III/a', '0', '031', '0', '$2y$10$fyqftp4qWUUBThcCYOj0FOWtxpw3tMCiXOxzZH3WkAIIOP2eydsY2', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(10, 'fitria.ramadhan', '19970125 201901 2 002', '340058740', 'Fitria Ramadhan, S.Tr.Stat', 'Staf Subbag TU', 'III/a', '0', '031', '0', '$2y$10$jQpZrj304rRjhVf1FRopLOBWmoQc.CfbtFzfG2pYRiWfLI7o.rh6S', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(11, 'mitsaq.zamir', '19950611 201701 1 001', '340057953', 'Muhammad Mitsaq Zamir, S.ST', 'Staf Seksi Produksi', 'III/a', '1', '033', '0', '$2y$10$pE9GokYCP6FMvFVNEKrzqekRbPKojnLEeRhb9gJ49tkqpETF2nDly', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(12, 'fajar.firmansyah', '19950116 201701 1 001', '340057950', 'M Fajar Firmansyah, S.ST', 'Staf Seksi Distribusi', 'III/a', '0', '034', '0', '$2y$10$dbw7UlCoVb3aES1CuRUsPOPDVQwNo5CWd0yxMciZF0lDp90AR2BrG', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(13, 'madeleine.octria', '19961025 201802 2 001', '340058334', 'Madeleine Octria Viviani, S.ST', 'Staf Seksi Statistik Sosial', 'III/a', '0', '032', '0', '$2y$10$SAvBVJ9SKVEFjmRIvP6e/enix5v9fiiHjayEcXE019dKn.VmEwNAe', NULL, '2020-10-09 02:01:42', '2020-10-09 02:01:42'),
(14, 'anggoro.rahmadi', '19940322 201802 1 001', '340058140', 'Anggoro Rahmadi, S.ST', 'Staf Seksi Nerwilis', 'III/a', '0', '035', '0', '$2y$10$yvqcUE5ux/1ug8tXUR1Faep4S7EkuQK0pOjyrJ3.WIETg3Zz/ZH4m', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(15, 'pandi.ridho', '19951013 201802 1 002', '340058381', 'Muhammad Pandi Ridho, S.ST', 'Staf Seksi Distribusi', 'III/a', '1', '034', '0', '$2y$10$Djj4O7ydBw7zs85Xv5fwEenCbVYOYdOdYTDWD5dMdiHLJG32oBgiC', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(16, 'apella.melianta', '19920929 201602 2 001', '340057294', 'Apella Melianta, S.ST', 'Staf Seksi Produksi', 'III/a', '0', '033', '0', '$2y$10$Bojobmptitiw02LBJG4k7.IQHGUxJI6JF3FE1XFtEqPH9ZtgHrZke', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(17, 'elsa.maudina', '19960719 201901 2 001', '340058703', 'Elsa Maudina Avianti, S.Tr.Stat', 'Staf Seksi IPDS', 'III/a', '0', '036', '0', '$2y$10$FpwzQT0XQmdig5KafILPbu5rpiIcr2XxRkiADulNK7XjXN3bhm5Vm', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(18, 'laksmi.tri', '19970830 201912 2 001', '340059597', 'Laksmi Tri Gustini, S.Tr.Stat', 'Staf Seksi Statistik Sosial', 'III/a', '0', '032', '0', '$2y$10$pfXrPnfiyU.VPnBnUudRQeXz7WcQ6d.ytOEQf/uTY4WyrR49tjRZO', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(19, 'febriana.susi', '19970207 201912 2 001', '340059520', 'Febriana Susi Indahwati, S.Tr.Stat', 'Staf Seksi Nerwilis', 'III/a', '0', '035', '0', '$2y$10$Qu4Mv8JhbgiXJVJKLeKZQ.ro6sofLT/IGPvDIvjImOZDQdN5A8dGW', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(20, 'rustan3', '19671231 198902 1 005', '340012138', 'Rustan', 'KSK Sumarorong', 'III/c', '1', NULL, '0', '$2y$10$Ei0S2GMtn50U.N1L2W7HmOT6dG6S3Xh56P1onJ.mAfhyJQ3w.yD6u', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(21, 'helmy', '19881216 201101 1 005', '340055529', 'Ahmad Helmy,SE', 'KSK Messawa', 'III/c', '1', NULL, '0', '$2y$10$HIQ/0h5NdJijxsaHB0Bym.fMNOMhHde61pmlWA2o/Ai/Plkt0d7eO', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(22, 'david.buatasik', '19820929 200701 1 001', '340019788', 'David Marinna Buatasik', 'KSK Nosu', 'II/b', '1', NULL, '0', '$2y$10$QOBUwahLA/tqCDUU6ke0J.s9OVj/foxW.5kmF7uCnmqVim.sCe/zG', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(23, 'sitti.jamalia', '19790508 200701 2 003', '340019425', 'Sitti Jamalia', 'KSK Tabang', 'II/d', '1', NULL, '0', '$2y$10$kyC7bWf9ore8bqsgvPCf1.As0vA9mHf0CIkv7vsApFn/skEGSKqmy', NULL, '2020-10-09 02:01:43', '2020-10-09 02:01:43'),
(24, 'hariyanto5', '19731229 199803 1 002', '340015676', 'Hariyanto', 'KSK Mamasa', 'III/b', '1', NULL, '0', '$2y$10$wRDrP1p9Yeqfwd6UP6qDS.3wrSz.bmSQrls/qrIKk51.MKM5WcqqG', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(25, 'demarrapa', '19640101 200604 1 018', '340018952', 'Demarrapa', 'KSK Tanduk Kalua', 'II/d', '1', NULL, '0', '$2y$10$XXHJwrHCu7vkomzbmefV4e0q0gzwyWeC8m.tvAh6tTdTJOXkpKHfi', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(26, 'roberth', '19710903 200604 1 010', '340018955', 'Roberth', 'KSK Balla', 'III/c', '1', NULL, '0', '$2y$10$q4hA7j3HO0GW3WKuiy7CleuYmeZUsG.jfW9JpP2oZ.vNpxIlr/mQe', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(27, 'nikolas.sampe', '19750512 200901 1 011', '340052224', 'Nikolas Sampe', 'KSK Tawalian', 'II/c', '1', NULL, '0', '$2y$10$o2RTuYDop/sschmHIuuFkuWFvnQtvXSq6rcsJNqlJnyfyW9Nlg.W2', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(28, 'dwi.ardian', '19881119 200801 1 001', '340020271', 'Dwi Ardian', 'KSK Mambi', 'II/d', '1', NULL, '0', '$2y$10$VizkDurItq8Gp8pAd4E2SOxZ4/b2Lb/zvzMFb1L.mjhCIJ3fD8uXe', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(29, 'asemkasatwa', '19781015 200701 1 002', '340019453', 'Asemkasatwa', 'KSK Bambang', 'II/d', '1', NULL, '0', '$2y$10$mcvGQ6CZBtP5EcFmyBFW1.leJkzgAY5bRcxZkguCXu60NMedMmAa6', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(30, 'tison', '19811105 200911 1 001', '340053165', 'Tison', 'KSK Rantebulahan Timur', 'II/c', '1', NULL, '0', '$2y$10$mECHmPRmiSaBH7bYR5puaO4C6tWcM56BepmEYksAx0VmtRTN3u332', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(31, 'harijal', '19680107 198902 1 001', '340012137', 'Harijal', 'KSK Mehalaan', 'III/c', '1', NULL, '0', '$2y$10$oYQeGMdyqTwxcMEgZq9tNO1rSThKh/JQxmFZ4p5I7aaWOEggeDNJm', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(32, 'aliruddin', '19651015 200701 1 003', '340019541', 'Aliruddin', 'KSK Aralle', 'II/d', '1', NULL, '0', '$2y$10$LhRhiWDjAf513EGA6GCoQe7bmWsSmovjxnRSsDmQt.xkBAoc8uGC6', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(33, 'adam.pasau', '19710720 200701 1 004', '340019542', 'Adam Pasau\'', 'KSK Buntu Malangka', 'II/d', '1', NULL, '0', '$2y$10$IIbeb5pqk3LMtUurYvKe7eP9091OzNATbIqAZHaMDQF9ckaylMAFu', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44'),
(34, 'hans2', '19700731 200312 1 002', '340017220', 'Hans', 'KSK Tabulahan', 'II/d', '1', NULL, '0', '$2y$10$NN3rGfMP7I4UVxcLmFxUFec.DHZewnMYrgVmh4xrCp7EzNArdzSZG', NULL, '2020-10-09 02:01:44', '2020-10-09 02:01:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capaian_individu`
--
ALTER TABLE `capaian_individu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_kinerja_individu` (`tahun`,`nip_lama`,`mitra_id`,`kegiatan_id`,`kegiatan_tahapan_id`),
  ADD KEY `capaian_individu_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `capaian_individu_kegiatan_tahapan_id_foreign` (`kegiatan_tahapan_id`),
  ADD KEY `capaian_individu_capaian_tahapan_id_foreign` (`capaian_tahapan_id`);

--
-- Indexes for table `capaian_tahapan`
--
ALTER TABLE `capaian_tahapan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_kinerja_seksi` (`tahun`,`seksi_id`,`kegiatan_id`,`kegiatan_tahapan_id`),
  ADD KEY `capaian_tahapan_seksi_id_foreign` (`seksi_id`),
  ADD KEY `capaian_tahapan_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `capaian_tahapan_kegiatan_tahapan_id_foreign` (`kegiatan_tahapan_id`);

--
-- Indexes for table `ckp`
--
ALTER TABLE `ckp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ckp_nip_lama_bulan_tahun_unique` (`nip_lama`,`bulan`,`tahun`);

--
-- Indexes for table `dl`
--
ALTER TABLE `dl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dl_nip_lama_foreign` (`nip_lama`),
  ADD KEY `dl_seksi_id_foreign` (`seksi_id`),
  ADD KEY `dl_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `dl_kegiatan_tahapan_id_foreign` (`kegiatan_tahapan_id`),
  ADD KEY `dl_kegiatan_tahapan_alokasi_dl_id_foreign` (`kegiatan_tahapan_alokasi_dl_id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_seksi_id_foreign` (`seksi_id`);

--
-- Indexes for table `kegiatan_pj`
--
ALTER TABLE `kegiatan_pj`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kegiatan_pj_kegiatan_id_nip_lama_unique` (`kegiatan_id`,`nip_lama`),
  ADD KEY `kegiatan_pj_nip_lama_foreign` (`nip_lama`);

--
-- Indexes for table `kegiatan_tahapan`
--
ALTER TABLE `kegiatan_tahapan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_tahapan_seksi_id_foreign` (`seksi_id`),
  ADD KEY `kegiatan_tahapan_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `kegiatan_tahapan_ref_kode_foreign` (`ref_kode`);

--
-- Indexes for table `kegiatan_tahapan_alokasi_dl`
--
ALTER TABLE `kegiatan_tahapan_alokasi_dl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_tahapan_alokasi_dl_nip_lama_foreign` (`nip_lama`),
  ADD KEY `kegiatan_tahapan_alokasi_dl_seksi_id_foreign` (`seksi_id`),
  ADD KEY `kegiatan_tahapan_alokasi_dl_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `kegiatan_tahapan_alokasi_dl_kegiatan_tahapan_id_foreign` (`kegiatan_tahapan_id`);

--
-- Indexes for table `kegiatan_tahapan_spd`
--
ALTER TABLE `kegiatan_tahapan_spd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_tahapan_spd_seksi_id_foreign` (`seksi_id`),
  ADD KEY `kegiatan_tahapan_spd_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `kegiatan_tahapan_spd_kegiatan_tahapan_id_foreign` (`kegiatan_tahapan_id`),
  ADD KEY `kegiatan_tahapan_spd_ref_kode_foreign` (`ref_kode`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_kegiatan_tahapan`
--
ALTER TABLE `ref_kegiatan_tahapan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref_kegiatan_tahapan_ref_kode_unique` (`ref_kode`);

--
-- Indexes for table `seksi`
--
ALTER TABLE `seksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_nip_baru_unique` (`nip_baru`),
  ADD UNIQUE KEY `users_nip_lama_unique` (`nip_lama`),
  ADD KEY `users_seksi_id_foreign` (`seksi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ref_kegiatan_tahapan`
--
ALTER TABLE `ref_kegiatan_tahapan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `capaian_individu`
--
ALTER TABLE `capaian_individu`
  ADD CONSTRAINT `capaian_individu_capaian_tahapan_id_foreign` FOREIGN KEY (`capaian_tahapan_id`) REFERENCES `capaian_tahapan` (`id`),
  ADD CONSTRAINT `capaian_individu_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `capaian_individu_kegiatan_tahapan_id_foreign` FOREIGN KEY (`kegiatan_tahapan_id`) REFERENCES `kegiatan_tahapan` (`id`);

--
-- Constraints for table `capaian_tahapan`
--
ALTER TABLE `capaian_tahapan`
  ADD CONSTRAINT `capaian_tahapan_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `capaian_tahapan_kegiatan_tahapan_id_foreign` FOREIGN KEY (`kegiatan_tahapan_id`) REFERENCES `kegiatan_tahapan` (`id`),
  ADD CONSTRAINT `capaian_tahapan_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`);

--
-- Constraints for table `ckp`
--
ALTER TABLE `ckp`
  ADD CONSTRAINT `ckp_nip_lama_foreign` FOREIGN KEY (`nip_lama`) REFERENCES `users` (`nip_lama`);

--
-- Constraints for table `dl`
--
ALTER TABLE `dl`
  ADD CONSTRAINT `dl_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `dl_kegiatan_tahapan_alokasi_dl_id_foreign` FOREIGN KEY (`kegiatan_tahapan_alokasi_dl_id`) REFERENCES `kegiatan_tahapan_alokasi_dl` (`id`),
  ADD CONSTRAINT `dl_kegiatan_tahapan_id_foreign` FOREIGN KEY (`kegiatan_tahapan_id`) REFERENCES `kegiatan_tahapan` (`id`),
  ADD CONSTRAINT `dl_nip_lama_foreign` FOREIGN KEY (`nip_lama`) REFERENCES `users` (`nip_lama`),
  ADD CONSTRAINT `dl_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`);

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`);

--
-- Constraints for table `kegiatan_pj`
--
ALTER TABLE `kegiatan_pj`
  ADD CONSTRAINT `kegiatan_pj_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `kegiatan_pj_nip_lama_foreign` FOREIGN KEY (`nip_lama`) REFERENCES `users` (`nip_lama`);

--
-- Constraints for table `kegiatan_tahapan`
--
ALTER TABLE `kegiatan_tahapan`
  ADD CONSTRAINT `kegiatan_tahapan_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `kegiatan_tahapan_ref_kode_foreign` FOREIGN KEY (`ref_kode`) REFERENCES `ref_kegiatan_tahapan` (`ref_kode`),
  ADD CONSTRAINT `kegiatan_tahapan_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`);

--
-- Constraints for table `kegiatan_tahapan_alokasi_dl`
--
ALTER TABLE `kegiatan_tahapan_alokasi_dl`
  ADD CONSTRAINT `kegiatan_tahapan_alokasi_dl_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `kegiatan_tahapan_alokasi_dl_kegiatan_tahapan_id_foreign` FOREIGN KEY (`kegiatan_tahapan_id`) REFERENCES `kegiatan_tahapan` (`id`),
  ADD CONSTRAINT `kegiatan_tahapan_alokasi_dl_nip_lama_foreign` FOREIGN KEY (`nip_lama`) REFERENCES `users` (`nip_lama`),
  ADD CONSTRAINT `kegiatan_tahapan_alokasi_dl_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`);

--
-- Constraints for table `kegiatan_tahapan_spd`
--
ALTER TABLE `kegiatan_tahapan_spd`
  ADD CONSTRAINT `kegiatan_tahapan_spd_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `kegiatan_tahapan_spd_kegiatan_tahapan_id_foreign` FOREIGN KEY (`kegiatan_tahapan_id`) REFERENCES `kegiatan_tahapan` (`id`),
  ADD CONSTRAINT `kegiatan_tahapan_spd_ref_kode_foreign` FOREIGN KEY (`ref_kode`) REFERENCES `ref_kegiatan_tahapan` (`ref_kode`),
  ADD CONSTRAINT `kegiatan_tahapan_spd_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
