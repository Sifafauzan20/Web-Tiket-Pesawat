-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Des 2023 pada 13.52
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erd`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bandara`
--

CREATE TABLE `bandara` (
  `id_bandara` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bandara`
--

INSERT INTO `bandara` (`id_bandara`, `nama`) VALUES
(1, 'Juanda International Airport'),
(2, 'Soekarno Hatta International Airport'),
(3, 'Ngurah Rai International Airport'),
(4, 'Kertajati Airport');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_maskapai` int(11) NOT NULL,
  `id_rute` int(11) NOT NULL,
  `waktu_keberangkatan` time NOT NULL,
  `waktu_tiba` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_maskapai`, `id_rute`, `waktu_keberangkatan`, `waktu_tiba`) VALUES
(1, 1, 1, '07:05:00', '08:40:00'),
(2, 2, 2, '08:00:00', '10:00:00'),
(3, 3, 3, '09:10:00', '11:00:00'),
(4, 4, 4, '13:00:00', '15:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `kelas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `kelas`) VALUES
(1, 'Ekonomi'),
(2, 'FirstClass'),
(3, 'bisnis'),
(4, 'eksekutif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kursi`
--

CREATE TABLE `kursi` (
  `id_kursi` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `no_kursi` int(11) NOT NULL,
  `status` enum('terisi','belum terisi','','') NOT NULL,
  `Harga` int(11) DEFAULT NULL,
  `id_jadwal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kursi`
--

INSERT INTO `kursi` (`id_kursi`, `id_kelas`, `no_kursi`, `status`, `Harga`, `id_jadwal`) VALUES
(1, 1, 101, 'belum terisi', 900000, 1),
(2, 1, 102, 'belum terisi', 700000, 1),
(3, 2, 101, 'terisi', 900000, 1),
(4, 2, 102, 'belum terisi', 900000, 1),
(5, 3, 101, 'belum terisi', 500000, 1),
(6, 3, 102, 'terisi', 900000, 1),
(7, 4, 101, 'terisi', 500000, 1),
(8, 4, 102, 'terisi', 120000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penumpang`
--

CREATE TABLE `penumpang` (
  `id_penumpang` int(11) NOT NULL,
  `nama_depan` varchar(50) NOT NULL,
  `nama_belakang` varchar(50) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `kewarganegaraan` varchar(30) NOT NULL,
  `nik` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penumpang`
--

INSERT INTO `penumpang` (`id_penumpang`, `nama_depan`, `nama_belakang`, `no_telepon`, `tanggal_lahir`, `kewarganegaraan`, `nik`) VALUES
(42, 'sifa ', 'fauzan', '0829238421', '2023-12-05', 'Indonesia', '306932472428'),
(43, '', '', '', '0000-00-00', '', ''),
(44, '', '', '', '0000-00-00', '', ''),
(45, '', '', '', '0000-00-00', '', ''),
(46, '', '', '', '0000-00-00', '', ''),
(47, '', '', '', '0000-00-00', '', ''),
(48, '', '', '', '0000-00-00', '', ''),
(49, '', '', '', '0000-00-00', '', ''),
(50, '', '', '', '0000-00-00', '', ''),
(51, '', '', '', '0000-00-00', '', ''),
(60, 'John', 'Brown', '67442689', '2023-12-01', 'Singapura', '34242424234'),
(61, 'John', 'Brown', '67442689', '2023-12-25', 'Singapura', '34242424234'),
(62, 'John', 'Brown', '67442689', '2004-02-12', 'Singapura', '34242424234'),
(63, 'John', 'Brown', '67442689', '1402-12-14', 'Singapura', '34242424234'),
(64, 'John', 'Brown', '67442689', '1402-12-14', 'Singapura', '34242424234'),
(65, 'John', 'Brown', '67442689', '2004-02-14', 'Singapura', '34242424234'),
(66, 'John', 'Brown', '67442689', '2004-02-14', 'Singapura', '34242424234');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesawat`
--

CREATE TABLE `pesawat` (
  `id_maskapai` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesawat`
--

INSERT INTO `pesawat` (`id_maskapai`, `nama`) VALUES
(1, 'Lion Air'),
(2, 'Batik Air'),
(3, 'Garuda Indonesia'),
(4, 'Wings Air');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rute`
--

CREATE TABLE `rute` (
  `id_rute` int(11) NOT NULL,
  `id_bandara` int(11) NOT NULL,
  `bandara_asal` varchar(50) NOT NULL,
  `bandara_tujuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rute`
--

INSERT INTO `rute` (`id_rute`, `id_bandara`, `bandara_asal`, `bandara_tujuan`) VALUES
(1, 1, 'Juanda International Airport', 'Soekarno Hatta International Airport'),
(2, 2, 'Soekarno Hatta International Airport', 'Juanda International Airport'),
(3, 3, 'Ngurah Rai International Airport', 'Kertajati Airport'),
(4, 4, 'Kertajati Airport', 'Ngurah Rai International Airport');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_kursi` int(11) NOT NULL,
  `tanggal_pemesanan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`id_tiket`, `id_transaksi`, `id_kursi`, `tanggal_pemesanan`) VALUES
(10, 12, 3, '2023-12-25'),
(11, 13, 6, '2023-12-25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_penumpang` int(11) NOT NULL,
  `id_kursi` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `metode_transaksi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_penumpang`, `id_kursi`, `tanggal`, `metode_transaksi`) VALUES
(12, 64, 3, '2023-12-25', 'Credit Card'),
(13, 66, 6, '2023-12-25', 'Credit Card');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`) VALUES
(1, 'sifa fauzan', 'sifafzn20@upi.edu', '$2y$10$fxVsDsDZlILPAaLmj7aRQesD5fzF7PsEthjIsQt1nwC.mMBHF.c9m'),
(2, 'a', 'a@a.a', '$2y$10$1R5dBhct3g9k.0stP3cj2.puBPefh2tqrZN1V8GWaVT8T3WSRpmpW');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bandara`
--
ALTER TABLE `bandara`
  ADD PRIMARY KEY (`id_bandara`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `PesawattoJadwal` (`id_maskapai`),
  ADD KEY `rutetojadwal` (`id_rute`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `kursi`
--
ALTER TABLE `kursi`
  ADD PRIMARY KEY (`id_kursi`),
  ADD KEY `Jadwaltokursi` (`id_jadwal`),
  ADD KEY `Kelastokursi` (`id_kelas`);

--
-- Indeks untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  ADD PRIMARY KEY (`id_penumpang`);

--
-- Indeks untuk tabel `pesawat`
--
ALTER TABLE `pesawat`
  ADD PRIMARY KEY (`id_maskapai`);

--
-- Indeks untuk tabel `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id_rute`),
  ADD KEY `BandaratoRute` (`id_bandara`);

--
-- Indeks untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `transaksitoTiket` (`id_transaksi`),
  ADD KEY `kursitotiket` (`id_kursi`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `PenumpangtoTransaksi` (`id_penumpang`),
  ADD KEY `kursitotransaksi` (`id_kursi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bandara`
--
ALTER TABLE `bandara`
  MODIFY `id_bandara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kursi`
--
ALTER TABLE `kursi`
  MODIFY `id_kursi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  MODIFY `id_penumpang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT untuk tabel `pesawat`
--
ALTER TABLE `pesawat`
  MODIFY `id_maskapai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `rute`
--
ALTER TABLE `rute`
  MODIFY `id_rute` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `PesawattoJadwal` FOREIGN KEY (`id_maskapai`) REFERENCES `pesawat` (`id_maskapai`),
  ADD CONSTRAINT `rutetojadwal` FOREIGN KEY (`id_rute`) REFERENCES `rute` (`id_rute`);

--
-- Ketidakleluasaan untuk tabel `kursi`
--
ALTER TABLE `kursi`
  ADD CONSTRAINT `Jadwaltokursi` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`),
  ADD CONSTRAINT `Kelastokursi` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Ketidakleluasaan untuk tabel `rute`
--
ALTER TABLE `rute`
  ADD CONSTRAINT `BandaratoRute` FOREIGN KEY (`id_bandara`) REFERENCES `bandara` (`id_bandara`);

--
-- Ketidakleluasaan untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `kursitotiket` FOREIGN KEY (`id_kursi`) REFERENCES `kursi` (`id_kursi`),
  ADD CONSTRAINT `transaksitoTiket` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `PenumpangtoTransaksi` FOREIGN KEY (`id_penumpang`) REFERENCES `penumpang` (`id_penumpang`),
  ADD CONSTRAINT `kursitotransaksi` FOREIGN KEY (`id_kursi`) REFERENCES `kursi` (`id_kursi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
