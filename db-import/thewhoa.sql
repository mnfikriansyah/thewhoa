-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 21, 2022 at 07:14 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thewhoa`
--

-- --------------------------------------------------------

--
-- Table structure for table `antiqueitem`
--

CREATE TABLE `antiqueitem` (
  `item_id` varchar(255) NOT NULL,
  `itemdesc` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `startprice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `antiqueitem`
--

INSERT INTO `antiqueitem` (`item_id`, `itemdesc`, `category`, `startprice`) VALUES
('santiq070', 'Tudung Saji', 'Barang Harian', 5500),
('santiq100', 'Seterika Lama Berpuaka', 'Pra-sejarah', 1950),
('santiq101', 'Syiling Lama', 'Matawang', 500),
('santiq200', 'Pot Tembikar Asli', 'Pengubatan Tradisi', 1500),
('santiq909', 'Keris Luk Tujuh', 'Senjata Tradisional', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `biditem`
--

CREATE TABLE `biditem` (
  `bidder_id` varchar(255) NOT NULL,
  `biddername` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `bidprice` double NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `itemdesc` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `startprice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antiqueitem`
--
ALTER TABLE `antiqueitem`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `biditem`
--
ALTER TABLE `biditem`
  ADD PRIMARY KEY (`bidder_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
