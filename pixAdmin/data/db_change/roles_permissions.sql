-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2016 at 10:53 AM
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
-- Table structure for table `roles_permissions`
--

CREATE TABLE IF NOT EXISTS `roles_permissions` (
`id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `add_permission` int(1) DEFAULT NULL COMMENT '0 - Yes, 1 - No',
  `edit_permission` int(1) DEFAULT NULL COMMENT '0 - Yes, 1 - No',
  `delete_permission` int(1) DEFAULT NULL COMMENT '0 - Yes, 1 - No',
  `view_permission` int(1) DEFAULT NULL COMMENT '0 - Yes, 1 - No',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 - Active, 1 - Inactive, 2 - Delete',
  `created_by` int(11) DEFAULT NULL,
  `created_on` varchar(255) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
