-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2016 at 04:07 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codeigniter_register_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `name`, `contact`) VALUES
(2, 'admin1092', '57bdbe13e63bcc19f4ce9a125e057bc78c6de1ed4d8b12945035a5be85a2f047', '$2y$10$0bWjwI3nyCgaWRPqXkmmEuiINSu6ygVVFky2SQCrLJwVTnxHTY6si', 'John Doe', '9876787689'),
(3, 'john92', '94cbcd59260ce0ca0080acc24b6b7007c62453269df782d2b993c9c06b3014f7', '$2y$10$sbfH34Sqa201MPy/idcHN.KgifTmv3DthCmSlAHice3JU./SnH1X.', 'John Doe', '19834523'),
(4, 'admin', '628636220b7f6a5ea815b5c0bf86dcd93f29f63c3e6226f5230cba307ee8c75f', '$2y$10$0tVMg2ZWuYiyEnjVe1ofy.tykUouAfwK2AD8UhmZAXlcgziOxb5Qa', 'John Doe', '12');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
