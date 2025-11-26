-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Nov 2025 pada 07.38
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bayu_wangy`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `merk_detail` varchar(255) DEFAULT NULL,
  `koleksi` varchar(150) DEFAULT NULL,
  `tipe_parfum` varchar(150) DEFAULT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `top_notes` varchar(255) DEFAULT NULL,
  `heart_notes` varchar(255) DEFAULT NULL,
  `base_notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `merk`, `merk_detail`, `koleksi`, `tipe_parfum`, `ukuran`, `harga`, `gambar_produk`, `deskripsi`, `top_notes`, `heart_notes`, `base_notes`) VALUES
(1, 'Erba Pura', 'Xerjoff', NULL, NULL, NULL, NULL, 5500000, 'images/erbapura.jpg', NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
