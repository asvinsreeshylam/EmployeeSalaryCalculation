-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2022 at 05:41 AM
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
-- Database: `smreader_employee`
--

-- --------------------------------------------------------

--
-- Table structure for table `bandsalary`
--

CREATE TABLE `bandsalary` (
  `id` int(10) NOT NULL,
  `Name` varchar(10) DEFAULT '',
  `Salary` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bandsalary`
--

INSERT INTO `bandsalary` (`id`, `Name`, `Salary`) VALUES
(1, 'A', '12000.00'),
(2, 'B', '26000.00'),
(3, 'C', '40000.00');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(10) NOT NULL,
  `Name` varchar(255) DEFAULT '',
  `Age` int(10) NOT NULL DEFAULT 0,
  `Band` int(10) NOT NULL DEFAULT 0,
  `Rating` int(10) NOT NULL DEFAULT 0,
  `ManagedBy` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `Name`, `Age`, `Band`, `Rating`, `ManagedBy`) VALUES
(1, 'naveen', 33, 3, 4, 0),
(2, 'Asvin', 30, 1, 4, 1),
(3, 'Vipin', 30, 1, 1, 2),
(4, 'VipinT', 30, 2, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bandsalary`
--
ALTER TABLE `bandsalary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bandsalary`
--
ALTER TABLE `bandsalary`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
