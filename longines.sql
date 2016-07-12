-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2014 at 04:48 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `longines`
--

-- --------------------------------------------------------

--
-- Table structure for table `order1`
--

CREATE TABLE IF NOT EXISTS `order1` (
  `ORDER_ID` varchar(25) NOT NULL,
  `USER_ID` varchar(25) NOT NULL,
  `STATUS` varchar(25) NOT NULL,
  PRIMARY KEY (`ORDER_ID`),
  KEY `USER_ID` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order1`
--

INSERT INTO `order1` (`ORDER_ID`, `USER_ID`, `STATUS`) VALUES
('18404', 'shah', 'FINISHED'),
('32917', 'shah', 'FINISHED'),
('37012', 'shah', 'PENDING'),
('47916', 'shah', 'FINISHED'),
('52129', 'shah', 'FINISHED'),
('53580', 'shah', 'FINISHED'),
('54313', 'shah', 'FINISHED'),
('73124', 'shah', 'FINISHED'),
('97198', 'ganga', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `ORDER_ID` varchar(25) NOT NULL,
  `PRODUCT_ID` varchar(25) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `ORDER_ITEM_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ORDER_ITEM_ID`),
  UNIQUE KEY `ORDER_ITEM_ID` (`ORDER_ITEM_ID`),
  KEY `ORDER_ID` (`ORDER_ID`),
  KEY `PRODUCT_ID` (`PRODUCT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`ORDER_ID`, `PRODUCT_ID`, `QUANTITY`, `ORDER_ITEM_ID`) VALUES
('97198', 'long1001', 7, 26),
('97198', 'long1002', 4, 27),
('47916', 'long1001', 1, 28),
('47916', 'long1002', 2, 29),
('53580', 'long1001', 1, 30),
('54313', 'long1001', 1, 31),
('73124', 'long1003', 2, 32),
('52129', 'long1004', 1, 33),
('18404', 'long1002', 2, 34),
('32917', 'long1001', 1, 35);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `FIRST_NAME` varchar(25) NOT NULL,
  `LAST_NAME` varchar(25) NOT NULL,
  `PERSON_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `EMAIL_ID` varchar(40) NOT NULL,
  `MOBILE` int(12) NOT NULL,
  `DATE_OF_BIRTH` date NOT NULL,
  PRIMARY KEY (`PERSON_ID`),
  UNIQUE KEY `PERSON_ID` (`PERSON_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9762 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`FIRST_NAME`, `LAST_NAME`, `PERSON_ID`, `EMAIL_ID`, `MOBILE`, `DATE_OF_BIRTH`) VALUES
('Srikanth', 'Melugiri', 1234, 'srikanth.shah@gmail.com', 121212, '2014-12-04'),
('Chakri', 'Srinivas', 1957, 'sd@sd.com', 21212121, '1999-02-14'),
('Kuldee', 'Mandepudi', 1987, 'kuldeep.mandepudi@gmail.com', -22, '0000-00-00'),
('Vasu', 'Karupa', 4743, 'vasu.karuparthi@gmail.com', -2, '0000-00-00'),
('Gangadhar', 'Vallabhaneni', 9761, 'gangadhar.vallabhaneni@gmail.com', 54545454, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `prod_name` varchar(25) NOT NULL,
  `prod_desc` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(50) NOT NULL,
  `prod_id` varchar(10) NOT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_name`, `prod_desc`, `price`, `image`, `prod_id`) VALUES
('HydroConquest-Blue', '\r\n    Shape: Round\r\n    Material: Stainless steel\r\n    Specificities: Unidirectional rotating bezel, Screw-in crown\r\n    Glass: Scratch-resistant sapphire crystal, with several layers of anti-reflecti', 200, '../images/hcblue.jpg', 'long1001'),
('HydroConquest-Black', '\r\n    Shape: Round\r\n    Material: Stainless steel\r\n    Specificities: Unidirectional rotating bezel, Screw-in crown\r\n    Glass: Scratch-resistant sapphire crystal, with several layers of anti-reflecti', 250, '../images/hcblack.jpg', 'long1002'),
('SAINT IMIER', 'Shape: Round\r\nMaterial: Stainless steel and 18 carats pink gold cap 200\r\nGlass: Scratch-resistant sapphire crystal, with several layers of anti-reflective coating on the underside', 350, '../images/saint1.jpg', 'long1003'),
('SAINT IMIER LEAR', 'Shape: Round\r\nMaterial: Stainless steel and 18 carats pink gold cap 200\r\nGlass: Scratch-resistant sapphire crystal, with several layers of anti-reflective coating on the underside', 400, '../images/saint2.jpg', 'long1004');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE IF NOT EXISTS `user_account` (
  `USER_ID` varchar(25) NOT NULL,
  `PASSWORD` varchar(25) NOT NULL,
  `PERSON_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`USER_ID`),
  UNIQUE KEY `PERSON_ID` (`PERSON_ID`),
  KEY `PERSON_ID_2` (`PERSON_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='USER ID TABLE' AUTO_INCREMENT=9762 ;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`USER_ID`, `PASSWORD`, `PERSON_ID`) VALUES
('chakri', 'chakri', 1957),
('ganga', 'ganga', 9761),
('kuldeep', 'kuldeep', 1987),
('shah', 'shah', 1234),
('vasu', 'vasu', 4743);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order1`
--
ALTER TABLE `order1`
  ADD CONSTRAINT `order1_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `user_account` (`USER_ID`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`ORDER_ID`) REFERENCES `order1` (`ORDER_ID`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`prod_id`);

--
-- Constraints for table `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `FOREIGN` FOREIGN KEY (`PERSON_ID`) REFERENCES `person` (`PERSON_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
