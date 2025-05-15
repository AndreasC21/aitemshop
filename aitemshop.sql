-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2025 at 04:08 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aitemshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `price` int NOT NULL,
  `img` varchar(256) NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `img`, `stock`) VALUES
(10, 'Moondrop Moca', 799000, '67e53dc41ec33.png', 20),
(11, 'Tanchjim Mino Asano Tanch', 799000, '67e53e0266515.jpg', 17),
(12, 'Moondrop Physce', 35000000, '67e53e727b3a1.jpg', 23),
(13, 'Tanchjim Bunny', 319000, '67e53eda68abe.png', 3),
(14, 'HZSound Heart Mirror Zero', 499000, '67e53f0c669db.jpg', 3),
(15, 'Moondrop Robin', 2999000, '67e53f3e5bb85.jpg', 2),
(16, 'Vido', 30000, '67e53f8389f95.jpg', 1232),
(17, 'FiiO JA11', 230000, '67e53fb07c7aa.jpg', 123),
(18, 'Sony WH-1000XM5', 4299000, '67e54005b5760.jpg', 21),
(19, 'Tanchjim Origin', 3899000, '67e5403734e0a.png', 3),
(37, 'Moondrop ILLUSTRIOUS', 15570000, '68122b9fc304f.png', 2),
(44, 'FiiO BTR15', 1900000, '68122fbe0e323.png', 20);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'kitakita', '$2y$10$jRfD6lyzZexpDtjm08jvcubXD3ZgzY5k8gja8tudg4YcXFWCO0pjq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
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
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
