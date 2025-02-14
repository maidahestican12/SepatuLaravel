-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jan 2025 pada 13.12
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
-- Database: `sepatularavel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(11) NOT NULL,
  `namakategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`, `created_at`, `updated_at`) VALUES
(20, 'Kategori 1', '2024-10-02 02:49:32', '2024-10-02 08:51:45'),
(21, 'Kategori 2', '2024-10-02 08:17:18', '2024-10-02 08:51:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `idpembayaran` int(11) NOT NULL,
  `idpembelian` int(11) NOT NULL,
  `nama` text NOT NULL,
  `tanggaltransfer` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `bukti` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`idpembayaran`, `idpembelian`, `nama`, `tanggaltransfer`, `tanggal`, `bukti`) VALUES
(10, 19, 'Fahrul Adib', '2024-10-02', '2024-10-02 00:00:00', '20241002100217WhatsApp Image 2024-09-04 at 13.34.19.jpeg'),
(11, 22, 'Fahrul Adib', '2024-10-02', '2024-10-02 00:00:00', '20241002105830WhatsApp Image 2024-08-28 at 15.17.30.jpeg'),
(12, 23, 'Fahrul Adib', '2024-10-02', '2024-10-02 00:00:00', '20241002153009Snapshot_12.png'),
(13, 24, 'Fahrul Adib', '2024-10-02', '2024-10-02 00:00:00', '20241002153515pngwing.com (2).png'),
(14, 25, 'Fahrul Adib', '2024-10-02', '2024-10-02 00:00:00', '20241002160125pngwing.com (3).png'),
(15, 27, 'Fahrul Adib', '2024-10-24', '2024-10-24 00:00:00', '20241024085206aston-cengkareng (1).jpg'),
(16, 28, 'Fahrul Adib', '2024-10-24', '2024-10-24 00:00:00', '20241024173242aston-cengkareng (1).jpg'),
(17, 29, 'Fahrul Adib', '2024-10-24', '2024-10-24 00:00:00', '20241024173707carbon (3).png'),
(18, 32, 'Fahrul Adib', '2024-11-28', '2024-11-28 00:00:00', '20241128133404WhatsApp Image 2024-11-11 at 06.50.45.jpeg'),
(19, 33, 'Fahrul Adib', '2024-11-28', '2024-11-28 00:00:00', '20241128165253Bank-Sumsel-Babel.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `idpembelian` int(11) NOT NULL,
  `notransaksi` text NOT NULL,
  `id` int(11) NOT NULL,
  `tanggalbeli` date NOT NULL,
  `ongkir` varchar(250) NOT NULL DEFAULT '0',
  `totalbeli` text NOT NULL,
  `alamat` text NOT NULL,
  `statusbeli` text NOT NULL,
  `waktu` datetime NOT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `kota` varchar(255) DEFAULT NULL,
  `kec` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(100) DEFAULT NULL,
  `nama` varchar(250) NOT NULL,
  `email` varchar(500) NOT NULL,
  `telepon` varchar(250) NOT NULL,
  `metodepembayaran` varchar(250) NOT NULL,
  `catatan` text NOT NULL,
  `idkurir` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`idpembelian`, `notransaksi`, `id`, `tanggalbeli`, `ongkir`, `totalbeli`, `alamat`, `statusbeli`, `waktu`, `provinsi`, `kota`, `kec`, `kode_pos`, `nama`, `email`, `telepon`, `metodepembayaran`, `catatan`, `idkurir`) VALUES
(32, '#TP20241128013219', 1, '2024-11-28', '0', '50000', 'Jl. Prapanca Raya No. 9', 'Pesanan Di Terima', '2024-11-28 13:32:19', 'DKI Jakarta', 'Jakarta Selatan', 'Ciganjur', '12170', 'Fahrul Adib', 'fahruladib9@gmail.com', '082282076702', 'Transfer', 'diterima', 7),
(33, '#TP20241128045226', 1, '2024-11-28', '0', '50000', 'Jl. Prapanca Raya No. 9', 'Pesanan Di Terima', '2024-11-28 16:52:26', 'DKI Jakarta', 'Jakarta Selatan', 'Ciganjur', '12170', 'Fahrul Adib', 'fahruladib9@gmail.com', '082282076702', 'Transfer', 'Pesanan di terima sama pembeli', 7),
(34, '#TP20241130083335', 1, '2024-11-30', '29000', '79000', 'Jl. Prapanca Raya No. 9', 'Menunggu Konfirmasi', '2024-11-30 08:33:35', NULL, NULL, NULL, NULL, 'Fahrul Adib', 'fahruladib9@gmail.com', '082282076702', 'Cod', '', NULL),
(35, '#TP20241205021216', 8, '2024-12-05', '50000', '100000', 'asd', 'Belum Bayar', '2024-12-05 14:12:16', '', '', NULL, NULL, 'Sugeng', 'sugeng@gmail.com', '018232132', 'Transfer', '', NULL),
(36, '#TP20250123024658', 8, '2025-01-23', '22000', '72000', 'ASD', 'Belum Bayar', '2025-01-23 14:46:51', '', '', NULL, NULL, 'Sugeng', 'sugeng@gmail.com', '018232132', 'Transfer', '', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelianproduk`
--

CREATE TABLE `pembelianproduk` (
  `idpembelianproduk` int(11) NOT NULL,
  `idpembelian` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `nama` text NOT NULL,
  `harga` text NOT NULL,
  `subharga` text NOT NULL,
  `jumlah` text NOT NULL,
  `fotocustom` text DEFAULT NULL,
  `warna` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembelianproduk`
--

INSERT INTO `pembelianproduk` (`idpembelianproduk`, `idpembelian`, `idproduk`, `nama`, `harga`, `subharga`, `jumlah`, `fotocustom`, `warna`) VALUES
(32, 32, 58, 'Produk 1', '50000', '50000', '1', '1732775335.png', 'Hitam'),
(33, 33, 58, 'Produk 1', '50000', '50000', '1', '1732787523.jpg', 'Hitam'),
(34, 34, 58, 'Produk 1', '50000', '50000', '1', '1732926911.JPG', 'Hitam'),
(35, 35, 58, 'Produk 1', '50000', '50000', '1', '', 'asd'),
(36, 36, 58, 'Produk 1', '50000', '50000', '1', '', 'ASD');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_foto`
--

CREATE TABLE `pembelian_foto` (
  `id_pembelian_foto` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `status` text NOT NULL,
  `foto` text NOT NULL,
  `fotobuktiditerima` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembelian_foto`
--

INSERT INTO `pembelian_foto` (`id_pembelian_foto`, `id_pembelian`, `status`, `foto`, `fotobuktiditerima`) VALUES
(10, 32, 'Pesanan Sedang Dikirim', '20241128013519-Bank-Sumsel-Babel.jpg', NULL),
(11, 32, 'Pesanan Di Terima', '20241128013631-Capture.JPG', NULL),
(12, 33, 'Pesanan Sedang Dikirim', '20241128045406-Capture.JPG', NULL),
(13, 33, 'Pesanan Di Terima', '20241128045550-WhatsApp Image 2024-11-11 at 08.59.07.jpeg', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `telepon` text NOT NULL,
  `alamat` text DEFAULT NULL,
  `fotoprofil` text NOT NULL,
  `level` text NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `jekel` varchar(100) DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `kota` varchar(255) DEFAULT NULL,
  `kec` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `password`, `telepon`, `alamat`, `fotoprofil`, `level`, `tgl_lahir`, `tempat_lahir`, `jekel`, `provinsi`, `kota`, `kec`, `kode_pos`) VALUES
(1, 'Fahrul Adib', 'fahruladib9@gmail.com', '123', '082282076702', 'Jl. Prapanca Raya No. 9', 'Untitled.png', 'Pelanggan', '2002-07-08', 'Jakarta', 'Laki-laki', 'DKI Jakarta', 'Jakarta Selatan', 'Ciganjur', '12170'),
(2, 'Administrator', 'admin@gmail.com', 'admin', '081293827383', 'Palembang', '', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Sudendev', 'sudendev@gmail.com', '123', '082673927483', 'Banyuasin', 'Untitled.png', 'Pelanggan', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Feby Saputra Kusumo Widyadiningrat', 'feby@gmail.com', 'feby', '08398749284', NULL, 'Untitled.png', 'Pelanggan', '2024-07-29', NULL, 'Laki-laki', NULL, NULL, NULL, NULL),
(6, 'Hijriadi Muharom Kusumo', 'hijri@gmail.com', 'hijri', '188929129192', 'Kenten', 'Untitled.png', 'Pelanggan', '2024-07-29', 'Musi banyuasin', 'Laki-laki', 'Sumatera Selatan', 'Banyuasin', 'Kenten', '12341'),
(7, 'Kirito', 'kirito@gmail.com', '123', '188929129192', 'asds', '1729735902.jpg', 'Kurir', '2024-10-24', 'Muba', 'Laki-laki', NULL, NULL, NULL, NULL),
(8, 'Sugeng', 'sugeng@gmail.com', 'sugeng', '018232132', NULL, 'Untitled.png', 'Pelanggan', '2024-12-02', 'jakarta', 'Perempuan', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `idkategori` int(11) NOT NULL,
  `nama` text NOT NULL,
  `harga` text NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` text NOT NULL,
  `stok` varchar(250) NOT NULL DEFAULT '0',
  `tanggal` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`idproduk`, `idkategori`, `nama`, `harga`, `deskripsi`, `foto`, `stok`, `tanggal`) VALUES
(57, 20, 'Produk 2', '20000', '<p>asdd</p>', 'peakpx.jpg', '6', '2024-10-02'),
(58, 21, 'Produk 1', '50000', '<p>asdds</p>', 'Capture.JPG', '3', '2024-10-02');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`idpembayaran`),
  ADD KEY `idpembelian` (`idpembelian`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`idpembelian`),
  ADD KEY `id` (`id`);

--
-- Indeks untuk tabel `pembelianproduk`
--
ALTER TABLE `pembelianproduk`
  ADD PRIMARY KEY (`idpembelianproduk`) USING BTREE,
  ADD KEY `idpembelian` (`idpembelian`,`idproduk`) USING BTREE,
  ADD KEY `idproduk` (`idproduk`) USING BTREE;

--
-- Indeks untuk tabel `pembelian_foto`
--
ALTER TABLE `pembelian_foto`
  ADD PRIMARY KEY (`id_pembelian_foto`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`) USING BTREE,
  ADD KEY `idkategori` (`idkategori`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `idpembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `idpembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `pembelianproduk`
--
ALTER TABLE `pembelianproduk`
  MODIFY `idpembelianproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `pembelian_foto`
--
ALTER TABLE `pembelian_foto`
  MODIFY `id_pembelian_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
