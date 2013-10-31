-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2013 at 09:34 AM
-- Server version: 5.5.34-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `softwerkCoffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actionname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `actionname`) VALUES
(1, 'toggleCoffee'),
(2, 'ToggleLoad'),
(3, 'UntoggleCoffee');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `action_id`, `date_time`) VALUES
(1, 1, 1, '2013-10-25 12:28:11'),
(2, 2, 2, '2013-10-31 08:09:54'),
(3, 2, 1, '2013-10-31 08:52:59'),
(4, 1, 2, '2013-10-31 08:52:59'),
(7, 1, 2, '2013-10-31 09:14:35'),
(8, 2, 3, '2013-10-31 09:14:59'),
(9, 2, 1, '2013-10-31 09:19:51'),
(10, 2, 1, '2013-10-31 09:19:52'),
(11, 2, 1, '2013-10-31 09:20:02'),
(14, 2, 3, '2013-10-31 09:20:58'),
(15, 2, 2, '2013-10-31 09:31:52'),
(16, 2, 2, '2013-10-31 09:32:03'),
(17, 2, 1, '2013-10-31 09:32:20'),
(18, 2, 1, '2013-10-31 09:32:28'),
(19, 2, 3, '2013-10-31 09:32:29'),
(20, 2, 3, '2013-10-31 09:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'user', '34c1d5a41b77e2b42ddb3f351ac6fbee0ad74d4ac523ea05695aaf87b220bbf0'),
(2, 'user2', '34c1d5a41b77e2b42ddb3f351ac6fbee0ad74d4ac523ea05695aaf87b220bbf0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
