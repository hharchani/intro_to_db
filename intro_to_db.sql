-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2014 at 05:44 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `intro_to_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `address` text NOT NULL,
  `contact_no` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `stock` decimal(10,3) NOT NULL DEFAULT '0.000',
  `unit` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `description`, `stock`, `unit`) VALUES
(1, 'Pears Soap', '25.00', 'Pears Soap 250g', '0.000', 'pc'),
(2, 'Pears Soap', '25.00', 'Pears Soap 250g', '0.000', 'pc'),
(3, 'Pears Soap', '25.00', 'Pears Soap 250g', '0.000', 'pc'),
(4, 'Pears Soap', '25.00', 'Pears Soap 250g', '0.000', 'pc'),
(5, 'Pears Soap', '25.00', 'Pears Soap 250g', '0.000', 'pc'),
(6, 'Lux', '10.00', 'Lux 50g Soap', '0.000', 'pc'),
(7, 'Lays', '10.00', 'Lays chips medium sized', '0.000', 'pc'),
(8, 'Pepsi', '12.00', 'Pepsi 300ml', '0.000', 'pc'),
(9, 'Panteen Shampoo pouch', '3.00', 'Panteen Shampoo pouch 8ml', '0.000', 'pc'),
(10, 'Good Day', '25.00', '', '0.000', 'pc'),
(11, 'Pepsi 500ml', '25.00', '', '0.000', 'pc'),
(12, 'Coke 500ml', '24.00', '', '0.000', 'pc'),
(13, '7up 500ml', '25.00', '', '0.000', 'pc'),
(14, 'Coke 500ml', '24.00', '', '0.000', 'pc'),
(15, '7up 500ml', '25.00', '', '0.000', 'pc'),
(16, 'Coke 500ml', '24.00', '', '0.000', 'pc'),
(17, '7up 500ml', '25.00', '', '0.000', 'pc'),
(18, 'Mirinda 500ml', '24.00', NULL, '0.000', 'pc'),
(19, 'Dew 500ml', '25.00', NULL, '0.000', 'pc'),
(20, 'britannia Cake', '30.00', 'britannia Cake 200g 30/-', '0.000', 'pc'),
(21, 'britannia Cake', '30.00', 'britannia Cake 200g 30/-', '0.000', 'pc'),
(22, 'Appy fizz 250ml', '15.00', '', '0.000', 'pc'),
(23, 'Appy fizz 250ml', '15.00', '', '0.000', 'pc'),
(24, 'Appy fizz 250ml', '15.00', '', '0.000', 'pc');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `taxrate` int(11) NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  `wholesaler_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_entity`
--

CREATE TABLE IF NOT EXISTS `purchase_entity` (
  `purchase_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE IF NOT EXISTS `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `taxrate` int(11) NOT NULL DEFAULT '0',
  `discount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sale_entity`
--

CREATE TABLE IF NOT EXISTS `sale_entity` (
  `sale_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wholesalers`
--

CREATE TABLE IF NOT EXISTS `wholesalers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `address` text,
  `contact_no` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wholesalers`
--

INSERT INTO `wholesalers` (`id`, `name`, `address`, `contact_no`) VALUES
(1, 'Abc', '0', ''),
(2, 'Abc', '0', ''),
(3, 'Freeto lay', '0', '1209120912'),
(4, 'Kartavya and Co.', 'E 226 Baker''s Street', '007007007007');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
