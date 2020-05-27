-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2020 at 07:26 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectacc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `img` varchar(20) NOT NULL,
  `date_created` int(11) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `email`, `password`, `nama`, `img`, `date_created`, `role`) VALUES
(1, 'admin@gmail.com', '$2y$10$SSHw6UsIE/0beO.8qiadeu9iemsiHvs/UJDiOl7SxWxuFjRtobuE.', 'admin', '5cf81d0a80bc4.png', 1559762571, 'admin'),
(3, 'staff@gmail.com', '$2y$10$YEq/yKQPj3q5FFG/6pvFJOK1K1eh0teo70MpvT2towH6k0Ry0Hs7K', 'staff baru', '5ecd454e55943.jpg', 1590510319, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_cust` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_cust`, `nama`, `no_telp`, `alamat`) VALUES
(5, 'user', '08123456789', 'test'),
(6, 'user2', '081234567891', 'Jakarta'),
(7, 'user3', '081234567891', 'Madura'),
(8, 'user baru', '081908311520', 'testing user');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumbel` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_jual` double NOT NULL,
  `sub_total` double NOT NULL,
  `diskon` double DEFAULT NULL,
  `ongkir` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail`, `id_penjualan`, `id_produk`, `jumbel`, `nama_produk`, `harga_jual`, `sub_total`, `diskon`, `ongkir`) VALUES
(12, 15, 2, 1, 'test', 20000, 20000, 0, 1000),
(13, 16, 3, 1, 'test2', 15000, 15000, 0, 1000),
(14, 17, 4, 1, 'test3', 0, 0, 0, 1000),
(15, 18, 2, 17, 'test', 20000, 340000, 6800, 1000),
(16, 19, 6, 15, 'test4', 30000, 450000, 9000, 1000),
(17, 20, 6, 0, 'test4', 30000, 0, 0, 0),
(18, 21, 6, 0, 'test4', 30000, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detail_retur`
--

CREATE TABLE `detail_retur` (
  `id_detail` int(11) NOT NULL,
  `id_retur` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumbel` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_jual` double NOT NULL,
  `sub_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_retur`
--

INSERT INTO `detail_retur` (`id_detail`, `id_retur`, `id_produk`, `jumbel`, `nama_produk`, `harga_jual`, `sub_total`) VALUES
(1, 1, 2, 1, 'test', 20000, 0),
(2, 2, 3, 1, 'test2', 15000, 15000),
(3, 3, 2, 2, 'test', 20000, 40000),
(4, 4, 6, 1, 'test4', 30000, 30000),
(6, 6, 4, 4, 'test3', 26000, 104000),
(7, 7, 4, 4, 'test3', 26000, 104000),
(9, 9, 0, 0, '', 0, 0),
(10, 10, 0, 0, '', 0, 0),
(11, 11, 2, 1, 'test', 20000, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_cust` int(11) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `total_penjualan` double NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_cust`, `tgl_penjualan`, `total_penjualan`, `status`) VALUES
(15, 5, '2020-04-26', 21000, ''),
(16, 5, '2020-04-15', 16000, ''),
(17, 6, '2020-05-10', 0, 'Penjualan'),
(18, 5, '2020-05-10', 334200, 'Penjualan'),
(19, 7, '2020-05-11', 442000, 'Penjualan'),
(20, 6, '2020-05-11', 0, 'Penjualan'),
(21, 6, '2020-05-11', 0, 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_pokok` double NOT NULL,
  `harga_jual` double NOT NULL,
  `stok` int(5) NOT NULL,
  `keterangan` text NOT NULL,
  `gambar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_pokok`, `harga_jual`, `stok`, `keterangan`, `gambar`) VALUES
(2, 'test', 10000, 20000, 15, 'test produk 1', '5ecd471500c14.png'),
(3, 'test2', 10000, 15000, 19, 'test', '5ea5649682f6f.png'),
(4, 'test3', 25000, 26000, 21, 'test3', '5eb825b3d53b3.png'),
(6, 'test4', 25000, 30000, 0, 'test4', '5eb8354d64a5a.png'),
(7, 'testing produk baru', 50000, 100000, 10, 'tes', '5ec7df704e6b6.png');

-- --------------------------------------------------------

--
-- Table structure for table `retur_penjualan`
--

CREATE TABLE `retur_penjualan` (
  `id_retur` int(11) NOT NULL,
  `id_cust` int(11) NOT NULL,
  `tanggal_retur` date NOT NULL,
  `total` double NOT NULL,
  `status` varchar(20) NOT NULL,
  `jenis_retur` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retur_penjualan`
--

INSERT INTO `retur_penjualan` (`id_retur`, `id_cust`, `tanggal_retur`, `total`, `status`, `jenis_retur`) VALUES
(1, 5, '2020-05-01', 20000, 'Retur', ''),
(2, 5, '2020-05-02', 15000, 'Retur', ''),
(3, 5, '2020-05-02', 40000, 'Retur', ''),
(4, 7, '2020-05-11', 30000, 'Retur', ''),
(6, 5, '2020-05-17', 104000, 'Retur', ''),
(7, 5, '2020-05-17', 104000, 'Retur', ''),
(9, 0, '0000-00-00', 0, 'Retur', ''),
(10, 0, '0000-00-00', 0, 'Retur', ''),
(11, 5, '2020-05-26', 20000, 'Lunas Retur', 'Barang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_cust`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `detail_retur`
--
ALTER TABLE `detail_retur`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_retur` (`id_retur`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_cust` (`id_cust`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `retur_penjualan`
--
ALTER TABLE `retur_penjualan`
  ADD PRIMARY KEY (`id_retur`),
  ADD KEY `id_cust` (`id_cust`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_cust` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `detail_retur`
--
ALTER TABLE `detail_retur`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `retur_penjualan`
--
ALTER TABLE `retur_penjualan`
  MODIFY `id_retur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
