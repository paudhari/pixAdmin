-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2016 at 04:32 PM
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
-- Table structure for table `product_inventory`
--

CREATE TABLE IF NOT EXISTS `product_inventory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `rpc_id` bigint(20) DEFAULT NULL,
  `rpc_stock` varchar(100) NOT NULL DEFAULT '0',
  `puc_id` bigint(20) DEFAULT NULL,
  `puc_stock` varchar(100) NOT NULL DEFAULT '0',
  `total_stock` varchar(100) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
