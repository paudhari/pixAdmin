-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2016 at 11:59 AM
-- Server version: 5.6.25-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `steelmetal_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_modules`
--

CREATE TABLE IF NOT EXISTS `master_modules` (
`id` int(11) NOT NULL,
  `module_name` varchar(100) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 - Active, 1 - Inactive, 2 - Delete',
  `created_by` int(11) DEFAULT NULL,
  `created_on` varchar(255) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_modules`
--

INSERT INTO `master_modules` (`id`, `module_name`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'Auction', 0, 1, '0', NULL, NULL),
(2, 'Auction lots', 0, 0, '0', NULL, NULL),
(3, 'Templates', 0, 0, '0', NULL, NULL),
(4, 'Category', 0, 0, '0', NULL, NULL),
(5, 'News', 0, 0, '0', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_modules`
--
ALTER TABLE `master_modules`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_modules`
--
ALTER TABLE `master_modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
