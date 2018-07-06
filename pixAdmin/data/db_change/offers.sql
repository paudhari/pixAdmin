-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2016 at 11:20 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ezo`
--

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `from_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type_id` bigint(20) NOT NULL,
  `value` float NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `apply_to` bigint(20) NOT NULL,
  `description` longtext NOT NULL,
  `tnc` tinyint(1) NOT NULL,
  `tnc_description` longtext,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `from_id`, `name`, `type_id`, `value`, `start_date`, `end_date`, `apply_to`, `description`, `tnc`, `tnc_description`, `status`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
(1, 14, 'asfasda', 16, 32, '2016-04-19 00:00:00', '2016-04-25 00:00:00', 18, 'wefwew', 1, 'qweqw', 0, '2016-04-01 18:55:30', 1, '2016-04-01 13:25:30', 1),
(2, 14, 'NewPay', 16, 15, '2016-04-07 00:00:00', '2016-04-13 00:00:00', 19, 'fdngjkdf', 1, 'kjfdgkkdlflkds', 0, '2016-04-01 22:47:29', 1, '2016-04-01 17:17:29', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
