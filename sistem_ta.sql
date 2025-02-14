-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 04:25 AM
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
-- Database: `sistem_ta`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `nomor_telepon` varchar(25) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosen_pembimbing`
--

CREATE TABLE `dosen_pembimbing` (
  `id_dosen` int(11) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `nomor_telepon` varchar(25) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nip` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen_pembimbing`
--

INSERT INTO `dosen_pembimbing` (`id_dosen`, `nama_dosen`, `username`, `pass`, `nomor_telepon`, `create_at`, `nip`, `prodi`) VALUES
(1, 'dosen\r\n', 'dosen1', 'dosen', '085', '2025-02-03 02:03:14', '2676478762574', 'PTIK');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `nim` varchar(25) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `kelas` varchar(25) NOT NULL,
  `sistem_magang` blob NOT NULL,
  `nomor_telepon` varchar(25) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tema` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `dosen_pembimbing` varchar(255) NOT NULL,
  `form_pendaftaran_TA` varchar(255) DEFAULT NULL,
  `form_persetujuan_TA` varchar(255) DEFAULT NULL,
  `bukti_pembayaran_TA` varchar(255) DEFAULT NULL,
  `bukti_transkip_nilai_TA` varchar(255) DEFAULT NULL,
  `bukti_kelulusan_magang_TA` varchar(255) DEFAULT NULL,
  `form_pendaftaran_sempro_seminar` varchar(255) DEFAULT NULL,
  `lembar_persetujuan_proposal_ta_seminar` varchar(255) DEFAULT NULL,
  `buku_konsultasi_ta_seminar` varchar(255) DEFAULT NULL,
  `lembar_berita_acara_seminar` varchar(255) DEFAULT NULL,
  `lembar_persetujuan_laporan_ta_ujian` varchar(255) DEFAULT NULL,
  `form_pendaftaran_ujian_ta_ujian` varchar(255) DEFAULT NULL,
  `lembar_kehadiran_sempro_ujian` varchar(255) DEFAULT NULL,
  `buku_konsultasi_ta_ujian` varchar(255) DEFAULT NULL,
  `lembar_hasil_nilai_dosbim1_nilai` varchar(255) DEFAULT NULL,
  `lembar_hasil_nilai_dosbim2_nilai` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `username`, `pass`, `nim`, `prodi`, `kelas`, `sistem_magang`, `nomor_telepon`, `create_at`, `tema`, `judul`, `dosen_pembimbing`, `form_pendaftaran_TA`, `form_persetujuan_TA`, `bukti_pembayaran_TA`, `bukti_transkip_nilai_TA`, `bukti_kelulusan_magang_TA`, `form_pendaftaran_sempro_seminar`, `lembar_persetujuan_proposal_ta_seminar`, `buku_konsultasi_ta_seminar`, `lembar_berita_acara_seminar`, `lembar_persetujuan_laporan_ta_ujian`, `form_pendaftaran_ujian_ta_ujian`, `lembar_kehadiran_sempro_ujian`, `buku_konsultasi_ta_ujian`, `lembar_hasil_nilai_dosbim1_nilai`, `lembar_hasil_nilai_dosbim2_nilai`) VALUES
(1, 'Rai', 'Rai', '2345', 'K3522064', '', '', 0x30, '', '2025-02-07 07:46:05', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'farel', '', '', 'K3533029', 'PTIK', 'A', 0x30, '', '2025-01-31 02:46:52', 'Game3d', 'Pembuatan game3d berbasis blender\r\n', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Nur', '', '', 'K3522078', '', '', 0x30, '', '2025-01-22 09:09:32', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Zidan', '', '', 'K3522085', 'PTIK', 'A', '', '085729360001', '2025-01-31 02:36:41', 'Pemrograman', 'Pemrograman web menggunakan php', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'reih', 'rei', 'c1d6e4fc7422656509d6988df576d75c439f2102297cc477633a02bb7d190c12', 'K3522032', 'ptik', 'A', '', '085772345231', '2025-02-10 01:48:44', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Kai', 'r', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'K3522032', 'ptik', 'A', '', '085772345231', '2025-02-10 01:49:20', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa_dosen`
--

CREATE TABLE `mahasiswa_dosen` (
  `id_mahasiswa` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa_dosen`
--

INSERT INTO `mahasiswa_dosen` (`id_mahasiswa`, `id_dosen`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `admin` int(11) DEFAULT NULL,
  `id_dosen` int(11) DEFAULT NULL,
  `id_mahasiswa` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seminar_proposal`
--

CREATE TABLE `seminar_proposal` (
  `id_mahasiswa` int(11) DEFAULT NULL,
  `dosen_pembimbing` enum('nama_dosen1','nama_dosen1') NOT NULL,
  `penyaji_seminar` varchar(100) NOT NULL,
  `kehadiran` int(10) NOT NULL,
  `sppsp` varchar(255) NOT NULL,
  `lbta` varchar(255) NOT NULL,
  `tanggal_disetujui` date NOT NULL,
  `status_seminar` enum('dijadwalkan','ditunda','selesai') NOT NULL,
  `tanggal_seminar` date NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seminar_proposal`
--

INSERT INTO `seminar_proposal` (`id_mahasiswa`, `dosen_pembimbing`, `penyaji_seminar`, `kehadiran`, `sppsp`, `lbta`, `tanggal_disetujui`, `status_seminar`, `tanggal_seminar`, `create_at`) VALUES
(1, '', 'Rai', 0, '', '', '2004-06-16', 'ditunda', '2004-06-18', '2025-01-27 04:14:39'),
(2, 'nama_dosen1', 'Izza', 0, '', '', '0000-00-00', 'dijadwalkan', '2020-10-23', '2025-01-24 03:43:16'),
(3, 'nama_dosen1', '', 0, '', '', '0000-00-00', 'ditunda', '2025-01-24', '2025-02-14 03:17:29'),
(4, 'nama_dosen1', '', 0, '', '', '0000-00-00', 'selesai', '2025-02-03', '2025-02-03 01:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_akhir`
--

CREATE TABLE `tugas_akhir` (
  `id_mahasiswa` int(11) NOT NULL,
  `id_ta` int(11) NOT NULL,
  `tema` varchar(100) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `file_ta` varchar(255) NOT NULL,
  `status_pengajuan` enum('Disetujui','Revisi','Ditolak') NOT NULL,
  `alasan_revisi` varchar(255) NOT NULL,
  `status_tanggapan` tinyint(1) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_disetujui` date NOT NULL,
  `dosen_pembimbing` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas_akhir`
--

INSERT INTO `tugas_akhir` (`id_mahasiswa`, `id_ta`, `tema`, `judul`, `alasan`, `tujuan`, `file_ta`, `status_pengajuan`, `alasan_revisi`, `status_tanggapan`, `tanggal_pengajuan`, `tanggal_disetujui`, `dosen_pembimbing`, `create_at`) VALUES
(1, 5, '', '', '', '', '', 'Revisi', 'belum maem', 0, '0000-00-00', '0000-00-00', 'dosen_1', '2025-02-12 00:03:39'),
(2, 6, '', '', '', '', '', 'Ditolak', '', 0, '0000-00-00', '0000-00-00', '1', '2025-02-12 00:35:49'),
(3, 7, '', '', '', '', '', 'Revisi', '', 0, '0000-00-00', '0000-00-00', '', '2025-02-07 04:02:17'),
(4, 8, '', '', '', '', '', 'Disetujui', '', 0, '0000-00-00', '0000-00-00', '', '2025-02-07 04:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id_mahasiswa` int(11) DEFAULT NULL,
  `id_ujian` int(11) NOT NULL,
  `pernyataan_persetujuan` varchar(255) DEFAULT NULL,
  `tanggal_disetujui` date DEFAULT NULL,
  `tanggal_ujian` date DEFAULT NULL,
  `pembimbing` enum('nama_dosen1','nama_dosen2') DEFAULT NULL,
  `lbta` varchar(255) DEFAULT NULL,
  `penguji` enum('nama_dosen1','nama_dosen2','nama_dosen3') DEFAULT NULL,
  `nilai` int(100) DEFAULT NULL,
  `status_ujian` enum('dijadwalkan','selesai') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`id_mahasiswa`, `id_ujian`, `pernyataan_persetujuan`, `tanggal_disetujui`, `tanggal_ujian`, `pembimbing`, `lbta`, `penguji`, `nilai`, `status_ujian`) VALUES
(1, 0, NULL, NULL, '2025-01-24', NULL, NULL, NULL, NULL, 'dijadwalkan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `mahasiswa_dosen`
--
ALTER TABLE `mahasiswa_dosen`
  ADD PRIMARY KEY (`id_mahasiswa`,`id_dosen`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indexes for table `seminar_proposal`
--
ALTER TABLE `seminar_proposal`
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  ADD PRIMARY KEY (`id_ta`),
  ADD UNIQUE KEY `id_mahasiswa_2` (`id_mahasiswa`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mahasiswa_dosen`
--
ALTER TABLE `mahasiswa_dosen`
  ADD CONSTRAINT `mahasiswa_dosen_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`),
  ADD CONSTRAINT `mahasiswa_dosen_ibfk_2` FOREIGN KEY (`id_dosen`) REFERENCES `dosen_pembimbing` (`id_dosen`);

--
-- Constraints for table `notif`
--
ALTER TABLE `notif`
  ADD CONSTRAINT `notif_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`),
  ADD CONSTRAINT `notif_ibfk_2` FOREIGN KEY (`id_dosen`) REFERENCES `dosen_pembimbing` (`id_dosen`);

--
-- Constraints for table `seminar_proposal`
--
ALTER TABLE `seminar_proposal`
  ADD CONSTRAINT `seminar_proposal_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`);

--
-- Constraints for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  ADD CONSTRAINT `fk_id_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tugas_akhir_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`);

--
-- Constraints for table `ujian`
--
ALTER TABLE `ujian`
  ADD CONSTRAINT `ujian_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
