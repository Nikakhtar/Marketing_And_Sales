-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 06, 2020 at 03:54 AM
-- Server version: 5.6.44
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miraakaam`
--
CREATE DATABASE IF NOT EXISTS `miraakaam` DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci;
USE `miraakaam`;

-- --------------------------------------------------------

--
-- Table structure for table `claim`
--

DROP TABLE IF EXISTS `claim`;
CREATE TABLE IF NOT EXISTS `claim` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Invoice` int(11) NOT NULL,
  `Manager` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Submit_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Latest_Review_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Reviewer` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `State` int(11) NOT NULL,
  `Start_Delay` int(11) DEFAULT NULL,
  `Total_Delay` int(11) DEFAULT '0',
  `Total_Spent_Time` int(11) DEFAULT '0',
  `Expected_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Possible_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Amount` int(11) NOT NULL,
  `Description` text COLLATE utf8_persian_ci,
  `Priority` int(1) DEFAULT NULL,
  `Deadline` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Delay_Support` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `State` (`State`),
  KEY `invoice` (`Invoice`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `claim`
--

INSERT INTO `claim` (`Id`, `Invoice`, `Manager`, `Submit_Date`, `Latest_Review_Date`, `Reviewer`, `State`, `Start_Delay`, `Total_Delay`, `Total_Spent_Time`, `Expected_Date`, `Possible_Date`, `Amount`, `Description`, `Priority`, `Deadline`, `Delay_Support`) VALUES
(1, 2, '00000000000000000000000000000001', '1398-09-11', '1398-09-11', '00000000000000000000000000000001', 4, 0, 0, 639, '1398/09/02', '1398/09/19', 32322, 'asdasd', 2, '1398/09/25', 12);

-- --------------------------------------------------------

--
-- Table structure for table `claim_document`
--

DROP TABLE IF EXISTS `claim_document`;
CREATE TABLE IF NOT EXISTS `claim_document` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Claim` int(11) NOT NULL,
  `Archivist` varchar(255) DEFAULT NULL,
  `Deposit_Date` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `Deposit_Amount` int(11) NOT NULL DEFAULT '0',
  `Bank` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `Value_Added` int(11) NOT NULL DEFAULT '0',
  `Insurance_Cost` int(11) NOT NULL DEFAULT '0',
  `Tax` int(11) NOT NULL DEFAULT '0',
  `Deposit_Cost` int(11) NOT NULL DEFAULT '0',
  `Document_Link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Claim` (`Claim`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `claim_document`
--

INSERT INTO `claim_document` (`Id`, `Claim`, `Archivist`, `Deposit_Date`, `Deposit_Amount`, `Bank`, `Value_Added`, `Insurance_Cost`, `Tax`, `Deposit_Cost`, `Document_Link`) VALUES
(1, 1, '00000000000000000000000000000001', '1398/09/27', 132, 'asdas', 213, 32, 312, 123, '12'),
(2, 1, '00000000000000000000000000000001', '1398/09/27', 132, 'asdas', 213, 32, 312, 123, '12'),
(3, 1, '00000000000000000000000000000001', '1398/09/27', 132, 'asdas', 213, 32, 312, 123, '12');

-- --------------------------------------------------------

--
-- Table structure for table `claim_holding`
--

DROP TABLE IF EXISTS `claim_holding`;
CREATE TABLE IF NOT EXISTS `claim_holding` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Claim` int(11) NOT NULL,
  `Owner` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text COLLATE utf8_persian_ci,
  `Submit_Date` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `Deadline` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `Delay` int(11) DEFAULT NULL,
  `Spent_Time` int(11) DEFAULT NULL,
  `Result` int(11) NOT NULL,
  `Pass_To` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Selling` (`Claim`),
  KEY `Result` (`Result`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `claim_holding`
--

INSERT INTO `claim_holding` (`Id`, `Claim`, `Owner`, `Description`, `Submit_Date`, `Deadline`, `Delay`, `Spent_Time`, `Result`, `Pass_To`) VALUES
(1, 1, '00000000000000000000000000000001', 'qdwd', '1398-09-11', '1398/09/04', NULL, 213, 1, '00000000000000000000000000000001'),
(2, 1, '00000000000000000000000000000001', 'qdwd', '1398-09-11', '1398/09/04', NULL, 213, 3, '00000000000000000000000000000001'),
(3, 1, '00000000000000000000000000000001', 'qdwd', '1398-09-11', '1398/09/04', NULL, 213, 3, '00000000000000000000000000000001');

--
-- Triggers `claim_holding`
--
DROP TRIGGER IF EXISTS `claim_holding`;
DELIMITER $$
CREATE TRIGGER `claim_holding` AFTER INSERT ON `claim_holding` FOR EACH ROW UPDATE claim SET Total_Spent_Time = (SELECT SUM(Spent_Time) FROM claim_holding WHERE claim_holding.Claim = NEW.Claim) WHERE claim.Id = NEW.Claim
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Sale` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Contact` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Phone` (`Contact`),
  KEY `Patron` (`Sale`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`Id`, `Sale`, `Name`, `Contact`) VALUES
(1, 1, 'ali', '0913'),
(2, 1, 'reza', '0914'),
(18, 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `framework`
--

DROP TABLE IF EXISTS `framework`;
CREATE TABLE IF NOT EXISTS `framework` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `framework`
--

INSERT INTO `framework` (`Id`, `Name`) VALUES
(1, 'آی کن');

-- --------------------------------------------------------

--
-- Table structure for table `holding_result`
--

DROP TABLE IF EXISTS `holding_result`;
CREATE TABLE IF NOT EXISTS `holding_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Result` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `holding_result`
--

INSERT INTO `holding_result` (`Id`, `Result`) VALUES
(1, 'در حال پیگیری'),
(2, 'محقق شد'),
(3, 'محقق نشد'),
(4, 'باطل شد');

-- --------------------------------------------------------

--
-- Table structure for table `implementation`
--

DROP TABLE IF EXISTS `implementation`;
CREATE TABLE IF NOT EXISTS `implementation` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Invoice` int(11) NOT NULL,
  `Manager` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Header` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Submit_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Latest_Review_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Reviewer` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `State` int(11) NOT NULL,
  `Start_Delay` int(11) DEFAULT NULL,
  `Total_Delay` int(11) DEFAULT '0',
  `Total_Spent_Time` int(11) DEFAULT '0',
  `Support_Interval` int(11) NOT NULL,
  `Support_Start_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Warranty_Interval` int(11) NOT NULL DEFAULT '0',
  `Warranty_Start_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Expected_Start_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Expected_Finish_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Start_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Finish_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Remaining_Days` int(11) NOT NULL DEFAULT '0',
  `Supported_Days` int(11) NOT NULL DEFAULT '0',
  `Description` text COLLATE utf8_persian_ci,
  `Priority` int(1) DEFAULT NULL,
  `Deadline` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `State` (`State`),
  KEY `invoice` (`Invoice`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `implementation`
--

INSERT INTO `implementation` (`Id`, `Invoice`, `Manager`, `Header`, `Submit_Date`, `Latest_Review_Date`, `Reviewer`, `State`, `Start_Delay`, `Total_Delay`, `Total_Spent_Time`, `Support_Interval`, `Support_Start_Date`, `Warranty_Interval`, `Warranty_Start_Date`, `Expected_Start_Date`, `Expected_Finish_Date`, `Start_Date`, `Finish_Date`, `Remaining_Days`, `Supported_Days`, `Description`, `Priority`, `Deadline`) VALUES
(1, 8, '12', '12', '12', '12', '12', 2, 12, 12, 5, 12, '12', 4, '12', '12', '12', '12', '12', 2, 3, '12', 1, '12');

-- --------------------------------------------------------

--
-- Table structure for table `implementation_document`
--

DROP TABLE IF EXISTS `implementation_document`;
CREATE TABLE IF NOT EXISTS `implementation_document` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Implementation` int(11) NOT NULL,
  `Archivist` varchar(255) DEFAULT NULL,
  `Document_Link` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Implementation` (`Implementation`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `implementation_transaction`
--

DROP TABLE IF EXISTS `implementation_transaction`;
CREATE TABLE IF NOT EXISTS `implementation_transaction` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Implementation` int(11) NOT NULL,
  `Owner` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text COLLATE utf8_persian_ci,
  `Submit_Date` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `Spent_Time` int(11) DEFAULT NULL,
  `Result` int(11) NOT NULL,
  `Pass_To` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Verified` tinyint(4) NOT NULL DEFAULT '0',
  `Reviewer` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Supported_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Result` (`Result`),
  KEY `Implementation` (`Implementation`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Triggers `implementation_transaction`
--
DROP TRIGGER IF EXISTS `implementation_holding`;
DELIMITER $$
CREATE TRIGGER `implementation_holding` AFTER INSERT ON `implementation_transaction` FOR EACH ROW UPDATE implementation SET Total_Spent_Time = (SELECT SUM(Spent_Time) FROM implementation_holding WHERE implementation_holding.Implementation = NEW.Implementation) WHERE implementation.Id = NEW.Implementation
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Selling` int(11) NOT NULL,
  `Owner` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Submit_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Type` int(11) NOT NULL,
  `Implementation_Priority` int(11) NOT NULL,
  `Implementation_Deadline` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Claim_Deadline` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Price` int(11) NOT NULL,
  `Implementation_Topic` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Reviewer` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Review_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `State` int(11) NOT NULL,
  `Description` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Selling` (`Selling`),
  KEY `Type` (`Type`),
  KEY `State` (`State`),
  KEY `Implementation_Priority` (`Implementation_Priority`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`Id`, `Selling`, `Owner`, `Submit_Date`, `Type`, `Implementation_Priority`, `Implementation_Deadline`, `Claim_Deadline`, `Price`, `Implementation_Topic`, `Reviewer`, `Review_Date`, `State`, `Description`) VALUES
(1, 1, '00000000000000000000000000000001', '1398-09-11', 1, 1, '20', '12', 311331, 'qweqe', '00000000000000000000000000000001', '1398-09-18', 3, 'dddddddd'),
(2, 1, '00000000000000000000000000000001', '1398-09-11', 1, 1, '322', '123', 4211, 'werweree', '00000000000000000000000000000001', '1398-09-11', 7, 'zzzzz'),
(3, 1, '00000000000000000000000000000001', '1398-09-11', 1, 1, '2222222', '123', 2, 'xxxxxx', '00000000000000000000000000000001', '1398-09-11', 2, 'asd'),
(4, 1, '00000000000000000000000000000001', '1398-09-11', 1, 2, '12', '12', 12, '12', '00000000000000000000000000000001', '1398-09-18', 3, '12'),
(5, 1, '00000000000000000000000000000001', '1398-09-11', 1, 4, '31', '31', 31, '12313', '00000000000000000000000000000001', '1398-09-18', 3, '31'),
(6, 1, '00000000000000000000000000000001', '1398-09-16', 1, 1, '22222', '222222', 22222, '222', 'NULL', 'NULL', 1, '22222'),
(7, 1, '00000000000000000000000000000001', '1398-09-16', 1, 1, '33333', '333', 333333, '333333', 'NULL', 'NULL', 1, '333'),
(8, 1, '00000000000000000000000000000001', '1398-09-16', 1, 1, '4', '4', 5, '4444', 'NULL', 'NULL', 1, '4');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_implementation_priority`
--

DROP TABLE IF EXISTS `invoice_implementation_priority`;
CREATE TABLE IF NOT EXISTS `invoice_implementation_priority` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Priority` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `invoice_implementation_priority`
--

INSERT INTO `invoice_implementation_priority` (`Id`, `Priority`) VALUES
(1, 'فقط مطالبه'),
(2, 'فقط تعهد'),
(3, 'انجام تعهد بعد از دریافت مطالبه'),
(4, 'انجام تعهد قبل از دریافت مطالبه');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_state`
--

DROP TABLE IF EXISTS `invoice_state`;
CREATE TABLE IF NOT EXISTS `invoice_state` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `State` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `invoice_state`
--

INSERT INTO `invoice_state` (`Id`, `State`) VALUES
(1, 'در انتظار تایید'),
(2, 'عدم تایید'),
(3, 'در انتظار معرفی مطالبه'),
(4, 'در صف پیگیری مطالبه'),
(5, 'اعلام موفقیت در دریافت مطالبه -در انتظار تایید وضعیت'),
(6, 'اعلام عدم موفقیت در دریافت مطالبه - در انتظار تایید وضعیت'),
(7, 'مطالبه باطل شده است'),
(8, 'دریافت مطالبه با موفقیت به پایان رسیده است'),
(9, 'دریافت مطالبه با عدم موفقیت به پایان رسیده است'),
(10, 'در انتظار معرفی تعهد'),
(11, 'در صف پیگیری تعهد'),
(12, 'اعلام موفقیت در انجام تعهد -در انتظار تایید وضعیت'),
(13, 'اعلام عدم موفقیت در انجام تعهد - در انتظار تایید وضعیت'),
(14, 'تعهد باطل شده است'),
(15, 'انجام تعهد با موفقیت به پایان رسیده است'),
(16, 'انجام تعهد با عدم موفقیت به پایان رسیده است');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_type`
--

DROP TABLE IF EXISTS `invoice_type`;
CREATE TABLE IF NOT EXISTS `invoice_type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `invoice_type`
--

INSERT INTO `invoice_type` (`Id`, `Type`) VALUES
(1, 'فروش و خدمات');

-- --------------------------------------------------------

--
-- Table structure for table `marketing`
--

DROP TABLE IF EXISTS `marketing`;
CREATE TABLE IF NOT EXISTS `marketing` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Sale` int(11) NOT NULL,
  `Manager` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Submit_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Latest_Review_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Reviewer` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `State` int(11) NOT NULL,
  `Total_Delay` int(11) DEFAULT '0',
  `Total_Spent_Time` int(11) DEFAULT '0',
  `Description` text COLLATE utf8_persian_ci,
  `Priority` int(1) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `State` (`State`),
  KEY `Sale` (`Sale`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `marketing`
--

INSERT INTO `marketing` (`Id`, `Sale`, `Manager`, `Submit_Date`, `Latest_Review_Date`, `Reviewer`, `State`, `Total_Delay`, `Total_Spent_Time`, `Description`, `Priority`) VALUES
(1, 1, '00000000000000000000000000000001', '1398-09-11', '1398-09-11', '00000000000000000000000000000001', 2, 0, 77, '22saleDesc', 3),
(2, 3, '00000000000000000000000000000001', '1398-11-17', '', '', 1, 0, 0, 'qwe', 1),
(3, 4, '00000000000000000000000000000001', '1398-11-17', '1398-11-17', '00000000000000000000000000000001', 1, 0, 13, 'sadas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `marketing_holding`
--

DROP TABLE IF EXISTS `marketing_holding`;
CREATE TABLE IF NOT EXISTS `marketing_holding` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Marketing` int(11) NOT NULL,
  `Owner` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text COLLATE utf8_persian_ci,
  `Submit_Date` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `Deadline` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `Delay` int(11) DEFAULT NULL,
  `Spent_Time` int(11) DEFAULT NULL,
  `Result` int(11) NOT NULL,
  `Pass_To` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Sale` (`Marketing`),
  KEY `Result` (`Result`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `marketing_holding`
--

INSERT INTO `marketing_holding` (`Id`, `Marketing`, `Owner`, `Description`, `Submit_Date`, `Deadline`, `Delay`, `Spent_Time`, `Result`, `Pass_To`) VALUES
(1, 1, '00000000000000000000000000000001', '1st holdingDesc', '1398-09-11', '1398/09/12', NULL, 20, 1, '00000000000000000000000000000001'),
(2, 1, '00000000000000000000000000000001', '1st holdingDesc', '1398-09-11', '1398/09/19', NULL, 35, 1, '00000000000000000000000000000001'),
(3, 1, '00000000000000000000000000000001', 'latest one', '1398-09-11', '1398/09/19', NULL, 0, 3, '00000000000000000000000000000001'),
(4, 1, '00000000000000000000000000000001', 'lqwatwstsadqwlatest one', '1398-09-11', '1398/09/19', NULL, 22, 2, '00000000000000000000000000000001'),
(5, 3, '00000000000000000000000000000001', 'c', '1398-11-17', '1398/11/21', NULL, 12, 1, '00000000000000000000000000000001'),
(6, 3, '00000000000000000000000000000001', 'c', '1398-11-17', '1398/11/21', NULL, 1, 2, '00000000000000000000000000000001');

--
-- Triggers `marketing_holding`
--
DROP TRIGGER IF EXISTS `1`;
DELIMITER $$
CREATE TRIGGER `1` AFTER INSERT ON `marketing_holding` FOR EACH ROW UPDATE marketing SET Total_Spent_Time = (SELECT SUM(Spent_Time) FROM marketing_holding WHERE marketing_holding.Marketing = NEW.Marketing) WHERE marketing.Id = NEW.Marketing
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `patron`
--

DROP TABLE IF EXISTS `patron`;
CREATE TABLE IF NOT EXISTS `patron` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) COLLATE utf8_persian_ci NOT NULL,
  `Introduce_Method` varchar(250) COLLATE utf8_persian_ci DEFAULT NULL,
  `Registery_Date` varchar(250) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `patron`
--

INSERT INTO `patron` (`Id`, `Name`, `Introduce_Method`, `Registery_Date`) VALUES
(1, 'شرکت فولاد', 'نمایشگاه', '08-08-2019');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Framework` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Firmware` (`Framework`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Id`, `Framework`, `Name`) VALUES
(1, 1, 'سیستم حضور و غیاب');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
CREATE TABLE IF NOT EXISTS `sale` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Application` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Manager` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Patron` int(11) NOT NULL,
  `Product` int(11) NOT NULL,
  `Submit_Date` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `Finish_Date` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `State` int(11) NOT NULL,
  `Description` text COLLATE utf8_persian_ci,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Application` (`Application`),
  KEY `Patron` (`Patron`),
  KEY `Product` (`Product`),
  KEY `Manager` (`Manager`),
  KEY `State` (`State`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`Id`, `Application`, `Manager`, `Patron`, `Product`, `Submit_Date`, `Finish_Date`, `State`, `Description`) VALUES
(1, '4103817415de52e20bc43c8093669646', '00000000000000000000000000000001', 1, 1, '1398-09-11', '', 11, 'saleDesc'),
(2, 'qwqw', 'qweqweqe', 1, 1, 'adsdasd', 'sadsad', 1, 'dasdasd'),
(3, '4876488425e3bd8901a1925030028423', '00000000000000000000000000000001', 1, 1, '1398-11-17', '', 1, 'qwe'),
(4, '1950134015e3bd992330186078730716', '00000000000000000000000000000001', 1, 1, '1398-11-17', '', 1, 'sadas');

-- --------------------------------------------------------

--
-- Table structure for table `sale_state`
--

DROP TABLE IF EXISTS `sale_state`;
CREATE TABLE IF NOT EXISTS `sale_state` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `State` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `sale_state`
--

INSERT INTO `sale_state` (`Id`, `State`) VALUES
(1, 'در صف پیگیری بازاریاب'),
(2, 'اعلام موفقیت و توقف در بازاریابی - در انتظار تایید وضعیت توسط مدیر'),
(3, 'اعلام عدم موفقیت و توقف در بازاریابی - در انتظار ت...اااااااااااااااااااااا'),
(4, 'بازاریابی باطل شده است'),
(5, 'بازاریابی با موفقیت به پایان رسیده'),
(6, 'بازاریابی با عدم موفقیت به پایان رسیده'),
(7, 'در صف پیگیری فروش'),
(8, 'اعلام موفقیت و توقف در پیگیری فروش - در انتظار تایید...'),
(9, 'اعلام عدم موفقیت و توقف در پیگیری فروش - در انتظار ت...'),
(10, 'فروش باطل شده است'),
(11, 'فروش با موفقیت به پایان رسیده'),
(12, 'فروش با عدم موفقیت به پایان رسیده'),
(16, 'اجرای قرارداد'),
(17, 'اتمام قرارداد');

-- --------------------------------------------------------

--
-- Table structure for table `selling`
--

DROP TABLE IF EXISTS `selling`;
CREATE TABLE IF NOT EXISTS `selling` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Sale` int(11) NOT NULL,
  `Manager` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Submit_Date` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `Latest_Review_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Reviewer` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `State` int(11) NOT NULL,
  `Total_Delay` int(11) DEFAULT '0',
  `Total_Spent_Time` int(11) DEFAULT '0',
  `Expected_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Possible_Date` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `Expected_Income` int(11) DEFAULT NULL,
  `Possible_Income` int(11) DEFAULT NULL,
  `Real_Income` int(11) DEFAULT NULL,
  `Type` int(11) DEFAULT NULL,
  `Success_Percentage` int(11) DEFAULT NULL,
  `Description` text COLLATE utf8_persian_ci,
  `ContractDoc_Number` int(11) DEFAULT NULL,
  `Priority` int(1) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Type` (`Type`),
  KEY `State` (`State`),
  KEY `Sale` (`Sale`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `selling`
--

INSERT INTO `selling` (`Id`, `Sale`, `Manager`, `Submit_Date`, `Latest_Review_Date`, `Reviewer`, `State`, `Total_Delay`, `Total_Spent_Time`, `Expected_Date`, `Possible_Date`, `Expected_Income`, `Possible_Income`, `Real_Income`, `Type`, `Success_Percentage`, `Description`, `ContractDoc_Number`, `Priority`) VALUES
(1, 1, '00000000000000000000000000000001', '1398-09-11', '1398-09-11', '00000000000000000000000000000001', 2, 0, 232, '1398/09/19', '1398/09/12', 333, 0, 100000, 1, 35, '123213', 435, 3);

-- --------------------------------------------------------

--
-- Table structure for table `selling_document`
--

DROP TABLE IF EXISTS `selling_document`;
CREATE TABLE IF NOT EXISTS `selling_document` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Selling` int(11) NOT NULL,
  `Archivist` varchar(255) DEFAULT NULL,
  `Document_Link` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Selling` (`Selling`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `selling_holding`
--

DROP TABLE IF EXISTS `selling_holding`;
CREATE TABLE IF NOT EXISTS `selling_holding` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Selling` int(11) NOT NULL,
  `Owner` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text COLLATE utf8_persian_ci,
  `Submit_Date` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `Deadline` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `Delay` int(11) DEFAULT NULL,
  `Spent_Time` int(11) DEFAULT NULL,
  `Result` int(11) NOT NULL,
  `Pass_To` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Selling` (`Selling`),
  KEY `Result` (`Result`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `selling_holding`
--

INSERT INTO `selling_holding` (`Id`, `Selling`, `Owner`, `Description`, `Submit_Date`, `Deadline`, `Delay`, `Spent_Time`, `Result`, `Pass_To`) VALUES
(1, 1, '00000000000000000000000000000001', '', '1398-09-11', '1398/09/19', NULL, 232, 1, '00000000000000000000000000000001'),
(2, 1, '00000000000000000000000000000001', '', '1398-09-11', '1398/09/19', NULL, 0, 3, '00000000000000000000000000000001'),
(3, 1, '00000000000000000000000000000001', '', '1398-09-11', '1398/09/19', NULL, 0, 2, '00000000000000000000000000000001'),
(4, 1, '00000000000000000000000000000001', '', '1398-09-11', '1398/09/19', NULL, 0, 4, '00000000000000000000000000000001');

--
-- Triggers `selling_holding`
--
DROP TRIGGER IF EXISTS `selling_holding`;
DELIMITER $$
CREATE TRIGGER `selling_holding` AFTER INSERT ON `selling_holding` FOR EACH ROW UPDATE selling SET Total_Spent_Time = (SELECT SUM(Spent_Time) FROM selling_holding WHERE selling_holding.Selling = NEW.Selling) WHERE selling.Id = NEW.Selling
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `selling_type`
--

DROP TABLE IF EXISTS `selling_type`;
CREATE TABLE IF NOT EXISTS `selling_type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `selling_type`
--

INSERT INTO `selling_type` (`Id`, `Type`) VALUES
(1, 'فروش مجدد');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `State` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`Id`, `State`) VALUES
(1, 'نیاز به پیگیری'),
(2, 'محقق شده'),
(3, 'محقق نشده'),
(4, 'باطل شده');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `claim`
--
ALTER TABLE `claim`
  ADD CONSTRAINT `claim_ibfk_1` FOREIGN KEY (`State`) REFERENCES `state` (`Id`),
  ADD CONSTRAINT `claim_ibfk_2` FOREIGN KEY (`Invoice`) REFERENCES `invoice` (`Id`);

--
-- Constraints for table `claim_document`
--
ALTER TABLE `claim_document`
  ADD CONSTRAINT `claim_document_ibfk_1` FOREIGN KEY (`Claim`) REFERENCES `claim` (`Id`);

--
-- Constraints for table `claim_holding`
--
ALTER TABLE `claim_holding`
  ADD CONSTRAINT `claim_holding_ibfk_1` FOREIGN KEY (`Claim`) REFERENCES `claim` (`Id`),
  ADD CONSTRAINT `claim_holding_ibfk_2` FOREIGN KEY (`Result`) REFERENCES `holding_result` (`Id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`Sale`) REFERENCES `sale` (`Id`);

--
-- Constraints for table `implementation`
--
ALTER TABLE `implementation`
  ADD CONSTRAINT `implementation_ibfk_1` FOREIGN KEY (`Invoice`) REFERENCES `invoice` (`Id`),
  ADD CONSTRAINT `implementation_ibfk_2` FOREIGN KEY (`State`) REFERENCES `state` (`Id`);

--
-- Constraints for table `implementation_document`
--
ALTER TABLE `implementation_document`
  ADD CONSTRAINT `implementation_document_ibfk_1` FOREIGN KEY (`Implementation`) REFERENCES `implementation` (`Id`);

--
-- Constraints for table `implementation_transaction`
--
ALTER TABLE `implementation_transaction`
  ADD CONSTRAINT `implementation_transaction_ibfk_1` FOREIGN KEY (`Implementation`) REFERENCES `implementation` (`Id`),
  ADD CONSTRAINT `implementation_transaction_ibfk_2` FOREIGN KEY (`Result`) REFERENCES `holding_result` (`Id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`Selling`) REFERENCES `selling` (`Id`),
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`Type`) REFERENCES `invoice_type` (`Id`),
  ADD CONSTRAINT `invoice_ibfk_4` FOREIGN KEY (`State`) REFERENCES `invoice_state` (`Id`),
  ADD CONSTRAINT `invoice_ibfk_5` FOREIGN KEY (`Implementation_Priority`) REFERENCES `invoice_implementation_priority` (`Id`);

--
-- Constraints for table `marketing`
--
ALTER TABLE `marketing`
  ADD CONSTRAINT `marketing_ibfk_1` FOREIGN KEY (`State`) REFERENCES `state` (`Id`),
  ADD CONSTRAINT `marketing_ibfk_2` FOREIGN KEY (`Sale`) REFERENCES `sale` (`Id`);

--
-- Constraints for table `marketing_holding`
--
ALTER TABLE `marketing_holding`
  ADD CONSTRAINT `marketing_holding_ibfk_4` FOREIGN KEY (`Result`) REFERENCES `holding_result` (`Id`),
  ADD CONSTRAINT `marketing_holding_ibfk_5` FOREIGN KEY (`Marketing`) REFERENCES `marketing` (`Id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Framework`) REFERENCES `framework` (`Id`);

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`Patron`) REFERENCES `patron` (`Id`),
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`Product`) REFERENCES `product` (`Id`),
  ADD CONSTRAINT `sale_ibfk_3` FOREIGN KEY (`State`) REFERENCES `sale_state` (`Id`);

--
-- Constraints for table `selling`
--
ALTER TABLE `selling`
  ADD CONSTRAINT `selling_ibfk_1` FOREIGN KEY (`Sale`) REFERENCES `sale` (`Id`),
  ADD CONSTRAINT `selling_ibfk_2` FOREIGN KEY (`State`) REFERENCES `state` (`Id`),
  ADD CONSTRAINT `selling_ibfk_3` FOREIGN KEY (`Type`) REFERENCES `selling_type` (`Id`);

--
-- Constraints for table `selling_document`
--
ALTER TABLE `selling_document`
  ADD CONSTRAINT `selling_document_ibfk_1` FOREIGN KEY (`Selling`) REFERENCES `selling` (`Id`);

--
-- Constraints for table `selling_holding`
--
ALTER TABLE `selling_holding`
  ADD CONSTRAINT `selling_holding_ibfk_1` FOREIGN KEY (`Selling`) REFERENCES `selling` (`Id`),
  ADD CONSTRAINT `selling_holding_ibfk_2` FOREIGN KEY (`Result`) REFERENCES `holding_result` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
