-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2019 at 04:15 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paytrik`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblogin`
--

CREATE TABLE `tblogin` (
  `kodeLogin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `namaLengkap` varchar(50) NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblogin`
--

INSERT INTO `tblogin` (`kodeLogin`, `username`, `password`, `namaLengkap`, `level`) VALUES
(1, 'admin', 'admin', 'Admin', 'Admin'),
(15, '1', '1', 'Pelanggan', 'Pelanggan'),
(20, 'petugas', 'petugas', 'Petugas', 'Pelanggan');

-- --------------------------------------------------------

--
-- Table structure for table `tbpelanggan`
--

CREATE TABLE `tbpelanggan` (
  `kodePelanggan` int(11) NOT NULL,
  `noPelanggan` varchar(50) NOT NULL,
  `noMeter` varchar(50) NOT NULL,
  `kodeTarif` int(11) NOT NULL,
  `namaLengkap` varchar(50) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpelanggan`
--

INSERT INTO `tbpelanggan` (`kodePelanggan`, `noPelanggan`, `noMeter`, `kodeTarif`, `namaLengkap`, `telp`, `alamat`) VALUES
(7, '1', 'PJYN1', 3, 'Pelanggan', '081999123456', 'Denpasar');

-- --------------------------------------------------------

--
-- Table structure for table `tbpembayaran`
--

CREATE TABLE `tbpembayaran` (
  `kodePembayaran` int(11) NOT NULL,
  `kodeTagihan` int(11) NOT NULL,
  `tglBayar` date NOT NULL,
  `jumlahTagihan` double(10,0) NOT NULL,
  `buktiPembayaran` varchar(50) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpembayaran`
--

INSERT INTO `tbpembayaran` (`kodePembayaran`, `kodeTagihan`, `tglBayar`, `jumlahTagihan`, `buktiPembayaran`, `status`) VALUES
(3, 25, '2019-02-14', 9, '1550132940.jpg', 'Lunas'),
(4, 26, '2019-02-22', 50000, '1553221059.jpg', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `tbtagihan`
--

CREATE TABLE `tbtagihan` (
  `kodeTagihan` int(11) NOT NULL,
  `noTagihan` varchar(50) NOT NULL,
  `noPelanggan` varchar(50) NOT NULL,
  `tahunTagih` varchar(50) NOT NULL,
  `bulanTagih` varchar(50) NOT NULL,
  `jumlahPemakaian` double(10,0) NOT NULL,
  `totalBayar` double(10,0) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbtagihan`
--

INSERT INTO `tbtagihan` (`kodeTagihan`, `noTagihan`, `noPelanggan`, `tahunTagih`, `bulanTagih`, `jumlahPemakaian`, `totalBayar`, `status`) VALUES
(25, '9RGDN5', '1', '2019', 'Januari', 100, 260000, 'Lunas'),
(26, 'J4UT6F', '1', '2019', 'Februari', 50, 137500, 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `tbtarif`
--

CREATE TABLE `tbtarif` (
  `kodeTarif` int(11) NOT NULL,
  `daya` varchar(50) NOT NULL,
  `tarifPerKwh` double(10,0) NOT NULL,
  `beban` double(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbtarif`
--

INSERT INTO `tbtarif` (`kodeTarif`, `daya`, `tarifPerKwh`, `beban`) VALUES
(3, '500', 2500, 12500),
(5, '1000', 5000, 25000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblogin`
--
ALTER TABLE `tblogin`
  ADD PRIMARY KEY (`kodeLogin`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `tbpelanggan`
--
ALTER TABLE `tbpelanggan`
  ADD PRIMARY KEY (`kodePelanggan`),
  ADD KEY `kodeTarif` (`kodeTarif`),
  ADD KEY `noPelanggan` (`noPelanggan`);

--
-- Indexes for table `tbpembayaran`
--
ALTER TABLE `tbpembayaran`
  ADD PRIMARY KEY (`kodePembayaran`),
  ADD KEY `kodeTagihan` (`kodeTagihan`);

--
-- Indexes for table `tbtagihan`
--
ALTER TABLE `tbtagihan`
  ADD PRIMARY KEY (`kodeTagihan`),
  ADD KEY `noPelanggan` (`noPelanggan`);

--
-- Indexes for table `tbtarif`
--
ALTER TABLE `tbtarif`
  ADD PRIMARY KEY (`kodeTarif`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblogin`
--
ALTER TABLE `tblogin`
  MODIFY `kodeLogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbpelanggan`
--
ALTER TABLE `tbpelanggan`
  MODIFY `kodePelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbpembayaran`
--
ALTER TABLE `tbpembayaran`
  MODIFY `kodePembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbtagihan`
--
ALTER TABLE `tbtagihan`
  MODIFY `kodeTagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbtarif`
--
ALTER TABLE `tbtarif`
  MODIFY `kodeTarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbpelanggan`
--
ALTER TABLE `tbpelanggan`
  ADD CONSTRAINT `tbpelanggan_ibfk_1` FOREIGN KEY (`kodeTarif`) REFERENCES `tbtarif` (`kodeTarif`),
  ADD CONSTRAINT `tbpelanggan_ibfk_2` FOREIGN KEY (`noPelanggan`) REFERENCES `tblogin` (`username`);

--
-- Constraints for table `tbpembayaran`
--
ALTER TABLE `tbpembayaran`
  ADD CONSTRAINT `tbpembayaran_ibfk_1` FOREIGN KEY (`kodeTagihan`) REFERENCES `tbtagihan` (`kodeTagihan`);

--
-- Constraints for table `tbtagihan`
--
ALTER TABLE `tbtagihan`
  ADD CONSTRAINT `tbtagihan_ibfk_1` FOREIGN KEY (`noPelanggan`) REFERENCES `tbpelanggan` (`noPelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
