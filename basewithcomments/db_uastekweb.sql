-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 09:52 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uastekweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `no_resi` varchar(10) NOT NULL,
  `tanggal_resi` date NOT NULL,
  `jenis_pengiriman` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`no_resi`, `tanggal_resi`, `jenis_pengiriman`) VALUES
('RS-001', '2022-12-01', 'kilat'),
('RS-002', '2022-12-07', 'cepat'),
('RS-003', '2022-12-17', 'Default'),
('RS-005', '2022-12-09', 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_detail`
--

CREATE TABLE `pengiriman_detail` (
  `no_resi` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `kota` varchar(50) NOT NULL,
  `keterangan` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengiriman_detail`
--

INSERT INTO `pengiriman_detail` (`no_resi`, `tanggal`, `kota`, `keterangan`) VALUES
('RS-001', '2022-12-16', 'Sidoarjo', 'Barang sedang di bongkar'),
('RS-001', '2022-12-17', 'Surabaya', 'Barang ternyata ada yang rusak'),
('RS-005', '2022-12-16', 'Jakarta', 'Barang sedang dimuat'),
('RS-005', '2022-12-17', 'Malang', 'Kurir telah tiba'),
('RS-002', '2022-12-24', 'Madiun', 'Barang ketinggalan di solo'),
('RS-002', '2022-12-25', 'Solo', 'Mengambil barang ketinggalan');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `nama`, `status`) VALUES
('admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', 'admin', 1),
('hai', '*1DD7419800D7CCC2F0E698834CE3522AC8E0CAED', 'hai', 1),
('hello', '*6B4F89A54E2D27ECD7E8DA05B4AB8FD9D1D8B119', 'hello', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`no_resi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
