-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jun 2026 pada 06.37
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_udang`
--

CREATE TABLE `data_udang` (
  `id_data` int(11) NOT NULL,
  `umur_udang` int(11) NOT NULL,
  `populasi` int(11) NOT NULL,
  `id_umur` int(11) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT (CURRENT_DATE),
  `pakan_harian` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_udang`
--

INSERT INTO `data_udang` (`id_data`, `umur_udang`, `populasi`, `id_umur`, `tanggal`, `pakan_harian`) VALUES
(101, 1, 5000, 4, '2026-03-30 08:50:37', '100.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_udang`
--

CREATE TABLE `jadwal_udang` (
  `id_jadwal_udang` int(11) NOT NULL,
  `id_data` int(11) DEFAULT NULL,
  `jadwal` time DEFAULT NULL,
  `id_umur` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT (CURRENT_DATE),
  `pakan_per_frekuensi` decimal(10,2) DEFAULT NULL,
  `fuzzy_pakan` float DEFAULT NULL,
  `suhu` float DEFAULT NULL,
  `berat_akhir` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jadwal_udang`
--

INSERT INTO `jadwal_udang` (`id_jadwal_udang`, `id_data`, `jadwal`, `id_umur`, `tanggal`, `pakan_per_frekuensi`, `fuzzy_pakan`, `suhu`, `berat_akhir`) VALUES
(380, 101, '06:30:00', 4, '2026-03-30', '25.00', NULL, NULL, NULL),
(381, 101, '10:30:00', 4, '2026-03-30', '25.00', NULL, NULL, NULL),
(382, 101, '15:56:00', 4, '2026-03-30', '25.00', NULL, NULL, NULL),
(383, 101, '21:00:00', 4, '2026-03-30', '25.00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `suhu_realtime`
--

CREATE TABLE `suhu_realtime` (
  `id` int(11) NOT NULL,
  `suhu` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `suhu_realtime`
--

INSERT INTO `suhu_realtime` (`id`, `suhu`) VALUES
(1, 30);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jadwal_pakan`
--

CREATE TABLE `tb_jadwal_pakan` (
  `id_jadwal` int(11) NOT NULL,
  `id_umur` int(11) NOT NULL,
  `jadwal` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_jadwal_pakan`
--

INSERT INTO `tb_jadwal_pakan` (`id_jadwal`, `id_umur`, `jadwal`) VALUES
(6, 4, '06:30:00'),
(7, 4, '10:30:00'),
(8, 4, '15:30:00'),
(9, 4, '21:00:00'),
(10, 5, '06:30:00'),
(11, 5, '10:30:00'),
(12, 5, '13:30:00'),
(13, 5, '15:30:00'),
(14, 5, '18:30:00'),
(15, 5, '22:30:00'),
(16, 6, '06:30:00'),
(17, 6, '10:30:00'),
(18, 6, '13:30:00'),
(19, 6, '15:30:00'),
(20, 6, '18:30:00'),
(21, 6, '22:30:00'),
(22, 6, '01:30:00'),
(23, 6, '03:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `umur_udang`
--

CREATE TABLE `umur_udang` (
  `id_umur` int(128) NOT NULL,
  `umur_udang` varchar(128) NOT NULL,
  `frekuensi_pakan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `umur_udang`
--

INSERT INTO `umur_udang` (`id_umur`, `umur_udang`, `frekuensi_pakan`) VALUES
(4, '1-10 Hari', 4),
(5, '11-20 hari', 6),
(6, '21-30 hari', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_user_level` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `id_user_level`, `nama`, `email`, `username`, `password`) VALUES
(1, 1, 'Kelompok D', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_level`
--

CREATE TABLE `user_level` (
  `id_user_level` int(11) NOT NULL,
  `user_level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_level`
--

INSERT INTO `user_level` (`id_user_level`, `user_level`) VALUES
(1, 'Administrator'),
(2, 'User');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_udang`
--
ALTER TABLE `data_udang`
  ADD PRIMARY KEY (`id_data`),
  ADD KEY `id_umur` (`id_umur`);

--
-- Indeks untuk tabel `jadwal_udang`
--
ALTER TABLE `jadwal_udang`
  ADD PRIMARY KEY (`id_jadwal_udang`),
  ADD KEY `id_data` (`id_data`),
  ADD KEY `id_umur` (`id_umur`);

--
-- Indeks untuk tabel `suhu_realtime`
--
ALTER TABLE `suhu_realtime`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_jadwal_pakan`
--
ALTER TABLE `tb_jadwal_pakan`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `fk_id_umur` (`id_umur`);

--
-- Indeks untuk tabel `umur_udang`
--
ALTER TABLE `umur_udang`
  ADD PRIMARY KEY (`id_umur`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_user_level` (`id_user_level`);

--
-- Indeks untuk tabel `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id_user_level`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_udang`
--
ALTER TABLE `data_udang`
  MODIFY `id_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `jadwal_udang`
--
ALTER TABLE `jadwal_udang`
  MODIFY `id_jadwal_udang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=384;

--
-- AUTO_INCREMENT untuk tabel `tb_jadwal_pakan`
--
ALTER TABLE `tb_jadwal_pakan`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `umur_udang`
--
ALTER TABLE `umur_udang`
  MODIFY `id_umur` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id_user_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_udang`
--
ALTER TABLE `data_udang`
  ADD CONSTRAINT `data_udang_ibfk_1` FOREIGN KEY (`id_umur`) REFERENCES `umur_udang` (`id_umur`);

--
-- Ketidakleluasaan untuk tabel `jadwal_udang`
--
ALTER TABLE `jadwal_udang`
  ADD CONSTRAINT `jadwal_udang_ibfk_1` FOREIGN KEY (`id_data`) REFERENCES `data_udang` (`id_data`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_udang_ibfk_2` FOREIGN KEY (`id_umur`) REFERENCES `umur_udang` (`id_umur`);

--
-- Ketidakleluasaan untuk tabel `tb_jadwal_pakan`
--
ALTER TABLE `tb_jadwal_pakan`
  ADD CONSTRAINT `fk_id_umur` FOREIGN KEY (`id_umur`) REFERENCES `umur_udang` (`id_umur`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_user_level`) REFERENCES `user_level` (`id_user_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
