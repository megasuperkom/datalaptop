-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 03:53 AM
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
-- Database: `toko_laptop`
--

-- --------------------------------------------------------

--
-- Table structure for table `stok_laptop`
--

CREATE TABLE `stok_laptop` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `seri` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_laptop`
--

INSERT INTO `stok_laptop` (`id`, `brand`, `seri`, `model`, `stok`) VALUES
(1, 'Asus', 'ROG Zephyrus', 'G14', 4),
(2, 'Lenovo', 'Legion', 'Pro 5', 1),
(3, 'Apple', 'MacBook Air', 'M2', 3),
(4, 'HP', 'Victus', '15', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stok_laptop`
--
ALTER TABLE `stok_laptop`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_LAPTOP` (`brand`,`seri`,`model`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stok_laptop`
--
ALTER TABLE `stok_laptop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
