-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 05:02 AM
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
-- Database: `db_rapot_yunifa`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen_yunifa`
--

CREATE TABLE `absen_yunifa` (
  `id_absen` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `keterangan` enum('hadir','izin','sakit','alfa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absen_yunifa`
--

INSERT INTO `absen_yunifa` (`id_absen`, `id_siswa`, `keterangan`) VALUES
(1, 1, 'hadir'),
(2, 2, 'izin'),
(3, 3, 'sakit'),
(4, 4, 'alfa');

-- --------------------------------------------------------

--
-- Table structure for table `guru_yunifa`
--

CREATE TABLE `guru_yunifa` (
  `id_guru` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nip` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru_yunifa`
--

INSERT INTO `guru_yunifa` (`id_guru`, `id_user`, `nip`, `nama`, `jk`) VALUES
(9, 6, 19860223, 'mariam ', 'perempuan'),
(10, 7, 15482632, 'gigin gantini', 'perempuan'),
(11, 5, 12652635, 'kiki junianti', 'perempuan'),
(12, 8, 12365423, 'irfan santika', 'laki-laki');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_yunifa`
--

CREATE TABLE `kelas_yunifa` (
  `id_kelas` int(11) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `id_guru` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas_yunifa`
--

INSERT INTO `kelas_yunifa` (`id_kelas`, `kelas`, `id_guru`) VALUES
(1, 'XI RPL A', 10),
(2, 'XII RPL B', 12),
(3, 'XI RPL B', 11),
(4, 'XII RPL A', 9);

-- --------------------------------------------------------

--
-- Table structure for table `mapel_yunifa`
--

CREATE TABLE `mapel_yunifa` (
  `id_mapel` varchar(5) NOT NULL,
  `mapel` varchar(50) NOT NULL,
  `kkm` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel_yunifa`
--

INSERT INTO `mapel_yunifa` (`id_mapel`, `mapel`, `kkm`) VALUES
('MP001', 'matematika', '75'),
('MP002', 'informatika', '80'),
('MP003', 'sejarah', '75'),
('MP004', 'bahasa indonesia', '75'),
('MP005', 'bahasa inggris', '75');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_yunifa`
--

CREATE TABLE `nilai_yunifa` (
  `id_nilai` varchar(10) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` varchar(5) NOT NULL,
  `nilai_tugas` varchar(50) NOT NULL,
  `nilai_uts` varchar(50) NOT NULL,
  `nilai_uas` varchar(50) NOT NULL,
  `nilai_akhir` varchar(50) DEFAULT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai_yunifa`
--

INSERT INTO `nilai_yunifa` (`id_nilai`, `id_siswa`, `id_mapel`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_akhir`, `deskripsi`, `semester`, `tahun_ajaran`) VALUES
('NS007', 3, 'MP002', '90', '89', '99', '92.666666666667', 'Sangat Baik. Menunjukkan pemahaman yang sangat mendalam pada semua materi.', '2', '2025-2026'),
('NS008', 3, 'MP001', '90', '89', '99', '92.666666666667', 'Sangat Baik. Menunjukkan pemahaman yang sangat mendalam pada semua materi.', '1', '2024-2025'),
('NS009', 4, 'MP002', '90', '78', '45', '71', 'Cukup. Pemahaman materi sudah memenuhi standar minimal.', '1', '2024-2025'),
('NS010', 1, 'MP004', '89', '67', '100', '85.333333333333', 'Baik. Sudah memahami sebagian besar materi dengan baik.', '2', '2025-2026'),
('NS011', 2, 'MP003', '90', '77', '89', '85.333333333333', 'Baik. Sudah memahami sebagian besar materi dengan baik.', '1', '2025-2026'),
('NS012', 3, 'MP003', '89', '78', '90', '85.666666666667', 'Baik. Sudah memahami sebagian besar materi dengan baik.', '2', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_yunifa`
--

CREATE TABLE `siswa_yunifa` (
  `id_siswa` int(11) NOT NULL,
  `nis` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa_yunifa`
--

INSERT INTO `siswa_yunifa` (`id_siswa`, `nis`, `nama`, `tempat_lahir`, `tgl_lahir`, `id_kelas`) VALUES
(1, 12543625, 'sila', 'erwerf', '2025-10-15', 4),
(2, 15462351, 'putri', 'fgdgdf', '2025-09-19', 2),
(3, 152486953, 'sukma', 'sdfsdt', '2025-08-19', 1),
(4, 154826957, 'arum', 'fghfgh', '2025-11-11', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_yunifa`
--

CREATE TABLE `user_yunifa` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_yunifa`
--

INSERT INTO `user_yunifa` (`id`, `username`, `password`, `role`) VALUES
(1, 'rizkyyunifa', 'yunifa123', 'siswa'),
(2, 'fadlangz', 'fadlan123', 'siswa'),
(3, 'salmaaaa', 'salma123', 'siswa'),
(4, 'amameng', 'rahma123', 'siswa'),
(5, 'kikij', 'kiki123', 'guru'),
(6, 'bumar', 'mariam123', 'guru'),
(7, 'gigant', 'gigin123', 'guru'),
(8, 'rdirfan', 'irfan123', 'guru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen_yunifa`
--
ALTER TABLE `absen_yunifa`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `fk_absen_siswa` (`id_siswa`);

--
-- Indexes for table `guru_yunifa`
--
ALTER TABLE `guru_yunifa`
  ADD PRIMARY KEY (`id_guru`),
  ADD KEY `user_guru` (`id_user`);

--
-- Indexes for table `kelas_yunifa`
--
ALTER TABLE `kelas_yunifa`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `walikelas` (`id_guru`);

--
-- Indexes for table `mapel_yunifa`
--
ALTER TABLE `mapel_yunifa`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `nilai_yunifa`
--
ALTER TABLE `nilai_yunifa`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `fk_mapel` (`id_mapel`),
  ADD KEY `fk_siswa` (`id_siswa`);

--
-- Indexes for table `siswa_yunifa`
--
ALTER TABLE `siswa_yunifa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `fk_kelas` (`id_kelas`);

--
-- Indexes for table `user_yunifa`
--
ALTER TABLE `user_yunifa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen_yunifa`
--
ALTER TABLE `absen_yunifa`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guru_yunifa`
--
ALTER TABLE `guru_yunifa`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kelas_yunifa`
--
ALTER TABLE `kelas_yunifa`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa_yunifa`
--
ALTER TABLE `siswa_yunifa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_yunifa`
--
ALTER TABLE `user_yunifa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absen_yunifa`
--
ALTER TABLE `absen_yunifa`
  ADD CONSTRAINT `fk_absen_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa_yunifa` (`id_siswa`);

--
-- Constraints for table `guru_yunifa`
--
ALTER TABLE `guru_yunifa`
  ADD CONSTRAINT `user_guru` FOREIGN KEY (`id_user`) REFERENCES `user_yunifa` (`id`);

--
-- Constraints for table `kelas_yunifa`
--
ALTER TABLE `kelas_yunifa`
  ADD CONSTRAINT `walikelas` FOREIGN KEY (`id_guru`) REFERENCES `guru_yunifa` (`id_guru`);

--
-- Constraints for table `nilai_yunifa`
--
ALTER TABLE `nilai_yunifa`
  ADD CONSTRAINT `fk_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel_yunifa` (`id_mapel`),
  ADD CONSTRAINT `fk_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa_yunifa` (`id_siswa`);

--
-- Constraints for table `siswa_yunifa`
--
ALTER TABLE `siswa_yunifa`
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_yunifa` (`id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
