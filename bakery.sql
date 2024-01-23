-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2024 at 09:58 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unicode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PhoneNumber` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MaxShops` int(11) DEFAULT NULL,
  `Plan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `isAdmin` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Name`, `unicode`, `Address`, `image`, `PhoneNumber`, `Email`, `Password`, `MaxShops`, `Plan`, `timestamp`, `isAdmin`) VALUES
(8, 'Nelvister', 'VLZc1DHiPW', 'Nainad', 'nayanlogo.png', '876235340', 'admin@gmail.com', 'admin', 5, '1-year-with-support', '2023-07-14 12:44:18', 1),
(15, 'athul', 'n5MXDbE8Hf', 'kundapur', NULL, '9591291585', 'athulkharvi1234@gmail.com', 'blackmask', 2, '1-year-with-support', '2024-01-20 10:38:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `userID`, `name`, `location`, `status`) VALUES
(13, 'VLZc1DHiPW', 'Madanthyar', 'Madanthyar', 1),
(20, 'VLZc1DHiPW', 'Nainad', 'Nainad', 1),
(21, 'efwMCWZlUS', 'branch', 'branch', 1),
(22, 'VLZc1DHiPW', 'Siddakatte', 'Siddakatte', 0),
(23, 'n5MXDbE8Hf', 'kundapur', 'kundapur', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `userID`, `name`, `status`) VALUES
(4, 'VLZc1DHiPW', 'Chocolate', '0'),
(5, 'VLZc1DHiPW', 'bun', '0'),
(6, 'VLZc1DHiPW', 'Cake', '1'),
(7, 'VLZc1DHiPW', 'Rusk', '1'),
(8, 'VLZc1DHiPW', 'Ice cream', '1'),
(10, 'VLZc1DHiPW', 'Ashwith', '0'),
(11, 'VLZc1DHiPW', 'ashley', '0'),
(12, 'VLZc1DHiPW', 'asd', '0'),
(13, 'VLZc1DHiPW', 'rtyrty', '0'),
(14, 'VLZc1DHiPW', '456', '0'),
(15, 'VLZc1DHiPW', '456', '0'),
(16, 'VLZc1DHiPW', 'anson', '0'),
(17, 'VLZc1DHiPW', 'Chocolate', '1'),
(18, 'VLZc1DHiPW', '123', '0'),
(19, 'VLZc1DHiPW', 'Butter', '1'),
(20, 'VLZc1DHiPW', 'Sonte', '1'),
(21, 'VLZc1DHiPW', 'Mixture', '1'),
(22, 'VLZc1DHiPW', 'a', '0'),
(23, 'VLZc1DHiPW', 'user', '0'),
(24, 'VLZc1DHiPW', 'Ashwiths', '0'),
(25, 'VLZc1DHiPW', 'Ashley', '0'),
(26, 'VLZc1DHiPW', 'Ashwith', '0'),
(27, 'efwMCWZlUS', 'news user category1', '1'),
(28, 'efwMCWZlUS', 'new user category2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblparty`
--

CREATE TABLE `tblparty` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblparty`
--

INSERT INTO `tblparty` (`id`, `userID`, `name`, `mobno`, `gstno`, `status`, `timestamp`) VALUES
(3, 'VLZc1DHiPW', 'Mohan Bantwal', '9448590206', '12345', 1, '2023-07-14 12:58:36'),
(4, 'VLZc1DHiPW', 'Yash', '9487261230', '12', 1, '2023-07-14 12:58:36'),
(5, 'VLZc1DHiPW', 'Ashwith', '9638527419', '123', 1, '2023-07-14 12:58:36'),
(6, 'VLZc1DHiPW', 'Ashley Dsouza', '9449894840', '', 1, '2023-07-14 12:58:36'),
(7, 'VLZc1DHiPW', 'Ramesh', '7897897897', '123123123', 1, '2023-07-14 12:58:36'),
(8, 'VLZc1DHiPW', 'Yusuf', '6789067890', '123123123123123123', 1, '2023-07-14 12:58:36'),
(9, 'VLZc1DHiPW', 'Avinash', '8762825989', '', 1, '2023-07-14 12:58:36'),
(10, 'VLZc1DHiPW', 'purchase', '7897894400', '', 1, '2023-07-14 12:58:36'),
(11, 'VLZc1DHiPW', '123', '9448590244', '', 1, '2023-07-14 12:58:36'),
(12, 'VLZc1DHiPW', 'monohar', '9999888888', '', 1, '2023-07-14 12:58:36'),
(13, 'efwMCWZlUS', 'new user', '9865472033', '', 1, '2023-07-14 14:10:32'),
(14, 'efwMCWZlUS', 'new user from payin', '6764538293', '123123', 1, '2023-07-14 14:21:28'),
(15, 'efwMCWZlUS', 'new purchse invoi', '9865320147', '', 1, '2023-07-14 14:26:02'),
(16, 'efwMCWZlUS', 'new user party out', '8954123067', '', 1, '2023-07-14 15:02:18'),
(17, 'FPb70gsuy7', 'Ashley Dsouza', '9448590206', '1232', 1, '2023-07-18 11:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `tblpaymentin`
--

CREATE TABLE `tblpaymentin` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partyMobno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentAmount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentDate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentMode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentInNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entrytime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblpaymentin`
--

INSERT INTO `tblpaymentin` (`id`, `userID`, `partyName`, `partyMobno`, `paymentAmount`, `paymentDate`, `paymentMode`, `paymentInNumber`, `Notes`, `entrytime`) VALUES
(14, 'VLZc1DHiPW', 'Yash', '9487261230', '1000', '2023-07-04', 'cash', '1', '', '2023-07-14 12:58:36'),
(15, 'efwMCWZlUS', 'new user from payin', '6764538293', '500', '2023-07-14', 'bank', '1', '99', '2023-07-14 19:51:53');

--
-- Triggers `tblpaymentin`
--
DELIMITER $$
CREATE TRIGGER `paymentIn` BEFORE INSERT ON `tblpaymentin` FOR EACH ROW BEGIN

SET new.entrytime= CONVERT_TZ(CURRENT_TIME(), '+00:00','+05:30');

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblpaymentout`
--

CREATE TABLE `tblpaymentout` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partyMobno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentAmount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentDate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentMode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentOutNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entrytime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblpaymentout`
--

INSERT INTO `tblpaymentout` (`id`, `userID`, `partyName`, `partyMobno`, `paymentAmount`, `paymentDate`, `paymentMode`, `paymentOutNumber`, `Notes`, `entrytime`) VALUES
(1, 'VLZc1DHiPW', 'Mohan Bantwal', '9448590206', '5000', '2023-07-04', 'bank', '1', 'fully paid', '2023-07-04 18:21:53'),
(2, 'efwMCWZlUS', 'new user party out', '8954123067', '500', '2023-07-14', 'cheque', '1', '', '2023-07-14 20:32:29');

--
-- Triggers `tblpaymentout`
--
DELIMITER $$
CREATE TRIGGER `paymentout` BEFORE INSERT ON `tblpaymentout` FOR EACH ROW BEGIN

SET new.entrytime= CONVERT_TZ(CURRENT_TIME(), '+00:00','+05:30');

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_category` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleprice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `purchaseprice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1KG',
  `sizetype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'KG',
  `HSN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `openingstock` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`id`, `userID`, `category`, `sub_category`, `productname`, `saleprice`, `purchaseprice`, `size`, `sizetype`, `HSN`, `openingstock`, `gst`, `status`) VALUES
(1, 'VLZc1DHiPW', 'Mixture', '', 'Sweet Mixture', '100', '50', '1KG', 'KG', 'MIX22', '100', '5', '1'),
(2, 'VLZc1DHiPW', 'Rusk', '', 'Milk Rusk', '30', '10', '50G', 'G', '456RUSK', '500', '12', '1'),
(17, 'VLZc1DHiPW', 'Butter', NULL, 'butter2', '200', '130', '1KG', 'KG', NULL, NULL, NULL, '1'),
(19, 'VLZc1DHiPW', 'Rusk', NULL, 'rusk2', '20', '15', '1KG', 'KG', NULL, NULL, NULL, '1'),
(21, 'VLZc1DHiPW', 'Sonte', NULL, 'sonte5', '50', '40', '1KG', 'KG', NULL, NULL, NULL, '1'),
(28, 'VLZc1DHiPW', 'Rusk', NULL, 'sale', '100', '80', '1KG', 'KG', NULL, NULL, NULL, '0'),
(29, 'VLZc1DHiPW', 'Chocolate', NULL, 'hotproduct', '0', '200', '1KG', 'KG', NULL, NULL, NULL, '0'),
(30, 'VLZc1DHiPW', 'Rusk', '', 'Rusk', '99', '99', '10KG', 'KG', '99', '99', '12', '1'),
(31, 'VLZc1DHiPW', 'Cake', '', 'Cake', '10', '10', '20KG', 'KG', 'HSN', '20', '18', '1'),
(32, 'VLZc1DHiPW', 'Chocolate', '', 'something', '20', '20', '20GM', 'GM', 'HSN', '10', '18', '1'),
(33, 'VLZc1DHiPW', 'Cake', '', 'P', '10', '10', '10G', 'G', '10', '10', '5', '0'),
(34, 'VLZc1DHiPW', 'Rusk', '', 'Sweet Rusk', '100', '80', '1KG', 'KG', '', '', '', '0'),
(35, 'efwMCWZlUS', 'news user category1', '', 'new user product', '100', '60', '1KG', 'KG', 'HSNCODE', '100', '18', '1'),
(37, 'efwMCWZlUS', 'new user category2', NULL, 'new user product2', '100', '0', '1KG', 'KG', NULL, NULL, NULL, '1'),
(38, 'efwMCWZlUS', 'news user category1', NULL, 'purchase', '0', '80', '1KG', 'KG', NULL, NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblpurchaseinvoices`
--

CREATE TABLE `tblpurchaseinvoices` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_mobno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_invoice_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `after_discount_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_paid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_paid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_paid_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `total_balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblpurchaseinvoices`
--

INSERT INTO `tblpurchaseinvoices` (`id`, `userID`, `party_name`, `party_mobno`, `purchase_invoice_number`, `purchase_invoice_date`, `sub_total`, `discount`, `after_discount_total`, `full_paid`, `amount_paid`, `amount_paid_type`, `total_balance`, `timestamp`) VALUES
(81, 'VLZc1DHiPW', 'Yash', '9487261230', '1', '2023-07-03', '95', '5', '90', 'No', '0', '', '90', '2023-07-14 12:58:37'),
(82, 'VLZc1DHiPW', 'monohar', '9999888888', '1', '2023-07-03', '600', '100', '500', 'Yes', '500', 'check', '0', '2023-07-14 12:58:37'),
(83, 'efwMCWZlUS', 'new purchse invoi', '9865320147', '1', '2023-07-14', '8000', '0', '8000', 'No', '0', '', '8000', '2023-07-14 20:29:49');

--
-- Triggers `tblpurchaseinvoices`
--
DELIMITER $$
CREATE TRIGGER `purchasetime` BEFORE INSERT ON `tblpurchaseinvoices` FOR EACH ROW BEGIN

SET new.timestamp= CONVERT_TZ(CURRENT_TIME(), '+00:00','+05:30');

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblpurchaseinvoice_details`
--

CREATE TABLE `tblpurchaseinvoice_details` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_invoice_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ItemName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HSN` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BatchNo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ExpireDate` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ManufactureDate` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Qty` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Price` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Discount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Tax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblpurchaseinvoice_details`
--

INSERT INTO `tblpurchaseinvoice_details` (`id`, `userID`, `purchase_invoice_number`, `ItemName`, `HSN`, `BatchNo`, `ExpireDate`, `ManufactureDate`, `Size`, `Qty`, `Price`, `Discount`, `Tax`, `Amount`) VALUES
(56, 'VLZc1DHiPW', '1', 'rusk2', '', '', '', '', '', '1', '15', '0', '0', '15'),
(57, 'VLZc1DHiPW', '1', 'sale', '', '', '', '', '', '1', '80', '0', '0', '80'),
(58, 'VLZc1DHiPW', '1', 'Sweet Mixture', '', '', '', '', '', '10', '50', '0', '0', '500'),
(59, 'VLZc1DHiPW', '1', 'P', '', '', '', '', '', '10', '10', '0', '0', '100'),
(60, 'efwMCWZlUS', '1', 'purchase', '', '', '', '', '', '100', '80', '0', '0', '8000');

-- --------------------------------------------------------

--
-- Table structure for table `tblsalesinvoices`
--

CREATE TABLE `tblsalesinvoices` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_mobno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_invoice_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `after_discount_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_paid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_received` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_received_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `total_balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsalesinvoices`
--

INSERT INTO `tblsalesinvoices` (`id`, `userID`, `party_name`, `party_mobno`, `sale_invoice_number`, `sale_invoice_date`, `sub_total`, `discount`, `after_discount_total`, `full_paid`, `amount_received`, `amount_received_type`, `total_balance`, `timestamp`) VALUES
(95, 'VLZc1DHiPW', 'Yash', '9487261230', '1', '2024-01-22', '500', '0', '500', 'No', '0', '', '500', '2024-01-22 10:58:53');

--
-- Triggers `tblsalesinvoices`
--
DELIMITER $$
CREATE TRIGGER `timestamp` BEFORE INSERT ON `tblsalesinvoices` FOR EACH ROW BEGIN

SET new.timestamp= CONVERT_TZ(CURRENT_TIME(), '+00:00','+05:30');

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblsalesinvoice_details`
--

CREATE TABLE `tblsalesinvoice_details` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_invoice_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ItemName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HSN` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BatchNo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ExpireDate` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ManufactureDate` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Qty` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Price` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Discount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Tax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsalesinvoice_details`
--

INSERT INTO `tblsalesinvoice_details` (`id`, `userID`, `sales_invoice_number`, `ItemName`, `HSN`, `BatchNo`, `ExpireDate`, `ManufactureDate`, `Size`, `Qty`, `Price`, `Discount`, `Tax`, `Amount`) VALUES
(85, 'VLZc1DHiPW', '1', 'Milk Rusk', '', '', '', '', '50G', '10', '30', '0', '0', '300'),
(86, 'VLZc1DHiPW', '1', 'butter2', '', '', '', '', '1KG', '1', '200', '0', '0', '200');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubcategory`
--

CREATE TABLE `tblsubcategory` (
  `id` int(11) NOT NULL,
  `userID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsubcategory`
--

INSERT INTO `tblsubcategory` (`id`, `userID`, `category`, `subcat_name`, `status`) VALUES
(1, 'VLZc1DHiPW', 'Cake', 'Plum', '1'),
(2, 'VLZc1DHiPW', 'Ice cream', 'ChocoBar', '0'),
(3, 'VLZc1DHiPW', 'Ice cream', 'ChocoBar', '0'),
(4, 'VLZc1DHiPW', 'Ice cream', 'ChocoBar', '0'),
(5, 'VLZc1DHiPW', 'Ice cream', 'ChocoBar', '1'),
(6, 'VLZc1DHiPW', 'Rusk', 'Milk', '1'),
(7, 'VLZc1DHiPW', 'Butter', 'Sweet', '1'),
(9, 'VLZc1DHiPW', 'Cake', 'Plain', '1'),
(10, 'VLZc1DHiPW', 'Cake', 'Caramel', '1'),
(11, 'VLZc1DHiPW', 'Mixture', 'Sweet', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `userID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `superAdminID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `userID`, `superAdminID`, `branch`, `username`, `password`, `status`) VALUES
(58, 'B2PcBOlBq5', 'VLZc1DHiPW', 'Madanthyar', 'ramesh', 'ramesh123', 1),
(60, 'TlPZ6IJpeX', 'VLZc1DHiPW', 'Nainad', 'akhil', 'akhil123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_admin_unicode` (`unicode`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_branch_userID` (`userID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblcategory_userID` (`userID`);

--
-- Indexes for table `tblparty`
--
ALTER TABLE `tblparty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblparty_userID` (`userID`);

--
-- Indexes for table `tblpaymentin`
--
ALTER TABLE `tblpaymentin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblpaymentIN_userID` (`userID`);

--
-- Indexes for table `tblpaymentout`
--
ALTER TABLE `tblpaymentout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblpaymentOUT_userID` (`userID`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblproducts_userID` (`userID`);

--
-- Indexes for table `tblpurchaseinvoices`
--
ALTER TABLE `tblpurchaseinvoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblpurchaseinvoices_userID` (`userID`);

--
-- Indexes for table `tblpurchaseinvoice_details`
--
ALTER TABLE `tblpurchaseinvoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblpurchaseinvoice_details_userID` (`userID`);

--
-- Indexes for table `tblsalesinvoices`
--
ALTER TABLE `tblsalesinvoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblsalesinvoices_userID` (`userID`);

--
-- Indexes for table `tblsalesinvoice_details`
--
ALTER TABLE `tblsalesinvoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblsalesinvoice_details_userID` (`userID`);

--
-- Indexes for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tblsubcategory_userID` (`userID`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tblparty`
--
ALTER TABLE `tblparty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblpaymentin`
--
ALTER TABLE `tblpaymentin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblpaymentout`
--
ALTER TABLE `tblpaymentout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tblpurchaseinvoices`
--
ALTER TABLE `tblpurchaseinvoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tblpurchaseinvoice_details`
--
ALTER TABLE `tblpurchaseinvoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tblsalesinvoices`
--
ALTER TABLE `tblsalesinvoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tblsalesinvoice_details`
--
ALTER TABLE `tblsalesinvoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
