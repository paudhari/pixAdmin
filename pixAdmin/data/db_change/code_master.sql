-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2016 at 05:17 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.3

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
-- Table structure for table `code_master`
--

CREATE TABLE IF NOT EXISTS `code_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'hold code master primary id',
  `name` varchar(50) NOT NULL COMMENT 'hold code master name',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for active, 1 for blocked and 2 for deleted',
  `created_by` bigint(20) DEFAULT NULL COMMENT 'hold ceator id',
  `created_on` datetime DEFAULT NULL COMMENT 'hold created dte',
  `updated_by` bigint(20) DEFAULT NULL COMMENT 'hold updator id',
  `updated_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'hold updated date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
