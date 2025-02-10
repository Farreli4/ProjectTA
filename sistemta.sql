-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2025 at 03:15 AM
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
-- Database: `sistemta`
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
  `nomor_telepon` varchar(25) NOT NULL,
  `form_persetujuan` varchar(255) DEFAULT NULL,
  `form_pendaftaran_persetujuan_tema(TA)` blob NOT NULL,
  `bukti_pembayaran(TA)` blob NOT NULL,
  `bukti_transkip_nilai(TA)` blob NOT NULL,
  `bukti_kelulusan_magang(TA)` blob NOT NULL,
  `form_pendaftaran_sempro(seminar)` blob NOT NULL,
  `lembar_persetujuan_proposal_ta(seminar)` blob NOT NULL,
  `buku_konsultasi_ta(seminar)` blob NOT NULL,
  `lembar_berita_acara(seminar)` blob NOT NULL,
  `lembar_persetujuan_laporan_ta(ujian)` blob NOT NULL,
  `form_pendaftaran_ujian_ta(ujian)` blob NOT NULL,
  `lembar_kehadiran_sempro(ujian)` blob NOT NULL,
  `buku_konsultasi_ta(ujian)` blob NOT NULL,
  `lembar_hasil_nilai_dosbim1(nilai)` blob NOT NULL,
  `lembar_hasil_nilai_dosbim2(nilai)` blob NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tema` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `username`, `pass`, `nim`, `prodi`, `kelas`, `nomor_telepon`, `form_persetujuan`, `form_pendaftaran_persetujuan_tema(TA)`, `bukti_pembayaran(TA)`, `bukti_transkip_nilai(TA)`, `bukti_kelulusan_magang(TA)`, `form_pendaftaran_sempro(seminar)`, `lembar_persetujuan_proposal_ta(seminar)`, `buku_konsultasi_ta(seminar)`, `lembar_berita_acara(seminar)`, `lembar_persetujuan_laporan_ta(ujian)`, `form_pendaftaran_ujian_ta(ujian)`, `lembar_kehadiran_sempro(ujian)`, `buku_konsultasi_ta(ujian)`, `lembar_hasil_nilai_dosbim1(nilai)`, `lembar_hasil_nilai_dosbim2(nilai)`, `create_at`, `tema`, `judul`) VALUES
(1, 'Rai', '', '', 'K3522064', '', '', '', NULL, '', 0x30, 0x30, 0x30, '', '', '', '', '', '', '', '', '', '', '2025-01-22 02:00:40', '', ''),
(2, 'farel', '', '', 'K3533029', 'PTIK', 'A', '', NULL, '', 0x30, 0x30, 0x30, '', '', '', '', '', '', '', '', '', '', '2025-01-31 02:46:52', 'Game3d', 'Pembuatan game3d berbasis blender\r\n'),
(3, 'Nur', '', '', 'K3522078', '', '', '', NULL, '', 0x30, 0x30, 0x30, '', '', '', '', '', '', '', '', '', '', '2025-01-22 09:09:32', '', ''),
(4, 'Zidan', '', '', 'K3522085', 'PTIK', 'A', '085729360001', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2025-01-31 02:36:41', 'Pemrograman', 'Pemrograman web menggunakan php');

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
(3, 'nama_dosen1', '', 0, '', '', '0000-00-00', 'dijadwalkan', '2025-01-24', '2025-01-24 04:13:03'),
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
  `status_tanggapan` tinyint(1) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_disetujui` date NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas_akhir`
--

INSERT INTO `tugas_akhir` (`id_mahasiswa`, `id_ta`, `tema`, `judul`, `alasan`, `tujuan`, `file_ta`, `status_pengajuan`, `status_tanggapan`, `tanggal_pengajuan`, `tanggal_disetujui`, `create_at`) VALUES
(3, 0, '', '', '', '', '', 'Ditolak', 0, '0000-00-00', '0000-00-00', '2025-01-27 04:14:20'),
(1, 1, '', '', '', '', '', 'Disetujui', 0, '0000-00-00', '0000-00-00', '2025-01-24 08:49:12'),
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
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
