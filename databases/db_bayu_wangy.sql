-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Des 2025 pada 13.12
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
-- Struktur dari tabel `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `alamat` text NOT NULL DEFAULT '(Belum diisi)',
  `kota` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kode_pos` varchar(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alamat`
--

INSERT INTO `alamat` (`id_alamat`, `id_user`, `nama`, `telepon`, `alamat`, `kota`, `provinsi`, `kode_pos`, `updated_at`) VALUES
(5, 9, '', '081362148942', 'helvetia', 'medan', 'sumut', '288888', '2025-12-04 02:05:30'),
(9, 13, 'aguy', 'qwert123', '(Belum diisi)', '', '', '', '2025-12-05 01:14:29'),
(10, 14, 'yazri loopy', '0987654321', 'fasilkom', 'medan', 'sumut', '234567', '2025-12-05 01:53:54'),
(11, 15, 'Azriyad', '081212121212', '(Belum diisi)', '', '', '', '2025-12-05 02:57:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `nama_produk`, `harga_satuan`, `jumlah`) VALUES
(20, 14, 3, 'Soprano', 7000000.00, 1),
(21, 15, 2, 'Torino21', 7500000.00, 1),
(22, 16, 9, 'Yellow Diamond', 1398000.00, 3),
(23, 16, 8, 'Eau Fraiche', 1298000.00, 2),
(24, 17, 6, 'Eros EDT', 1800000.00, 1),
(25, 18, 1, 'Erba Pura', 4770000.00, 1),
(27, 20, 1, 'Erba Pura', 4770000.00, 1),
(28, 21, 1, 'Erba Pura', 4770000.00, 4),
(29, 22, 2, 'Torino21', 7500000.00, 1),
(30, 22, 6, 'Eros EDT', 1800000.00, 1),
(31, 22, 1, 'Erba Pura', 4770000.00, 1),
(32, 23, 2, 'Torino21', 7500000.00, 5),
(33, 23, 1, 'Erba Pura', 4770000.00, 1),
(34, 24, 1, 'Erba Pura', 4770000.00, 1),
(35, 25, 1, 'Erba Pura', 4770000.00, 1),
(36, 26, 1, 'Erba Pura', 4770000.00, 14),
(37, 26, 2, 'Torino21', 7500000.00, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_keranjang`
--

CREATE TABLE `item_keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `waktu_ditambah` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `item_keranjang`
--

INSERT INTO `item_keranjang` (`id_keranjang`, `id_user`, `id_produk`, `jumlah`, `waktu_ditambah`) VALUES
(32, NULL, 2, 1, '2025-12-03 22:37:30'),
(33, NULL, 2, 1, '2025-12-03 22:37:39'),
(54, 13, 1, 1, '2025-12-05 01:30:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat_detail` text NOT NULL,
  `total_produk` decimal(10,2) NOT NULL,
  `total_akhir` decimal(10,2) NOT NULL,
  `status_pesanan` varchar(50) DEFAULT 'Menunggu Pembayaran',
  `tanggal_pesan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `nama_lengkap`, `email`, `no_telepon`, `alamat_detail`, `total_produk`, `total_akhir`, `status_pesanan`, `tanggal_pesan`) VALUES
(14, NULL, 'Popo Siroyo', 'popo@gmail.com', '08', '(Belum diisi)', 7000000.00, 7020000.00, 'Menunggu Pembayaran', '2025-12-03 23:41:39'),
(15, 9, 'raymond', 'raymondsimarmata@gmail.com', '081362148942', 'helvetia', 7500000.00, 7520000.00, 'Dibatalkan', '2025-12-04 02:06:35'),
(16, 9, 'raymond', 'raymondsimarmata@gmail.com', '081362148942', 'jalan gaperta x9999', 6790000.00, 6810000.00, 'Dibatalkan', '2025-12-04 02:15:14'),
(17, NULL, 'Mipo Milas', 'mipo.milas@usu.ac.id', '0986542512', '(Belum diisi)', 1800000.00, 1820000.00, 'Menunggu Pembayaran', '2025-12-04 03:56:28'),
(18, NULL, 'raymond', 'farel@gmail.com', '0986542512', '(Belum diisi)', 4770000.00, 4790000.00, 'Menunggu Pembayaran', '2025-12-04 08:40:18'),
(20, NULL, 'Vimo', 'vimo@g.c', '081398475212', '(Belum diisi)', 4770000.00, 4790000.00, 'Menunggu Pembayaran', '2025-12-04 08:48:10'),
(21, NULL, 'Vimo', 'vimo@g.c', '081398475212', '(Belum diisi)', 19080000.00, 19100000.00, 'Selesai', '2025-12-04 08:50:46'),
(22, 9, 'raymond', 'raymondsimarmata@gmail.com', '081362148942', 'helvetia', 14070000.00, 14090000.00, 'Menunggu Pembayaran', '2025-12-05 00:46:32'),
(23, 13, 'aguy', 'uhuy@gmail.com', '1234789', '(Belum diisi)', 42270000.00, 42290000.00, 'Menunggu Pembayaran', '2025-12-05 01:15:36'),
(24, 14, 'felix', 'felix@gmail.com', '0987654321', 'fasilkom', 4770000.00, 4790000.00, 'Menunggu Pembayaran', '2025-12-05 01:35:08'),
(25, 15, 'Azriyad', 'pororo@gmail.com', '081212121212', '(Belum diisi)', 4770000.00, 4790000.00, 'Menunggu Pembayaran', '2025-12-05 03:01:46'),
(26, 9, 'raymond', 'raymondsimarmata@gmail.com', '081362148942', 'helvetia', 81780000.00, 81800000.00, 'Menunggu Pembayaran', '2025-12-05 10:13:09');

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
(1, 'Erba Pura', 'Xerjoff', 'Xerjoff', NULL, 'Eau De Parfume', '100ml', 4770000, 'images/erbapura.jpg', 'Erba Pura adalah parfum fruity-amber yang dikenal karena karakter aromanya yang vibrant, segar, dan memikat. Aroma awalnya manis-cerah seperti buah tropis, kemudian berkembang menjadi wangi yang creamy, bersih, dan elegan. Sangat fleksibel untuk harian maupun acara formal.', 'Orange, Bergamot, Sicilian Lemon', 'Mint, Lemon, Basil, Thyme', 'White Musk, Vanilla, Amber'),
(2, 'Torino21', 'Xerjoff', 'Xerjoff', NULL, 'Eau De Parfum', '100ml', 7500000, 'images/toreno21.jpg', 'Torino21 adalah parfum fresh-aromatic yang terkenal karena vibe-nya yang sangat energizing, cooling, dan clean. Dengan aroma mint segar yang dipadukan citrus dan herbal note, parfum ini memberikan kesan sporty, modern, dan menyegarkan sepanjang hari. Cocok untuk iklim panas dan aktivitas outdoor.', 'Mint, Lemon, Basil, Thyme', 'Jasmine, Rosemary', 'Musk, Amber, Verbena'),
(3, 'Soprano', 'Xerjoff', 'Xerjoff', NULL, 'Eau de Parfum', '100ml', 7000000, 'images/suprano.jpg', 'Soprano adalah parfum oriental-floral intens yang memadukan kekayaan aroma Timur Tengah dengan sentuhan buah manis dan bunga eksotis. Wangi awalnya fruity tebal, kemudian berubah menjadi floral creamy, lalu ditutup dengan base note oud, amber, dan leather yang sangat mewah & bold. Parfum ini cocok untuk malam hari, acara formal, dan suasana elegan.', 'Fruity Notes, Milk, Litchi', 'Rose, Osmanthus, Jasmine', 'Oud, Leather, Amber, Patchouli, Vanilla'),
(4, 'Alexandria II', 'Xerjoff', 'Xerjoff', NULL, 'Eau de Parfum', '100ml', 8000000, 'images/alexandria2.jpg', 'Xerjoff Alexandria II adalah parfum woody-oriental yang dikenal karena auranya yang mewah, hangat, dan memikat. Dengan sentuhan oud berkualitas tinggi yang berpadu lembut dengan lavender, rosewood, dan vanila, parfum ini menghadirkan karakter yang elegan, refined, dan penuh kedalaman. Aromanya berkembang dari nuansa aromatik yang halus menuju kayu yang kaya dan manis-berresin, menciptakan kesan yang royal, sophisticated, dan berkelas.', 'Lavender, Rosewood, Cinnamon, Apple', 'Bulgarian Rose, Cedarwood, Lily of the Valley', 'Oud Laos, Amber, Sandalwood, Musk, Vanilla'),
(5, 'Opera', 'Xerjoff', 'Xerjoff', NULL, 'Eau de Parfum', '100ml', 8000000, 'images/opera.jpg', 'Opera adalah parfum oriental-woody yang kaya, elegan, dan dramatis. Wangi awalnya menampilkan buah kering dan floral yang hangat, kemudian berkembang menjadi aroma kayu, vanilla, dan musk yang mewah. Parfum ini punya karakter tebal, bold, dan sangat berkelas, cocok untuk acara malam, dinner formal, atau suasana prestisius.', 'Fruity notes, Turkish Rose', 'Ylang-Ylang, Leather, Nutmeg', 'Vanilla, Amber, Patchouli, Musk'),
(6, 'Eros EDT', 'Versace', 'Versace', NULL, 'Eau de Toilette', '100ml', 1800000, 'images/erosedt.webp', 'Versace Eros EDT adalah parfum ikonik yang memadukan kesegaran mint dan lemon dengan karakter vanilla dan cedarwood yang hangat. Aromanya maskulin, energik, dan sangat khas - cocok untuk kamu yang ingin tampil bold dengan sentuhan sensual.', 'Mint, Green Apple, Lemon.', 'Tonka Bean, Ambroxan, Geranium.', 'Vanilla, Cedarwood, Vetiver, Oakmoss.'),
(7, 'Dylan Blue', 'Versace', 'Versace', NULL, 'Eau de Toilette', '100ml', 1346000, 'images/dylanblue.jpg', 'Versace Dylan Blue menghadirkan aroma maskulin modern dengan perpaduan citrus segar, aroma pedas lembut, dan sentuhan amber yang hangat. Karakternya bersih, elegan, dan sangat versatile sehingga cocok digunakan untuk kegiatan santai hingga formal. Dylan Blue dikenal sebagai parfum pria yang charismatic dan easy-to-wear.', 'Calabrian Bergamot, Grapefruit.', 'Fig Leaves, Black Pepper, Ambrox.', 'Patchouli, Mineral Musk, Tonka Bean.'),
(8, 'Eau Fraiche', 'Versace', 'Versace', NULL, 'Eau de Toilette', '100ml', 1298000, 'images/EAUFRAICHE.jpg', 'Versace Man Eau Fraîche adalah parfum fresh aquatic dengan sentuhan woody yang ringan namun elegan. Wangi citrus yang segar berpadu dengan cedarwood yang clean dan musk yang lembut, menciptakan aroma maskulin yang cocok untuk cuaca panas dan aktivitas santai. Parfum ini memberikan kesan cerah, energik, dan stylish tanpa terasa berat.', 'Lemon, Bergamot, Rosewood', 'Tarragon, Cedar, Sage', 'Amber, Saffron, Musk'),
(9, 'Yellow Diamond', 'Versace', 'Versace', NULL, 'Eau de Toilette', '70ml', 1398000, 'images/yellow.jpg', 'Versace Yellow Diamond adalah parfum floral-citrus yang cerah, lembut, dan feminin. Aromanya memadukan citrus yang sparkling, floral yang bersih, dan sentuhan amber-musk yang halus sehingga memberi kesan anggun, hangat, dan berkilau seperti berlian kuning. Parfum ini cocok untuk wanita yang ingin tampil elegan, fresh, serta memancarkan aura positif sepanjang hari.', 'Bergamot, Lemon, Neroli', 'Pear Sorbet, Orange Blossom, Freesia, Mimosa', 'Water Lily, Amber, Musk, Guaiac Wood'),
(10, 'Pour Homme', 'Versace', 'Versace', NULL, 'Eau de Toilette', '100ml', 1300000, 'images/pourhomme.jpg', 'Versace Pour Homme adalah parfum segar maskulin dengan karakter citrus aromatic yang elegan dan bersih. Komposisinya memadukan lemon dan neroli yang fresh, bunga hyacinth yang halus, serta drydown musk-amber yang sangat gentleman. Wangi ini cocok untuk pria modern yang ingin tampil rapi, profesional, dan berenergi setiap hari.', 'Lemon, Neroli, Bergamot', 'Hyacinth, Clary Sage, Cedarwood', 'Tonka Bean, Musk, Amber'),
(11, 'Baccarat 540', 'Maison Francis Kurkdjian', 'Maison Francis Kurkdjian', NULL, 'Extrait de Parfum', '100ml', 12500000, 'images/baccarat.jpg', 'Baccarat Rouge 540 Eau de Parfum menghadirkan aroma manis-woody yang berkilau, elegan, dan sangat mudah dikenali. Perpaduan saffron dan jasmine membuka dengan karakter mewah yang hangat, kemudian ambergris memberi sentuhan mineral yang khas dan memikat. Cedarwood dan resin memberikan dimensi woody yang halus namun tahan lama.', 'Saffron, Jasmine, Amberwood', 'Ambergris, Fir Resin', 'Cedarwood'),
(12, 'Amyris', 'Maison Francis Kurkdjian', 'Maison Francis Kurkdjian', NULL, 'Extrait de Parfum', '35ml', 8750000, 'images/amyris.jpg', 'Amyris Homme Extrait menghadirkan versi yang lebih intens, dalam, dan kaya dibandingkan EDT-nya. Aroma mandarin diberi sentuhan hangat kayu manis, kemudian berpadu dengan amyris wood dan iris yang creamy sehingga menghasilkan wangi yang modern, elegan, dan sangat refined. Drydown tonka bean dan amber memberi kesan hangat, gentleman, dan berkelas sepanjang hari. Sebuah parfum maskulin mewah yang halus, sensual, dan memancarkan karisma natural tanpa terasa berlebihan.', 'Mandarin, Cinnamon', 'Amyris Wood, Iris', 'Tonka Bean, Amber Accord'),
(13, 'Oud', 'Maison Francis Kurkdjian', 'Maison Francis Kurkdjian', NULL, 'Extrait de Parfum', '35ml', 8750000, 'images/oudmaison.jpg', 'OUD dari Maison Francis Kurkdjian adalah interpretasi modern dan mewah dari oud Timur Tengah. Wangi ini memadukan oud yang kaya dan berkarakter dengan saffron yang berkilau, patchouli yang dalam, serta cedarwood yang memberikan kesan warm-woody. Hasilnya adalah aroma intens, aristokrat, dan sensual yang terasa sophisticated namun tetap halus. Cocok untuk pecinta parfum berkelas yang ingin menghadirkan nuansa misterius dan penuh wibawa.', 'Agarwood (Oud), Saffron', 'Cedarwood, Patchouli', 'Elemi Resin'),
(14, 'Carios', 'Parfums de Marly', 'Parfum de Marly', NULL, 'Extrait de Parfum', '125ml', 4850000, 'images/pdmcarios.jpg', 'Parfums de Marly Carios (custom creation style) menghadirkan aroma buah hijau yang segar, spicy, dan sedikit manis pada fase opening. Perpaduan rempah hangat dan nuansa green memberi kesan maskulin modern yang bersih dan energik. ada tahap drydown, wangi tonka bean, vanilla, dan patchouli menciptakan karakter creamy-warm yang elegan dan berkelas.', 'Apple, Green Notes', 'Spices, Tonka Bean', 'Patchouli, Vanilla, Woods'),
(15, 'Valero', 'Parfums de Marly', 'Parfums de Marly', NULL, 'Extrait de Parfum', '125ml', 4850000, 'images/pdmvalero.jpg', 'Valero adalah parfum maskulin dengan karakter citrus-aromatic yang segar sekaligus elegan. Opening cerah dari bergamot dan citrus zest memberi kesan bersih dan modern, diikuti sentuhan herbal lembut yang menambah aroma refined khas gentleman. Pada fase drydown, wangi kayu hangat, amber, dan musk muncul memberi kesan sensual namun tetap rapi dan classy.', 'Bergamot, Citrus Zest', 'Aromatic Herbs, Violet Leaf', 'Warm Woods, Amber, Soft Musk');

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimoni`
--

CREATE TABLE `testimoni` (
  `id_komen` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `rating` int(1) NOT NULL,
  `komentar` text NOT NULL,
  `tanggal_dibuat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `testimoni`
--

INSERT INTO `testimoni` (`id_komen`, `nama_user`, `rating`, `komentar`, `tanggal_dibuat`) VALUES
(1, 'Keyla B.', 3, 'Parfumnya bagus, wanginya mewah dan packaging-nya sangat niat!', '2025-11-29 15:07:39'),
(24, 'Kel 3 Proweb Kom A', 5, 'Bagus, karna kami yang buat ^_^', '2025-11-29 12:54:14'),
(32, 'dubraska', 4, 'wangi', '2025-12-04 04:52:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `telepon`, `tanggal_daftar`, `role`) VALUES
(1, 'admin', 'bayuwangy@usu.id', '$2y$10$rIk9CL6LRaZTV6CIk8.RluoQ0BYDo1gnERl7qtGNhob60GuSuNsxq', NULL, '2025-12-04 16:20:08', 'admin'),
(9, 'raymond', 'raymondsimarmata@gmail.com', '$2y$10$Y1SAnpd.Cgs.6Lx253KGqOxnJjdJ.W3ghMijUSZIaMrZjht7Bpj0y', '081362148942', '2025-12-04 09:04:12', 'customer'),
(13, 'aguy', 'uhuy@gmail.com', '$2y$10$nKgdOVZzO6AXX1A/xmKxmus18PUkeaTK98b62JBGkWvSOLbALkAhK', 'qwert123', '2025-12-05 08:14:29', 'customer'),
(14, 'felix', 'felix@gmail.com', '$2y$10$NdgP5vQBiUsTYCYQ29i3YeO1ENAsFjGoLqotjL.s.hWHSWuTQWLcG', '0987654321', '2025-12-05 08:33:07', 'customer'),
(15, 'Azriyad', 'pororo@gmail.com', '$2y$10$.bk6sYr3Ix3kn5TcXW9ObeJBLQwNaWiqgx0XaOJ0z9mmMDVRVt4MO', '081212121212', '2025-12-05 09:57:33', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`),
  ADD KEY `fk_alamat_pengiriman_user` (`id_user`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `item_keranjang`
--
ALTER TABLE `item_keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `fk_item_user` (`id_user`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `fk_pesanan_user` (`id_user`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id_komen`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `item_keranjang`
--
ALTER TABLE `item_keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id_komen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD CONSTRAINT `fk_alamat_pengiriman_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `item_keranjang`
--
ALTER TABLE `item_keranjang`
  ADD CONSTRAINT `fk_item_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_keranjang_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
