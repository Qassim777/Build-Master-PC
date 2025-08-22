-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307:3307:3307
-- Generation Time: May 14, 2024 at 10:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `build_master_pc`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `User_UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `User_UserID`) VALUES
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `CartItemsID` int(11) NOT NULL,
  `Cart_CartID` int(11) NOT NULL,
  `Product_ProductID` int(11) NOT NULL,
  `Cart_Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`CartItemsID`, `Cart_CartID`, `Product_ProductID`, `Cart_Quantity`) VALUES
(1, 1, 33, 4);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(11) NOT NULL,
  `User_UserID` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Total_Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `DetailsID` int(11) NOT NULL,
  `Order_OrderID` int(11) NOT NULL,
  `Product_ProductID` int(11) NOT NULL,
  `Details_Quantity` int(11) NOT NULL,
  `Details_Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `Order_OrderID` int(11) NOT NULL,
  `PaymentDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `PaymentAmount` decimal(10,2) NOT NULL,
  `PaymentMethod` enum('Visa','Master card','Mada') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `Pro_Name` longtext NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `product_type` enum('PC','Accessory','CPU','Motherboard','CPU fan','CPU cooling','GPU','RAM','HDD','SSD','M.2','Power supply','case') NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `Pro_Name`, `Price`, `Quantity`, `product_type`, `picture`) VALUES
(1, 'WD Blue 1TB', 100.00, 10, 'HDD', 'HDD_WD_1TB.png'),
(2, 'WD Blue 2TB', 300.00, 10, 'HDD', 'HDD_WD_2TB.png'),
(3, 'WD Purple 3TB', 400.00, 10, 'HDD', 'HDD_WD_3TB.png'),
(4, 'Intel Core i9', 1000.00, 10, 'CPU', 'i9.png'),
(5, 'Intel Core i7', 850.00, 10, 'CPU', 'i7.png'),
(6, 'Intel Core i5', 650.00, 10, 'CPU', 'i5.png'),
(7, 'Asus Rog Strig', 1000.00, 10, 'Motherboard', 'Motherboard_rog_strig_asus.png'),
(8, 'MSI B450M', 1100.00, 10, 'Motherboard', 'Motherboard2_msi_b450m.png'),
(9, 'Asus Prime H510M', 1590.00, 10, 'Motherboard', 'Motherboard3_h510m.png'),
(11, 'Crucial M.2 1TB', 1000.00, 10, 'M.2', 'M2_crucial.png'),
(12, 'Samsung M.2 2TB', 1560.00, 10, 'M.2', 'M2_samsung_2tb.png'),
(13, 'WD M.2 1TB', 1235.00, 10, 'M.2', 'M2_wd_1tb.png'),
(14, 'Corsair 16GB DDR5', 450.00, 10, 'RAM', 'RAM1_corsair.png'),
(15, 'TForce 32GB DDR5', 700.00, 10, 'RAM', 'RAM2_tforce.png'),
(16, 'RTX 4090 16GB', 10000.00, 10, 'GPU', 'RTX_4090.png'),
(18, 'RTX 4070 8GB', 2450.00, 10, 'GPU', 'RTX_4070.png'),
(19, 'Corsair 750RM', 950.00, 10, 'Power supply', 'Power1_corsair.png'),
(20, 'Corsair CX650', 990.00, 5, 'Power supply', 'Power2_650.png'),
(21, 'Sandisk 1TB SSD', 400.00, 10, 'SSD', 'SSD2_sandisk.png'),
(22, 'Kingston 2TB SSD', 850.00, 5, 'SSD', 'SSD1_kingston.png'),
(24, 'NZXT Kraken Cooling', 1050.00, 4, 'CPU cooling', 'NZXT_kraken_cooling.png'),
(25, 'MiChoice Cooling', 1222.00, 10, 'CPU cooling', 'Michoice_cooling.png'),
(26, 'NZXT H9 Flow', 670.00, 10, 'case', 'Case1.png'),
(27, 'Xlian Li X9', 680.00, 5, 'case', 'Case2.png'),
(28, 'PowerKrak CPU Fan', 345.00, 5, 'CPU fan', 'Fan1.png'),
(29, 'Corsair CPU Fan', 350.00, 5, 'CPU fan', 'Fan2.png'),
(30, 'CazaSouq Mouse RGB', 200.00, 10, 'Accessory', 'Mouse.png'),
(31, 'Corsair TM30 Thermal paste', 100.00, 10, 'Accessory', 'Thermal Paste.png'),
(32, 'Corsair CS30 RGB ', 400.00, 10, 'Accessory', 'keyboard.png'),
(33, 'i9 RTX4090 32GB RAM', 5690.00, 5, 'PC', 'PC1.png'),
(34, 'i5 RTX 4070 16GB', 4500.00, 5, 'PC', 'PC2.png'),
(35, 'i7 RTX 4080 32GB RAM', 5500.00, 5, 'PC', 'PC3.png');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewsID` int(11) NOT NULL,
  `Product_ProductID` int(11) NOT NULL,
  `User_UserID` int(11) NOT NULL,
  `Rating` enum('1','2','3','4','5') NOT NULL,
  `Review_text` text NOT NULL,
  `Review_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewsID`, `Product_ProductID`, `User_UserID`, `Rating`, `Review_text`, `Review_Date`) VALUES
(4, 33, 4, '1', 'szdfdd', '2024-05-14 15:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `shippingdetails`
--

CREATE TABLE `shippingdetails` (
  `ShippingDetailsID` int(11) NOT NULL,
  `Order_OrderID` int(11) NOT NULL,
  `ShippingAddress` text NOT NULL,
  `ShippingMethod` text NOT NULL,
  `ShippingCost` decimal(10,2) NOT NULL,
  `TrackingNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specifications`
--

CREATE TABLE `specifications` (
  `SpecificationsID` int(11) NOT NULL,
  `Product_ProductID` int(11) NOT NULL,
  `Speci_Name` text NOT NULL,
  `Speci_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specifications`
--

INSERT INTO `specifications` (`SpecificationsID`, `Product_ProductID`, `Speci_Name`, `Speci_value`) VALUES
(2, 1, 'Digital storage capacity', '1 TB'),
(3, 1, 'Hard disk interface', 'ATA'),
(4, 1, 'Connectivity technology', 'SATA'),
(5, 1, 'Brand', 'Western Digital'),
(6, 1, 'Special features', 'Portable'),
(7, 1, 'Hard disk form factor', '3.5 Inches'),
(8, 1, 'Hard disk description', 'Mechanical Hard Disk'),
(9, 1, 'Compatible devices', 'Desktop'),
(10, 2, 'Digital storage capacity', '2000 GB'),
(11, 2, 'Hard disk interface', 'Serial ATA-600'),
(12, 2, 'Connectivity technology', 'SATA'),
(13, 2, 'Brand', 'Western Digital'),
(14, 2, 'Special features', 'Compact'),
(15, 2, 'Hard disk form factor', '3.5 Inches'),
(16, 2, 'Hard disk description', 'Mechanical Hard Disk'),
(17, 2, 'Compatible devices', 'PC, Gaming Console, Desktop'),
(18, 3, 'Digital storage capacity', '3000 GB'),
(19, 3, 'Hard disk interface', 'Serial ATA-600'),
(20, 3, 'Connectivity technology', 'SATA'),
(21, 3, 'Brand', 'Western Digital'),
(22, 3, 'Special features', 'Compact'),
(23, 3, 'Hard disk form factor', '3.5 Inches'),
(24, 3, 'Hard disk description', 'Mechanical Hard Disk'),
(25, 3, 'Compatible devices', 'PC, Gaming Console, Desktop'),
(26, 3, 'Installation type', 'Internal Hard Drive'),
(27, 4, 'Brand', 'Intel'),
(28, 4, 'CPU manufacturer', 'Intel'),
(29, 4, 'CPU model', 'Core i9'),
(30, 4, 'CPU speed', '6'),
(31, 4, 'CPU socket', 'LGA 771'),
(32, 4, 'Platform', 'Windows 11'),
(33, 4, 'Secondary cache', '128 MB'),
(34, 4, 'Wattage', '250'),
(35, 5, 'Style', 'Processor Only'),
(36, 5, 'Brand', 'Intel'),
(37, 5, 'CPU manufacturer', 'Intel'),
(38, 5, 'CPU speed', '3'),
(39, 5, 'CPU socket', 'LGA 1700'),
(40, 5, 'Platform', 'Windows'),
(41, 5, 'Secondary cache', '11 MB'),
(42, 5, 'Wattage', '125 watts'),
(43, 5, 'Cache size', '25'),
(44, 6, 'Brand', 'Intel'),
(45, 6, 'CPU manufacturer', 'Intel'),
(46, 6, 'CPU speed', '4.4 GHz'),
(47, 6, 'CPU socket', 'LGA 1150'),
(48, 6, 'Platform', 'Windows 11, Windows 10'),
(49, 6, 'Secondary cache', '18 MB'),
(50, 6, 'Wattage', '65 watts'),
(51, 6, 'Cache size', '18'),
(52, 7, 'Size', 'ATX'),
(53, 7, 'Style', 'B550-A GAMING'),
(54, 7, 'Brand', 'Asus'),
(55, 7, 'CPU socket', 'LGA 2011'),
(56, 7, 'Compatible devices', 'Desktop PC'),
(57, 7, 'Ram memory technology', 'DDR4'),
(58, 7, 'Compatible processors', 'Socket AM4: Pronto per i processori AMD Ryzen™ di terza generazione'),
(59, 7, 'Chipset type', 'AMD X570'),
(60, 7, 'Memory clock speed', '2133 MHz'),
(61, 7, 'Platform', 'Windows 10'),
(62, 7, 'Model name', '90MB15J0-M0EAY0'),
(63, 7, 'Memory storage capacity', '128 GB'),
(64, 8, 'Brand', 'MSI'),
(65, 8, 'CPU socket', 'Socket AM4'),
(66, 8, 'Compatible devices', 'Personal Computer'),
(67, 8, 'Ram memory technology', 'DDR4'),
(68, 8, 'Compatible processors', 'Supports AMD Ryzen 5000, 4000, 3000, 2000, and 1000 Series desktop processor'),
(69, 8, 'Chipset type', 'AMD B450'),
(70, 8, 'Memory clock speed', '4133 MHz'),
(71, 8, 'Platform', 'Windows 11'),
(72, 8, 'Model name', 'B450M-A PRO MAX II'),
(73, 9, 'Brand', 'ASUS'),
(74, 9, 'CPU socket', 'LGA 1151'),
(75, 9, 'Compatible devices', 'Personal Computer'),
(76, 9, 'Ram memory technology', 'DDR4'),
(77, 9, 'Compatible processors', 'Intel Core de 11ª generación'),
(78, 9, 'Chipset type', 'Intel H310'),
(79, 9, 'Memory clock speed', '2666 MHz'),
(80, 9, 'Platform', 'Windows 10'),
(81, 9, 'Model name', 'PRIME H510M-A'),
(89, 7, 'Size', 'ATX'),
(90, 7, 'Style', 'B550-A GAMING'),
(91, 7, 'Brand', 'Asus'),
(92, 7, 'CPU socket', 'LGA 2011'),
(93, 7, 'Compatible devices', 'Desktop PC'),
(94, 7, 'Ram memory technology', 'DDR4'),
(95, 7, 'Compatible processors', 'Socket AM4: Pronto per i processori AMD Ryzen™ di terza generazione'),
(96, 7, 'Chipset type', 'AMD X570'),
(97, 7, 'Memory clock speed', '2133 MHz'),
(98, 7, 'Platform', 'Windows 10'),
(99, 7, 'Model name', '90MB15J0-M0EAY0'),
(100, 7, 'Memory storage capacity', '128 GB'),
(101, 8, 'Brand', 'MSI'),
(102, 8, 'CPU socket', 'Socket AM4'),
(103, 8, 'Compatible devices', 'Personal Computer'),
(104, 8, 'Ram memory technology', 'DDR4'),
(105, 8, 'Compatible processors', 'Supports AMD Ryzen 5000, 4000, 3000, 2000, and 1000 Series desktop processor'),
(106, 8, 'Chipset type', 'AMD B450'),
(107, 8, 'Memory clock speed', '4133 MHz'),
(108, 8, 'Platform', 'Windows 11'),
(109, 8, 'Model name', 'B450M-A PRO MAX II'),
(110, 9, 'Brand', 'ASUS'),
(111, 9, 'CPU socket', 'LGA 1151'),
(112, 9, 'Compatible devices', 'Personal Computer'),
(113, 9, 'Ram memory technology', 'DDR4'),
(114, 9, 'Compatible processors', 'Intel Core de 11ª generación'),
(115, 9, 'Chipset type', 'Intel H310'),
(116, 9, 'Memory clock speed', '2666 MHz'),
(117, 9, 'Platform', 'Windows 10'),
(118, 9, 'Model name', 'PRIME H510M-A'),
(119, 11, 'Digital storage capacity', '1 TB'),
(120, 11, 'Hard disk interface', 'NVMe'),
(121, 11, 'Connectivity technology', 'NVMe'),
(122, 11, 'Brand', 'Crucial'),
(123, 11, 'Special features', 'Compact'),
(124, 11, 'Hard disk form factor', '2.5 Inches'),
(125, 11, 'Hard disk description', 'Solid State Drive'),
(126, 12, 'Digital storage capacity', '2 TB'),
(127, 12, 'Hard disk interface', 'NVMe'),
(128, 12, 'Connectivity technology', 'SATA'),
(129, 12, 'Brand', 'SAMSUNG'),
(130, 12, 'Hard disk form factor', '2.5 Inches'),
(131, 12, 'Hard disk description', 'Solid State Drive'),
(132, 13, 'Capacity', '1TB'),
(133, 13, 'Digital storage capacity', '1000 GB'),
(134, 13, 'Hard disk interface', 'NVMe'),
(135, 13, 'Connectivity technology', 'PCIe'),
(136, 13, 'Brand', 'WD_BLACK'),
(137, 13, 'Special features', 'Game Mode 2.0'),
(138, 13, 'Hard disk form factor', '2.5 Inches'),
(139, 14, 'Brand', 'Corsair'),
(140, 14, 'Computer memory size', '16 GB'),
(141, 14, 'Ram memory technology', 'DDR5'),
(142, 14, 'Memory speed', '5200 MHz'),
(143, 15, 'Brand', 'TEAMGROUP'),
(144, 15, 'Computer memory size', '32 GB'),
(145, 15, 'Ram memory technology', 'DDR5'),
(146, 15, 'Memory speed', '6000 MHz'),
(147, 16, 'Graphics co-processor', 'RTX 4070 Ti SUPER'),
(148, 16, 'Brand', 'Gigabyte'),
(149, 16, 'Graphics RAM size', '16 GB'),
(150, 16, 'GPU clock speed', '2625 MHz'),
(151, 18, 'Graphics co-processor', 'NVIDIA GeForce RTX 4060'),
(152, 18, 'Brand', 'ASUS'),
(153, 18, 'Graphics RAM size', '8 GB'),
(154, 18, 'GPU clock speed', '2535 MHz'),
(155, 19, 'Brand', 'Corsair'),
(156, 19, 'Compatible devices', 'Personal Computer'),
(157, 19, 'Connector type', 'ATX'),
(158, 19, 'Output wattage', '750'),
(159, 20, 'Brand', 'Corsair'),
(160, 20, 'Compatible devices', 'Personal Computer'),
(161, 20, 'Connector type', 'ATX'),
(162, 20, 'Output wattage', '650'),
(163, 20, 'Form factor', 'ATX'),
(164, 21, 'Digital storage capacity', '1 TB'),
(165, 21, 'Hard disk interface', 'Solid State'),
(166, 21, 'Connectivity technology', 'SATA'),
(167, 21, 'Brand', 'SanDisk'),
(168, 22, 'Digital storage capacity', '2 TB'),
(169, 22, 'Hard disk interface', 'ATA'),
(170, 22, 'Connectivity technology', 'SATA'),
(171, 22, 'Brand', 'Kingston'),
(172, 24, 'Product dimensions', '12.1L x 39.4W x 2.7H centimeters'),
(173, 24, 'Brand', 'NZXT'),
(174, 24, 'Power connector type', 'A single breakout cable from pump to motherboard makes for easy installation.'),
(175, 24, 'Voltage', '12 Volts'),
(176, 24, 'Wattage', '2.76 watts'),
(177, 24, 'Cooling method', 'Water'),
(178, 25, 'Brand', 'AMCHOICE'),
(179, 25, 'Power Connector Type', '4-Pin'),
(180, 25, 'Voltage', '12 Volts'),
(181, 25, 'Cooling Method', 'Liquid'),
(182, 26, 'Brand', 'NZXT'),
(183, 26, 'Motherboard compatibility', 'ATX'),
(184, 26, 'Case type', 'Mid Tower'),
(185, 26, 'Recommended uses for product', 'Gaming'),
(186, 27, 'Brand', 'Lian Li'),
(187, 27, 'Motherboard compatibility', 'ATX'),
(188, 27, 'Case type', 'Full Tower'),
(189, 27, 'Recommended uses for product', 'Gaming'),
(190, 28, 'Brand', 'Cooler Master'),
(191, 28, 'Power connector type', '4-Pin'),
(192, 28, 'Voltage', '3 Volts'),
(193, 28, 'Wattage', '3.12 watts'),
(194, 28, 'Cooling method', 'Fan'),
(195, 29, 'Brand', 'Corsair'),
(196, 29, 'Power connector type', '2-Pin'),
(197, 29, 'Voltage', '5 Volts'),
(198, 29, 'Cooling method', 'Water'),
(199, 30, 'Brand', 'Eacam'),
(200, 30, 'Colour', 'White'),
(201, 30, 'Connectivity technology', 'USB'),
(202, 30, 'Special features', 'Ergonomic Design, Rechargeable, LED Lights'),
(203, 31, 'Brand', 'Corsair'),
(204, 31, 'Power connector type', '3-Pin'),
(205, 31, 'Voltage', '220 Volts'),
(206, 31, 'Cooling method', 'Thermal'),
(207, 32, 'Brand', 'Corsair'),
(208, 32, 'Computer memory size', '16 GB'),
(209, 32, 'Ram memory technology', 'DDR4'),
(210, 32, 'Memory speed', '2666 MHz'),
(216, 33, 'CASES', 'NFINIARC CUBE FLOW XL 6 RGB FANS'),
(217, 33, 'MOTHERBOARDS', 'GIGABYTE Z790'),
(218, 33, 'CPU', 'Intel CPU Desktop Core i7-14700KF '),
(219, 33, 'MEMORY', 'TEAMGROUP DELTA RGB DDR5 DESKTOP MEMORY BLACK 16GB(2x8GB) 5200MHz'),
(220, 33, 'GPU', 'ASUS ROG Strix GeForce RTX® 4090 24GB'),
(221, 34, 'CASES', 'NFINIARC CUBE FLOW XL 6 RGB FANS'),
(222, 34, 'MOTHERBOARDS', 'GIGABYTE Z790'),
(223, 34, 'CPU', 'Intel CPU Desktop Core i5-14700KF '),
(224, 34, 'MEMORY', 'TEAMGROUP DELTA RGB DDR5 DESKTOP MEMORY BLACK 16GB(2x8GB) 5200MHz'),
(225, 34, 'GPU', 'ASUS ROG Strix GeForce RTX® 4070 16GB'),
(226, 35, 'CASES', 'NFINIARC CUBE FLOW XL 6 RGB FANS'),
(227, 35, 'MOTHERBOARDS', 'GIGABYTE Z790'),
(228, 35, 'CPU', 'Intel CPU Desktop Core i5-14700KF '),
(229, 35, 'MEMORY', 'TEAMGROUP DELTA RGB DDR5 DESKTOP MEMORY BLACK 32GB(2x16GB) 5200MHz'),
(230, 35, 'GPU', 'ASUS ROG Strix GeForce RTX® 4080 16GB');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `First_Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Is_admin` enum('No','Yes') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `First_Name`, `Email`, `Password`, `Is_admin`) VALUES
(1, 'Fahad', 'I_Fahad_gx_I@hotmail.com', '$2y$10$YSj.IbLpY/MgXK/Hi859DuTJPjkEmxyQA/f4So', 'No'),
(2, 'haider', 'haider@gmail.com', '$2y$10$1/Qd2ZDfxpqMJWCDX0LIveO6eGaEgAVyNNDWqx', 'No'),
(3, 'ahmed', 'ahmed@gmail.com', '$2y$10$33nmTfSUOxpRWJefHorJueiZsVFmbY.IV62INd', 'No'),
(4, 'hussan', 'hussan@gmail.com', '$2y$10$vpXWti7xBVl.WWi7Gs/VBuLxqGms9iHxzTdYL2tyfqxUjwiERYcZ.', 'No'),
(7, 'Admin', 'Admin@Admin.org', '$2y$10$nhuGBRC7EKKWY7Fjcr7/c.aG/X/8hSFSIXtyVcyD4wz/JEUNlKj7O', 'Yes'),
(99, 'hasan', 'ali@gmail.com', '123', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `fk_Cart_User1_idx` (`User_UserID`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`CartItemsID`),
  ADD KEY `fk_CartItems_Cart1_idx` (`Cart_CartID`),
  ADD KEY `fk_CartItems_Product1_idx` (`Product_ProductID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `fk_Order_User1_idx` (`User_UserID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`DetailsID`),
  ADD KEY `fk_Product_has_Order_Product_idx` (`Product_ProductID`),
  ADD KEY `fk_OrderDetails_Order1_idx` (`Order_OrderID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `fk_Payments_Order1_idx` (`Order_OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewsID`),
  ADD KEY `fk_Reviews_Product1_idx` (`Product_ProductID`),
  ADD KEY `fk_Reviews_User1_idx` (`User_UserID`);

--
-- Indexes for table `shippingdetails`
--
ALTER TABLE `shippingdetails`
  ADD PRIMARY KEY (`ShippingDetailsID`),
  ADD KEY `fk_ShippingDetails_Order1_idx` (`Order_OrderID`);

--
-- Indexes for table `specifications`
--
ALTER TABLE `specifications`
  ADD PRIMARY KEY (`SpecificationsID`),
  ADD KEY `fk_Specifications_Product1_idx` (`Product_ProductID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Email_2` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `CartItemsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `DetailsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shippingdetails`
--
ALTER TABLE `shippingdetails`
  MODIFY `ShippingDetailsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specifications`
--
ALTER TABLE `specifications`
  MODIFY `SpecificationsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_Cart_User1` FOREIGN KEY (`User_UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `fk_CartItems_Cart1` FOREIGN KEY (`Cart_CartID`) REFERENCES `cart` (`CartID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_CartItems_Product1` FOREIGN KEY (`Product_ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_Order_User1` FOREIGN KEY (`User_UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `fk_OrderDetails_Order1` FOREIGN KEY (`Order_OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Product_has_Order_Product` FOREIGN KEY (`Product_ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_Payments_Order1` FOREIGN KEY (`Order_OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_Reviews_Product1` FOREIGN KEY (`Product_ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Reviews_User1` FOREIGN KEY (`User_UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shippingdetails`
--
ALTER TABLE `shippingdetails`
  ADD CONSTRAINT `fk_ShippingDetails_Order1` FOREIGN KEY (`Order_OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `specifications`
--
ALTER TABLE `specifications`
  ADD CONSTRAINT `fk_Specifications_Product1` FOREIGN KEY (`Product_ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
