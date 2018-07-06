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
-- Table structure for table `code_master_values`
--

CREATE TABLE IF NOT EXISTS `code_master_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'hold primary key of code master values table id',
  `code_master_id` int(11) DEFAULT NULL COMMENT 'hold code master id reference id',
  `name` varchar(100) DEFAULT NULL COMMENT 'hold code master values',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'hold status values, 0 is for active, 1 is for blocked and 2 is for deleted',
  `created_on` datetime NOT NULL COMMENT 'hold created date',
  `created_by` bigint(20) NOT NULL COMMENT 'hold created by id',
  `updated_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'hold updated date',
  `updated_by` bigint(20) DEFAULT NULL COMMENT 'hold updator id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
