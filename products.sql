-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jul 08, 2022 at 07:30 AM
-- Server version: 5.6.51
-- PHP Version: 8.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `products`
--

-- --------------------------------------------------------

--
-- Table structure for table `Attributes`
--

CREATE TABLE `Attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Attributes`
--

INSERT INTO `Attributes` (`id`, `title`) VALUES
(1, 'size'),
(2, 'weight'),
(3, 'width'),
(4, 'height'),
(5, 'length');

-- --------------------------------------------------------

--
-- Table structure for table `ProductAttributes`
--

CREATE TABLE `ProductAttributes` (
  `product` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` int(10) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ProductAttributes`
--

INSERT INTO `ProductAttributes` (`product`, `attribute`, `value`) VALUES
('book001', 2, 10),
('book002', 2, 1),
('dvd001', 1, 700),
('dvd002', 1, 400),
('sofa001', 3, 100),
('sofa001', 4, 100),
('sofa001', 5, 50),
('sofa002', 3, 3),
('sofa002', 4, 3),
('sofa002', 5, 3),
('table001', 3, 5),
('table001', 4, 2),
('table001', 5, 5),
('table002', 3, 10),
('table002', 4, 1),
('table002', 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `sku` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `type` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`sku`, `name`, `price`, `type`) VALUES
('book001', 'Interesting book', '150.00', 3),
('book002', 'Very interesting book', '100.00', 3),
('dvd001', 'Music collection', '25.00', 1),
('dvd002', 'Audio books', '5.00', 1),
('sofa001', 'Nice sofa', '100.00', 2),
('sofa002', 'Better sofa', '150.00', 2),
('table001', 'Table', '45.00', 2),
('table002', 'Another table', '200.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `TypeAttributes`
--

CREATE TABLE `TypeAttributes` (
  `type` int(10) UNSIGNED NOT NULL,
  `attribute` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `TypeAttributes`
--

INSERT INTO `TypeAttributes` (`type`, `attribute`) VALUES
(1, 1),
(3, 2),
(2, 3),
(2, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Types`
--

CREATE TABLE `Types` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Types`
--

INSERT INTO `Types` (`id`, `title`) VALUES
(3, 'Book'),
(1, 'DVD'),
(2, 'Furniture');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Attributes`
--
ALTER TABLE `Attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ProductAttributes`
--
ALTER TABLE `ProductAttributes`
  ADD PRIMARY KEY (`product`,`attribute`),
  ADD KEY `attribute` (`attribute`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`sku`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `TypeAttributes`
--
ALTER TABLE `TypeAttributes`
  ADD PRIMARY KEY (`type`,`attribute`),
  ADD KEY `attribute` (`attribute`);

--
-- Indexes for table `Types`
--
ALTER TABLE `Types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Attributes`
--
ALTER TABLE `Attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Types`
--
ALTER TABLE `Types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ProductAttributes`
--
ALTER TABLE `ProductAttributes`
  ADD CONSTRAINT `productattributes_ibfk_1` FOREIGN KEY (`product`) REFERENCES `Products` (`sku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productattributes_ibfk_2` FOREIGN KEY (`attribute`) REFERENCES `Attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`type`) REFERENCES `Types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TypeAttributes`
--
ALTER TABLE `TypeAttributes`
  ADD CONSTRAINT `typeattributes_ibfk_1` FOREIGN KEY (`type`) REFERENCES `Types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `typeattributes_ibfk_2` FOREIGN KEY (`attribute`) REFERENCES `Attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
