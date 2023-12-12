-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 07:42 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hnsworkshoperp_db5`
--

-- --------------------------------------------------------

--
-- Table structure for table `supplier_opening_balance`
--

CREATE TABLE `supplier_opening_balance` (
  `id` int(6) NOT NULL,
  `COL 1` varchar(12) DEFAULT NULL,
  `COL 2` varchar(11) DEFAULT NULL,
  `COL 3` varchar(40) DEFAULT NULL,
  `COL 4` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier_opening_balance`
--

INSERT INTO `supplier_opening_balance` (`id`, `COL 1`, `COL 2`, `COL 3`, `COL 4`) VALUES
(2, '31-Dec-22', '1347', 'Raiyana Trade International', '99400.00'),
(3, '31-Dec-22', '1231', 'Mamun Auto House', '1500.00'),
(4, '31-Dec-22', '1282', 'Nahar Paint Colour World', '1243471.50'),
(5, '31-Dec-22', '1016', 'Alam Enterptise', '233069.00'),
(6, '31-Dec-22', '1355', 'Rasel Motors', '2295999.99'),
(7, '31-Dec-22', '1335', 'Parts Point', '1500.00'),
(8, '31-Dec-22', '1190', 'M.S Autos', '36599.00'),
(9, '31-Dec-22', '1405', 'Shahin Auto Colour', '2930.00'),
(10, '31-Dec-22', '1401', 'Shafiq Motors', '2000.00'),
(11, '31-Dec-22', '1267', 'Mostafa Automobiles', '1460110.00'),
(12, '31-Dec-22', '1391', 'Santacruz', '255000.00'),
(13, '31-Dec-22', '1002', 'A.C Center', '26100.00'),
(14, '31-Dec-22', '1392', 'Sanwara Motors', '15100.00'),
(15, '31-Dec-22', '1229', 'Mahin Paint Colour World', '105350.00'),
(16, '31-Dec-22', '1298', 'New Brothers Motors', '500'),
(17, '31-Dec-22', '1318', 'Noor Ahmed Radiator Servicing Center', '38650.00'),
(18, '31-Dec-22', '1417', 'Shojib Motors', '149650.00'),
(19, '31-Dec-22', '1108', 'Fantasy Auto Parts', '45700.00'),
(20, '31-Dec-22', '1250', 'MiM Motors', '605'),
(21, '31-Dec-22', '1278', 'Muskan Motors', '71600.00'),
(22, '31-Dec-22', '1067', 'Bhai Bhai Engineering Works', '65232.00'),
(23, '31-Dec-22', '1254', 'Mitu Engineering Works', '79760.00'),
(24, '31-Dec-22', '1450', 'The City Engineering', '650'),
(25, '31-Dec-22', '1130', 'Hassan Enterprise', '171300.00'),
(26, '31-Dec-22', '1113', 'Fuchs+Bismillah Enterprise', '6480.00'),
(27, '31-Dec-22', '1330', 'Padma auto Parts', '5000.00'),
(28, '31-Dec-22', '1382', 'Sajib motors Dholaikhal', '33450.00'),
(29, '31-Dec-22', '1074', 'Bikrampur Motors', '113200.00'),
(30, '31-Dec-22', '1372', 'S.A Motors', '10100.00'),
(31, '31-Dec-22', '1221', 'Maa Engineering Works', '24300.00'),
(32, '31-Dec-22', '1279', 'N.Alam Aircondition', '8000.00'),
(33, '31-Dec-22', '1093', 'Cool Auto air conditioning & Accessories', '5500.00'),
(34, '31-Dec-22', '1423', 'Sinthiha Car Decoration', '220980.00'),
(35, '31-Dec-22', '1136', 'Hoque Corproration', '720'),
(36, '31-Dec-22', '1150', 'J.R Auto Parts', '49260.00'),
(37, '31-Dec-22', '1018', 'Al-Amin Motors', '8000.00'),
(38, '31-Dec-22', '1384', 'Salim Enterprise', '42000.00'),
(39, '31-Dec-22', '1456', 'Tutul Motors', '327700.00'),
(40, '31-Dec-22', '1030', 'ANNY Motors', '19000.00'),
(41, '31-Dec-22', '1162', 'Janata MoTors', '700'),
(42, '31-Dec-22', '1209', 'M/S Siddiq Motor Tailoring', '17700.00'),
(43, '31-Dec-22', '1291', 'Nazzaf BangladeSh', '2800.00'),
(44, '31-Dec-22', '1425', 'Smart Computer & Stationary', '696'),
(45, '31-Dec-22', '1053', 'Aziz Motors', '3300.00'),
(46, '31-Dec-22', '1133', 'Hi-Fi Car Air Condition', '65450.00'),
(47, '31-Dec-22', '1171', 'Jonaki motors', '4550.00'),
(48, '31-Dec-22', '1021', 'Allahar dan Motors parts', '3200.00'),
(49, '31-Dec-22', '1448', 'The city Auto', '320'),
(50, '31-Dec-22', '1435', 'Sultan Auto parts', '150'),
(51, '31-Dec-22', '1386', 'Salma & Sayera Motors', '900'),
(52, '31-Dec-22', '1304', 'New Mizan Autos', '500'),
(53, '31-Dec-22', '1406', 'Shahin Car Decoration', '1900.00'),
(54, '31-Dec-22', '1248', 'Milon Auto Parts', '750'),
(55, '31-Dec-22', '1412', 'Shathi Motors', '400'),
(56, '31-Dec-22', '1135', 'HNS Corporation', '1253180.14'),
(57, '31-Dec-22', '1420', 'Siam Motors', '44900.00'),
(58, '31-Dec-22', '1057', 'Babul Car Paint Supply & Colour Bank', '4400.00'),
(59, '31-Dec-22', '1126', 'Hafej Enterprise', '1100.00'),
(60, '31-Dec-22', '1217', 'M/S.Shapon Motors', '600'),
(61, '31-Dec-22', '1348', 'Raj Motors', '222880.00'),
(62, '31-Dec-22', '1312', 'Nishi Hardware', '2440.00'),
(63, '31-Dec-22', '1340', 'R.B Motors', '115200.00'),
(64, '31-Dec-22', '1139', 'IBM Electronics', '3600.00'),
(65, '31-Dec-22', '1431', 'Southern Automobiles', '6190.00'),
(66, '31-Dec-22', '1115', 'Garir Cabi Ghar', '700'),
(67, '31-Dec-22', '1257', 'Modern Hardware Store', '200'),
(68, '31-Dec-22', '1119', 'Grameen Telecom Center', '2450.00'),
(69, '31-Dec-22', '1468', 'Zico Enterprise', '117135.00'),
(70, '31-Dec-22', '1040', 'Ashique Automobiles', '4305.00'),
(71, '31-Dec-22', '1407', 'Shahin Motors', '20000.00'),
(72, '31-Dec-22', '1022', 'Alpha Motors', '671320.00'),
(73, '31-Dec-22', '1252', 'Minhaz Motors', '64200.00'),
(74, '31-Dec-22', '1144', 'Imtiaz Refrigeration', '29000.00'),
(75, '31-Dec-22', '1198', 'M/S Jewel Auto Corporation', '6000.00'),
(76, '31-Dec-22', '1023', 'Al-Razi Automobiles', '55450.00'),
(77, '31-Dec-22', '1075', 'Bikrampur Tyre & Battery Shop', '500'),
(78, '31-Dec-22', '1004', 'A.K. Trade International', '35700.00'),
(79, '31-Dec-22', '1302', 'New Manik Motors', '500'),
(80, '31-Dec-22', '1253', 'Mir Auto Parts', '177500.00'),
(81, '31-Dec-22', '1137', 'Hossain Motors', '143000.00'),
(82, '31-Dec-22', '1104', 'Dubai Auto Parts', '500'),
(83, '31-Dec-22', '1123', 'H.M. Enterprise', '560500.00'),
(84, '31-Dec-22', '1140', 'Ibrahim Engineering', '2400.00'),
(85, '31-Dec-22', '1368', 'Rubel & Ali Auto Parts', '3600.00'),
(86, '31-Dec-22', '1170', 'Jomir Motors', '250'),
(87, '31-Dec-22', '1073', 'Bhuiyan Motors', '12900.00'),
(88, '31-Dec-22', '1324', 'One Plus Auto', '1200.00'),
(89, '31-Dec-22', '1387', 'Salman Motors', '548300.00'),
(90, '31-Dec-22', '1349', 'Rajib Motors', '419000.00'),
(91, '31-Dec-22', '1213', 'M/S. Faysal Decoration', '2500.00'),
(92, '31-Dec-22', '1006', 'Abdul Barek Clutch Plate Repairing', '9500.00'),
(93, '31-Dec-22', '1285', 'Nasir Auto Parts', '1800.00'),
(94, '31-Dec-22', '1195', 'M/S Eastern Engineering Works', '49990.00'),
(95, '31-Dec-22', '1273', 'Multibrand Mitsubishi Auto', '46400.00'),
(96, '31-Dec-22', '1319', 'Noor Automobile', '1800.00'),
(97, '31-Dec-22', '1272', 'Multibrand Auto Parts', '4000.00'),
(98, '31-Dec-22', '1174', 'K.B. Auto Parts', '34300.00'),
(99, '31-Dec-22', '1277', 'Mursheder Dan Automobiles', '17500.00'),
(100, '31-Dec-22', '1258', 'Mohakhali Motors', '95160.00'),
(101, '31-Dec-22', '1233', 'Mamun Brothers Auto Workshop', '6500.00'),
(102, '31-Dec-22', '1146', 'Irfan Motors', '160'),
(103, '31-Dec-22', '1155', 'Jakir Motors', '200'),
(104, '31-Dec-22', '1031', 'Anowar Clutch Plate & Motor Parts', '11500.00'),
(105, '31-Dec-22', '1460', 'Uzzal Enterprise', '279700.00'),
(106, '31-Dec-22', '1441', 'Tahera Auto House', '133400.00'),
(107, '31-Dec-22', '1078', 'Bismillah Engineering Workshop', '1200.00'),
(108, '31-Dec-22', '1050', 'Ayub Enterprise', '15000.00'),
(109, '31-Dec-22', '1286', 'Navana Limited', '2200.00'),
(110, '31-Dec-22', '1091', 'City Auto Colour Bank', '6000.00'),
(111, '31-Dec-22', '1365', 'RSK Business', '3780.00'),
(112, '31-Dec-22', '1482', 'M/S Mahbub Motors', '33500.00'),
(113, '31-Dec-22', '1500', 'Tamim Motors', '2000.00'),
(114, '31-Dec-22', '1549', 'Abir Motors', '13500.00'),
(115, '31-Dec-22', '1477', 'New Padma Autos', '42000.00'),
(116, '31-Dec-22', '1560', 'Rony Rubber Manufacturing & Machine', '240'),
(117, '31-Dec-22', '1474', 'Afia Motors', '30900.00'),
(118, '31-Dec-22', '1481', 'M/S New Prime Motors Jamuna Lubricants', '22900.00'),
(119, '31-Dec-22', '1568', 'A.M. Automobiles', '4000.00'),
(120, '31-Dec-22', '1470', 'Shobuj Motors', '407140.00'),
(121, '31-Dec-22', '1520', 'Kai Project Management Services Ltd', '28656.00'),
(122, '31-Dec-22', '1569', 'Dhaka Autos', '1000.00'),
(123, '31-Dec-22', '1570', 'Sun Power', '900'),
(124, '31-Dec-22', '1571', 'Ayon Motors', '7300.00'),
(125, '31-Dec-22', '1572', 'M.R Watch & Electronics', '300'),
(126, '31-Dec-22', '1480', 'Impex Energy Ltd', '59568.00'),
(127, '31-Dec-22', '1573', 'Sagor Auto Center', '140000.00'),
(128, '31-Dec-22', '1574', 'Lucky Enterprise', '4000.00'),
(129, '31-Dec-22', '1575', 'M.R Traders', '6000.00'),
(130, '31-Dec-22', '1436', 'Sumon Motors', '4500.00'),
(131, '31-Dec-22', '1378', 'Safegu@rd Bangladesh', '46200.00'),
(132, '31-Dec-22', '1080', 'Bismillah Motors', '437800.00'),
(133, '31-Dec-22', '1364', 'Rocky\'s Auto Ltd', '10000.00'),
(134, '31-Dec-22', '1090', 'Chuk Al Makka Engineering Works', '64160.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `supplier_opening_balance`
--
ALTER TABLE `supplier_opening_balance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `supplier_opening_balance`
--
ALTER TABLE `supplier_opening_balance`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
