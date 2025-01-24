-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 05:51 AM
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
  `form_persetujuan` varchar(255) DEFAULT NULL,
  `bukti_pembayaran` tinyint(1) NOT NULL,
  `bukti_transkip` tinyint(1) NOT NULL,
  `sistem_magang` tinyint(1) NOT NULL,
  `nomor_telepon` varchar(25) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `username`, `pass`, `nim`, `prodi`, `kelas`, `form_persetujuan`, `bukti_pembayaran`, `bukti_transkip`, `sistem_magang`, `nomor_telepon`, `create_at`) VALUES
(1, 'Rai', '', '', 'K3522064', '', '', NULL, 0, 0, 0, '', '2025-01-22 02:00:40'),
(2, 'Izza', '', '', 'K3533029', '', '', NULL, 0, 0, 0, '', '2025-01-22 07:35:32'),
(3, 'Nur', '', '', 'K3522078', '', '', NULL, 0, 0, 0, '', '2025-01-22 09:09:32');

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
(1, '', 'Rai', 0, '', '', '2004-06-16', 'selesai', '2004-06-18', '2025-01-22 08:49:00'),
(2, 'nama_dosen1', 'Izza', 0, '', '', '0000-00-00', 'dijadwalkan', '2020-10-23', '2025-01-24 03:43:16'),
(3, 'nama_dosen1', '', 0, '', '', '0000-00-00', 'dijadwalkan', '2025-01-24', '2025-01-24 04:13:03');

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
  `status_tanggapan` tinyint(1) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_disetujui` date NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas_akhir`
--

INSERT INTO `tugas_akhir` (`id_mahasiswa`, `id_ta`, `tema`, `judul`, `alasan`, `tujuan`, `file_ta`, `status_pengajuan`, `status_tanggapan`, `tanggal_pengajuan`, `tanggal_disetujui`, `create_at`) VALUES
(1, 1, '', '', '', '', '', 'Disetujui', 0, '0000-00-00', '0000-00-00', '2025-01-22 08:59:26'),
(2, 2, '', '', '', '', '', 'Revisi', 1, '0000-00-00', '2003-12-13', '2025-01-22 09:06:57');

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
(1, 0, NULL, NULL, '2025-01-24', NULL, NULL, NULL, NULL, 'selesai');

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
-- Indexes for table `seminar_proposal`
--
ALTER TABLE `seminar_proposal`
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
  ADD PRIMARY KEY (`id_ta`),
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
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `seminar_proposal`
--
ALTER TABLE `seminar_proposal`
  ADD CONSTRAINT `seminar_proposal_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`);

--
-- Constraints for table `tugas_akhir`
--
ALTER TABLE `tugas_akhir`
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
