-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 15, 2015 at 12:44 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appota_game_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `game_package`
--

CREATE TABLE IF NOT EXISTS `game_package` (
  `game_package_id` varchar(40) NOT NULL COMMENT 'Unique ID for the game payment package. Should be configured on developer.appota.com also',
  `game_package_type` varchar(40) NOT NULL COMMENT 'Game package type (gold, diamond, vip or any valuable asset in game)',
  `game_package_value` int(11) NOT NULL COMMENT 'Number of valuable asset for the package (50 gold or 100 diamond)',
  `pacakge_money_value_vnd` varchar(20) NOT NULL COMMENT 'Package value by money (VND)',
  `package_money_value_usd` varchar(20) NOT NULL COMMENT 'Package value by money (USD)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game_user`
--

CREATE TABLE IF NOT EXISTS `game_user` (
  `game_user_name` varchar(200) NOT NULL,
  `appota_user_name` varchar(200) NOT NULL,
  `appota_user_id` varchar(40) NOT NULL,
  `level` int(11) NOT NULL,
  `server_id` varchar(40) NOT NULL,
  `gold` int(11) NOT NULL,
  `diamond` int(11) NOT NULL,
  `is_vip` tinyint(1) NOT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game_user`
--

INSERT INTO `game_user` (`game_user_name`, `appota_user_name`, `appota_user_id`, `level`, `server_id`, `gold`, `diamond`, `is_vip`, `id`) VALUES
('g1', 'ga1', '1', 0, 'sv1', 0, 0, 0, 2),
('game_user_2', 'ga2', '2', 0, '1', 0, 0, 0, 4),
('game_user_3', 'ga3', '3', 0, '1', 0, 0, 0, 6),
('game_user_4', 'ga4', '4', 0, 'sv1', 0, 0, 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE IF NOT EXISTS `server` (
  `server_name` varchar(200) NOT NULL,
  `server_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `server`
--

INSERT INTO `server` (`server_name`, `server_id`) VALUES
('Huyen Vu', 'sv1'),
('Chu Tuoc', 'sv2');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `appota_transaction_id` varchar(40) NOT NULL,
  `game_package_id` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game_user`
--
ALTER TABLE `game_user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `game_user_name` (`game_user_name`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
 ADD PRIMARY KEY (`server_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game_user`
--
ALTER TABLE `game_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
