-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2015 at 10:44 AM
-- Server version: 5.5.44-MariaDB-1ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ezo`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CALC_DIST`(lat1 decimal(15,8), long1 decimal(15,8), lat2 decimal(15,8), long2 decimal(15,8)) RETURNS decimal(18,14)
    DETERMINISTIC
BEGIN
    return (((acos(sin((lat1*pi()/180)) * sin((lat2*pi()/180))+cos((lat1*pi()/180)) * cos((lat2*pi()/180)) * cos(((long1-long2) * pi()/180))))*180/pi())*60*1.1515);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GETAGE`(`dob` DATETIME) RETURNS int(11) unsigned
    NO SQL
    DETERMINISTIC
    COMMENT 'Calculates the age from the dob column'
RETURN (floor(datediff (now(), dob)/365))$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `module_club` tinyint(4) NOT NULL DEFAULT '1',
  `module_event` tinyint(4) NOT NULL DEFAULT '1',
  `module_dj` tinyint(4) NOT NULL DEFAULT '1',
  `module_photo` tinyint(4) NOT NULL DEFAULT '1',
  `module_general_settings` tinyint(4) NOT NULL DEFAULT '1',
  `module_accounting` tinyint(4) NOT NULL DEFAULT '1',
  `module_user_management` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B63E2EC7A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rostergroups`
--

CREATE TABLE IF NOT EXISTS `rostergroups` (
  `username` varchar(250) NOT NULL,
  `jid` text NOT NULL,
  `grp` varchar(250) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rosterusers`
--

CREATE TABLE IF NOT EXISTS `rosterusers` (
  `username` varchar(250) NOT NULL,
  `jid` varchar(250) NOT NULL,
  `nick` text NOT NULL,
  `subscription` char(1) NOT NULL,
  `ask` char(1) NOT NULL,
  `askmessage` text NOT NULL,
  `server` char(1) NOT NULL,
  `subscribe` text NOT NULL,
  `type` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `device_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `modified_on` datetime NOT NULL,
  `device_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` smallint(6) NOT NULL,
  `device_type` tinyint(4) NOT NULL DEFAULT '0',
  `user_settings` longtext COLLATE utf8_unicode_ci,
  `created_on` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `modified_on` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_type`, `device_type`, `user_settings`, `created_on`, `modified_on`, `is_active`) VALUES
(1, 'bkupdhyay', '$2y$14$YWJjZGVmZ2hpamtsbW5vc.xZ4NrMQOIpBJ96/z0cVQntIXKpBlaRK', 'bk@mailinator.com', 1, 0, NULL, '1445428981', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(50) DEFAULT NULL,
  `modifyon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
