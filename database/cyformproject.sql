-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 03:54 PM
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
-- Database: `cyformproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin1', 'admin1@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `orderdate` date NOT NULL,
  `custname` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `orderid`, `item`, `price`, `quantity`, `orderdate`, `custname`, `status`) VALUES
(0, 'RBNL40', '', 33.27, 1, '2025-03-20', 'ali', ''),
(0, '95RE60', 'Cyfacemasx 3D Print', 33.27, 1, '2025-03-20', 'ali', ''),
(0, 'LCY160', 'Mask', 34.50, 1, '2025-03-20', 'ali', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `picture` blob NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `quantity`, `price`, `picture`, `status`) VALUES
(4, 'Mask', '3D Mask with Protection', 30, 34.5, 0x38393963666330376565663038613133663738343030643739633662356262312e6a706567, 'available'),
(5, 'Cyfacemasx 3D Print', '100% Handmade', 10, 33.27, 0x37323737666330303862616134376630653630313433366136633239383863352e6a706567, 'available'),
(6, 'Green Transparent Cyfacemasx 3D ', 'This face mask serves for general and fashion use,not intended for medical application or protection against viruses.', 40, 38, 0x73672d31313133343230312d32323132302d6a7235646273633378376b7637652e6a706567, 'available'),
(7, 'CYFORM FACE MASK BUCKLE STRAP', 'BUCKLE STRAP FOR HEADLOOP. SUITABLE FOR CFX01, CFX02 AND CFX03 MODEL.  ', 60, 15, 0x53637265656e73686f7420323032352d30332d3136203030323932302e706e67, 'available'),
(8, 'Top Nose SparePart Cfx02', 'Alat Ganti untuk bahagian Hidung Cfx02.', 20, 7, 0x53637265656e73686f7420323032352d30332d3136203030333130302e706e67, 'available'),
(9, 'Cap', 'Urban Style Cap', 23, 34.8, 0x6361702e6a706567, 'available'),
(10, 'Cap 2', 'Style Cap', 0, 23, 0x6361702e6a706567, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nophone` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` int(11) NOT NULL COMMENT 'Customer = 1 , Admin = 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `nophone`, `address`, `role`) VALUES
(1, 'ali', 'ali@gmail.com', '$2y$10$Q788u/5CF8x05Y539CWg4OCA/uuRS5HjRYWWwbEDnALx.pMys0.Mm', '0156774352', 'no 34,jalan maju jaya', 1),
(2, 'ahmad', 'ahmad@gmail.com', '$2y$10$Me/TRhXg33gkmW4XBiPXhuakpnXrwugDli4qQL2zKYm65PF0Z1mAK', '0198763456', 'no 54,jalan maju jaya', 1),
(4, 'admin1', 'admin@gmail.com', '$2y$10$nqskZie31HfAG1GmLiGSquVIGzPEIkRL0FkjUjYtUVoAamORZR5Pi', '0125436785', 'Cyform', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
