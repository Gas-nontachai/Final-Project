-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2024 at 06:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked`
--

CREATE TABLE `booked` (
  `id_booked` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการจองแบบเรียบร้อยแล้ว',
  `booking_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'รหัสการจอง',
  `member_id` int(6) UNSIGNED DEFAULT NULL COMMENT 'รหัสลูกค้า',
  `booking_amount` varchar(45) NOT NULL,
  `total_price` varchar(45) NOT NULL,
  `product_type` int(11) NOT NULL,
  `sub_product_type` int(11) NOT NULL,
  `booking_status` int(3) UNSIGNED NOT NULL COMMENT 'สถานะการจอง',
  `booking_type` varchar(20) NOT NULL,
  `zone_id` int(3) UNSIGNED NOT NULL COMMENT 'รหัสประเภทโซน',
  `slip_img` varchar(45) DEFAULT NULL COMMENT 'log',
  `booking_date` datetime DEFAULT NULL COMMENT 'วันเวลาที่จอง',
  `booked_lock_number` text DEFAULT NULL COMMENT 'เลขล็อคที่จะได้',
  `expiration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `booked`
--

INSERT INTO `booked` (`id_booked`, `booking_id`, `member_id`, `booking_amount`, `total_price`, `product_type`, `sub_product_type`, `booking_status`, `booking_type`, `zone_id`, `slip_img`, `booking_date`, `booked_lock_number`, `expiration_date`) VALUES
(0000000001, 4, NULL, '1', '100', 4, 25, 6, '', 22, '', '2024-08-18 06:10:30', NULL, NULL),
(0000000009, 7, 6, '2', '100', 4, 23, 4, '', 22, NULL, '2024-08-18 06:10:30', 'C1, C2', '2024-08-07 23:40:58'),
(0000000013, 3, NULL, '1', '50', 3, 21, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A1', '2024-08-07 23:40:58'),
(0000000014, 5, NULL, '3', '150', 3, 22, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A2, A3, A4', '2024-08-07 23:40:58'),
(0000000015, 6, 6, '1', '50', 3, 20, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A20', '2024-08-07 23:40:58'),
(0000000016, 9, 6, '3', '150', 3, 20, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A1, A2, A3', '2024-08-07 23:59:58'),
(0000000017, 10, 6, '1', '50', 6, 73, 4, '', 21, NULL, '2024-08-18 06:10:30', 'B1', '2024-08-07 23:59:58'),
(0000000019, 11, 6, '3', '150', 3, 20, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A1, A4, A6', '2024-08-07 23:59:58'),
(0000000020, 12, 6, '3', '150', 3, 20, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A1, A2, A3', '2024-08-07 23:59:58'),
(0000000021, 13, 6, '3', '150', 3, 20, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A1, A2, A3', '2024-08-07 23:59:58'),
(0000000022, 14, 6, '5', '250', 3, 20, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A4, A7, A8', '2024-08-07 23:59:58'),
(0000000023, 8, 6, '3', '3000', 6, 73, 4, '', 21, NULL, '2024-08-18 06:10:30', 'B1, B2, B3', '2024-07-07 23:18:23'),
(0000000024, 15, 6, '2', '100', 3, 20, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A1, A2', '2024-08-07 23:59:58'),
(0000000026, 16, 6, '3', '150', 3, 20, 4, '', 16, NULL, '2024-08-18 06:10:30', 'A1, A2, A3', '2024-08-07 23:59:58'),
(0000000027, 17, 6, '2', '2000', 3, 21, 4, '', 21, NULL, '2024-08-18 06:10:30', 'B1, B2', '2024-07-07 21:31:15'),
(0000000028, 18, 6, '2', '80', 3, 20, 6, '', 28, 'slip_20240809_014836', '2024-08-18 06:10:30', NULL, NULL),
(0000000029, 18, 6, '2', '80', 3, 20, 6, '', 28, 'slip_20240809_014836', '2024-08-18 06:10:30', NULL, NULL),
(0000000030, 20, 6, '2', '80', 3, 125, 6, '', 33, 'slip_20240809_183925', '2024-08-18 06:10:30', NULL, NULL),
(0000000031, 21, 6, '1', '40', 3, 125, 6, '', 33, NULL, '2024-08-18 06:10:30', NULL, NULL),
(0000000032, 22, 6, '1', '40', 4, 85, 6, '', 33, NULL, '2024-08-18 06:10:30', NULL, NULL),
(0000000033, 23, 6, '2', '80', 3, 125, 4, '', 33, NULL, '2024-08-18 06:10:30', 'A1, A2', '2024-08-07 23:59:58'),
(0000000034, 24, 6, '1', '40', 3, 125, 4, '', 33, NULL, '2024-08-18 06:10:30', 'A1', '2024-08-08 23:59:58'),
(0000000035, 25, 6, '1', '40', 3, 125, 4, '', 33, 'slip_20240809_215258', '2024-08-18 06:10:30', 'A1', '2024-08-08 23:59:58'),
(0000000036, 26, 6, '2', '80', 3, 125, 4, '', 33, 'slip_20240809_215422_66b62d9e9080e.jpg', '2024-08-18 06:10:30', 'A1, A2', '2024-08-08 23:59:58'),
(0000000037, 27, 6, '2', '80', 3, 125, 6, '', 33, NULL, '2024-08-18 06:10:30', NULL, NULL),
(0000000038, 29, 6, '3', '120', 3, 125, 6, '', 33, NULL, '2024-08-18 06:10:30', NULL, NULL),
(0000000039, 28, 6, '2', '80', 3, 125, 4, '', 33, 'slip_20240813_200906_66bb5af254f0f.jpg', '2024-08-18 06:10:30', 'A1, A2', '2024-08-13 23:59:58'),
(0000000040, 30, 6, '1', '40', 3, 125, 4, '', 33, 'slip_20240818_200331_66c1f123a617c.jpg', '2024-08-18 06:10:30', 'A1', '2024-08-17 23:59:58'),
(0000000041, 31, 6, '2', '80', 3, 130, 4, '', 33, 'slip_20240818_200740_66c1f21cab86e.jpg', '2024-08-18 06:10:30', 'A1', '2024-08-17 23:59:58'),
(0000000042, 32, 6, '2', '80', 4, 85, 8, 'PerDay', 33, 'slip_20240818_204610_66c1fb22ea87c.jpg', '2024-08-18 07:27:28', NULL, '2024-08-17 21:21:10'),
(0000000043, 33, 6, '1', '40', 7, 95, 8, 'PerDay', 30, 'slip_20240818_213019_66c2057b13e64.jpg', '2024-08-18 07:32:48', NULL, NULL),
(0000000044, 33, 6, '1', '40', 7, 95, 8, 'PerDay', 30, 'slip_20240818_213019_66c2057b13e64.jpg', '2024-08-18 07:35:36', NULL, '2024-08-17 21:32:48'),
(0000000045, 34, 6, '2', '80', 3, 128, 8, 'PerDay', 33, 'slip_20240818_213629_66c206ed36078.jpg', '2024-08-18 07:36:43', NULL, NULL),
(0000000046, 35, 6, '2', '80', 3, 125, 8, 'PerDay', 33, NULL, '2024-08-21 03:40:35', NULL, NULL),
(0000000047, 36, 6, '2', '80', 3, 125, 4, 'PerDay', 33, NULL, '2024-08-21 03:42:16', 'A1, A2', '2024-08-20 23:59:58'),
(0000000048, 37, 6, '1', '40', 8, 107, 4, 'PerDay', 32, 'slip_20240821_185814_66c5d65684f5b.jpg', '2024-08-21 04:55:06', 'D1', '2024-08-20 23:59:58'),
(0000000049, 38, 6, '2', '80', 6, 88, 4, 'PerDay', 29, 'slip_20240821_191614_66c5da8e42b31.jpg', '2024-08-21 05:15:40', 'B1, B2', '2024-08-20 08:00:00'),
(0000000050, 39, 6, '2', '80', 3, 126, 6, 'PerDay', 33, NULL, '2024-08-21 05:19:03', NULL, NULL),
(0000000051, 40, 6, '1', '40', 3, 125, 6, 'PerDay', 33, NULL, '2024-08-21 05:24:07', NULL, NULL),
(0000000052, 41, 6, '1', '40', 7, 97, 4, 'PerDay', 30, NULL, '2024-08-21 05:27:21', 'C1', '2024-08-21 08:00:00'),
(0000000053, 42, 6, '2', '80', 4, 84, 4, 'PerDay', 33, 'slip_20240821_192741_66c5dd3d7698b.jpg', '2024-08-21 05:27:31', 'A1, A2', '2024-08-21 08:00:00'),
(0000000055, 43, 6, '-1', '-40', 8, 110, 6, 'PerDay', 32, NULL, '2024-08-21 05:46:26', NULL, NULL),
(0000000056, 47, 6, '1', '40', 3, 125, 4, 'PerDay', 33, NULL, '2024-08-21 06:47:21', 'A1', '2024-08-22 08:00:00'),
(0000000057, 48, 10, '2', '80', 3, 125, 4, 'PerDay', 33, '', '2024-08-24 03:07:21', 'A1, A2', '2024-08-24 08:00:00'),
(0000000058, 49, 10, '2', '80', 3, 125, 6, 'PerDay', 33, NULL, '2024-08-24 10:02:19', NULL, NULL),
(0000000059, 50, 10, '2', '80', 3, 125, 8, 'PerDay', 33, 'slip_20240825_001912_66ca1610adcef.png', '2024-08-24 10:18:56', NULL, NULL),
(0000000060, 54, 6, '1', '40', 3, 125, 6, 'PerDay', 33, NULL, '2024-09-03 02:13:32', NULL, NULL),
(0000000061, 51, 6, '1', '40', 3, 125, 10, 'PerDay', 33, 'slip_20240903_153229_66d6c99dc54d3.png', '2024-09-03 01:02:25', 'A1', '2024-09-03 08:00:00'),
(0000000062, 56, 6, '3', '120', 3, 125, 10, 'PerDay', 33, 'slip_20240903_231836_66d736dc11250.png', '2024-09-03 09:06:07', 'A1, A2, A3', '2024-09-03 08:00:00'),
(0000000063, 57, 6, '3', '120', 6, 93, 10, 'PerDay', 29, 'slip_20240903_232026_66d7374acd47a.png', '2024-09-03 09:20:15', 'B1', '2024-09-03 08:00:00'),
(0000000065, 58, 6, '3', '120', 4, 84, 10, 'PerDay', 33, 'slip_20240903_232902_66d7394ed982d.png', '2024-09-03 09:28:55', 'A1, A2, A3', '2024-09-03 08:00:00'),
(0000000066, 59, NULL, '2', '80', 3, 125, 10, 'PerDay', 33, 'slip_20240905_170027_66d9813bb5317.png', '2024-09-05 03:00:15', 'A1, A2', '2024-09-05 08:00:00'),
(0000000067, 60, NULL, '2', '80', 6, 93, 10, 'PerDay', 32, 'slip_20240905_173318_66d988eed4246.png', '2024-09-05 03:33:09', 'D1, D2', '2024-09-05 08:00:00'),
(0000000068, 61, NULL, '2', '80', 3, 125, 11, 'PerDay', 33, 'slip_20240905_174626_66d98c026aa65.png', '2024-09-05 03:37:42', 'A1, A2', '2024-09-05 08:00:00'),
(0000000069, 62, NULL, '4', '160', 3, 126, 10, 'PerDay', 33, NULL, '2024-09-04 03:46:20', NULL, NULL),
(0000000071, 63, NULL, '1', '40', 3, 125, 8, 'PerDay', 33, 'slip_20240905_175515_66d98e13a05a4.png', '2024-09-05 03:55:09', NULL, NULL),
(0000000072, 64, NULL, '1', '40', 6, 88, 11, 'PerDay', 29, NULL, '2024-09-05 03:55:49', 'B1', '2024-09-05 08:00:00'),
(0000000073, 65, NULL, '1', '40', 3, 125, 6, 'PerDay', 33, NULL, '2024-09-05 04:11:19', NULL, NULL),
(0000000074, 67, 6, '1', '40', 3, 126, 6, 'PerDay', 33, NULL, '2024-09-05 22:23:15', NULL, NULL),
(0000000075, 71, 6, '3', '120', 3, 125, 6, 'PerDay', 33, NULL, '2024-09-06 02:57:44', NULL, NULL),
(0000000076, 70, 6, '2', '80', 3, 125, 8, 'PerDay', 33, 'slip_20240906_165759_66dad22773b5c.png', '2024-09-06 02:57:35', NULL, NULL),
(0000000077, 68, 6, '1', '40', 3, 125, 8, 'PerDay', 33, 'slip_20240906_170419_66dad3a3c544f.png', '2024-09-06 02:42:51', 'A7', '2024-09-07 08:00:00'),
(0000000078, 66, 6, '1', '40', 3, 126, 11, 'PerDay', 33, 'slip_20240906_115139_66da8a5bb67d2.png', '2024-09-05 21:51:07', 'A1', '2024-09-06 08:00:00'),
(0000000079, 69, 13, '2', '80', 3, 125, 11, 'PerDay', 33, 'slip_20240906_165208_66dad0c8ed937.png', '2024-09-06 02:51:35', 'A2, A3', '2024-09-06 08:00:00'),
(0000000080, 72, 6, '2', '80', 3, 125, 11, 'PerDay', 33, NULL, '2024-09-06 02:59:00', 'A4, A5', '2024-09-06 08:00:00'),
(0000000081, 75, 15, '1', '40', 6, 92, 6, 'PerDay', 29, NULL, '2024-09-06 10:26:45', NULL, NULL),
(0000000082, 76, 14, '5', '5000', 3, 162, 13, 'PerMonth', 29, 'slip_20240907_013608_66db4b98f3acf.jpeg', '2024-09-06 11:35:50', NULL, NULL),
(0000000083, 73, 14, '2', '80', 6, 88, 11, 'PerDay', 29, 'slip_20240907_013329_66db4af93e254.png', '2024-09-06 08:42:09', 'B1, B2', '2024-09-07 08:00:00'),
(0000000084, 77, 16, '1', '40', 3, 161, 13, 'PerDay', 33, 'slip_20240907_155549_66dc15151c0f3.png', '2024-09-07 01:48:30', NULL, NULL),
(0000000085, 80, 16, '2', '80', 4, 84, 6, 'PerDay', 33, NULL, '2024-09-07 04:10:27', NULL, NULL),
(0000000086, 81, 16, '2', '80', 3, 161, 8, 'PerDay', 33, 'slip_20240908_114357_66dd2b8d52a6f.png', '2024-09-07 21:43:47', NULL, NULL),
(0000000087, 82, 16, '2', '80', 8, 168, 12, 'PerDay', 33, NULL, '2024-09-07 21:44:07', NULL, NULL),
(0000000088, 83, 16, '1', '40', 7, 98, 12, 'PerDay', 33, NULL, '2024-09-07 22:27:42', NULL, NULL),
(0000000089, 78, 16, '3', '120', 3, 162, 11, 'PerDay', 33, NULL, '2024-09-07 02:25:17', 'A1, A2, A3', '2024-09-08 08:00:00'),
(0000000090, 79, 16, '2', '80', 3, 161, 11, 'PerDay', 33, 'slip_20240907_180929_66dc3469139d7.png', '2024-09-07 04:07:00', 'A4, A5', '2024-09-08 08:00:00'),
(0000000091, 84, 15, '2', '80', 4, 85, 10, 'PerDay', 33, NULL, '2024-09-08 04:08:32', NULL, NULL),
(0000000092, 86, 17, '1', '1000', 4, 85, 8, 'PerMonth', 33, 'slip_20240909_095107_66de629b4e70c.mp4', '2024-09-08 19:50:45', NULL, NULL),
(0000000093, 89, 18, '7', '7000', 4, 87, 8, 'PerMonth', 33, 'slip_20240909_095801_66de643982ab0.png', '2024-09-08 19:57:48', NULL, NULL),
(0000000094, 93, 20, '500', '20000', 3, 161, 12, 'PerDay', 33, NULL, '2024-09-10 07:40:20', NULL, NULL),
(0000000095, 99, 24, '40', '1600', 4, 84, 13, 'PerDay', 33, 'slip_20240910_223446_66e0671688c03.jpg', '2024-09-10 08:31:06', NULL, NULL),
(0000000096, 102, 6, '2', '100', 8, 192, 12, 'PerDay', 36, NULL, '2024-09-10 08:34:21', NULL, NULL),
(0000000097, 107, 15, '1', '40', 4, 84, 6, 'PerDay', 29, NULL, '2024-09-10 11:11:25', NULL, NULL),
(0000000098, 91, 15, '1', '40', 3, 161, 4, 'PerDay', 33, 'slip_20240911_015651_66e0967333a62.jfif', '2024-09-09 04:35:25', 'A12', '2024-09-10 08:00:00'),
(0000000099, 105, 20, '5', '200', 6, 0, 10, 'PerDay', 29, NULL, '2024-09-10 08:46:31', NULL, NULL),
(0000000101, 92, 19, '2', '80', 3, 161, 11, 'PerDay', 33, 'slip_20240910_150900_66dffe9c591e3.png', '2024-09-10 01:08:45', 'A1, A2', '2024-09-10 08:00:00'),
(0000000102, 94, 21, '1', '40', 7, 97, 11, 'PerDay', 30, 'slip_20240910_214805_66e05c254140e.jpeg', '2024-09-10 07:41:12', 'C3', '2024-09-10 08:00:00'),
(0000000103, 96, 22, '2', '80', 3, 163, 11, 'PerDay', 33, 'slip_20240910_215721_66e05e519e75d.jpg', '2024-09-10 07:51:04', 'A3, A4', '2024-09-10 08:00:00'),
(0000000104, 97, 22, '2', '80', 3, 162, 11, 'PerDay', 33, 'slip_20240910_215740_66e05e64866cd.jpg', '2024-09-10 07:54:15', 'A5, A6', '2024-09-10 08:00:00'),
(0000000105, 98, 23, '1', '40', 3, 165, 11, 'PerDay', 33, 'slip_20240910_223648_66e06790a2705.jpg', '2024-09-10 08:25:56', 'A7', '2024-09-10 08:00:00'),
(0000000106, 101, 23, '1', '40', 3, 165, 11, 'PerDay', 33, 'slip_20240910_224511_66e069879cec7.jpg', '2024-09-10 08:33:59', 'A8', '2024-09-10 08:00:00'),
(0000000107, 106, 20, '3', '120', 3, 162, 11, 'PerDay', 33, 'slip_20240910_225125_66e06afd923f0.png', '2024-09-10 08:51:07', 'A9, A10, A11', '2024-09-10 08:00:00'),
(0000000108, 108, 15, '2', '80', 6, 92, 11, 'PerDay', 29, 'slip_20240911_015742_66e096a6e92af.jfif', '2024-09-10 11:12:26', 'B3, B4', '2024-09-10 08:00:00'),
(0000000109, 109, 15, '2', '80', 6, 92, 11, 'PerDay', 29, 'slip_20240911_015822_66e096cedc625.jfif', '2024-09-10 11:13:34', 'B1, B2', '2024-09-10 08:00:00'),
(0000000116, 85, 17, '1', '1000', 3, 163, 4, 'PerMonth', 33, 'slip_20240909_094815_66de61ef23b2b.png', '2024-09-08 19:46:55', 'A20', '2024-09-08 23:59:58'),
(0000000117, 88, 18, '3', '3000', 8, 188, 4, 'PerMonth', 33, 'slip_20240909_095620_66de63d4801c3.png', '2024-09-08 19:55:46', 'A17, A18, A19', '2024-09-08 23:59:58'),
(0000000118, 90, 19, '2', '2000', 7, 97, 11, 'PerMonth', 30, 'slip_20240909_111527_66de765f1589f.png', '2024-09-08 21:13:09', 'C1, C2', '0000-00-00 00:00:00'),
(0000000119, 110, 19, '2', '80', 3, 161, 11, 'PerDay', 33, 'slip_20240911_160531_66e15d5b87390.png', '2024-09-11 16:05:20', 'A1, A2', '2024-09-11 08:00:00'),
(0000000120, 111, 25, '1', '40', 8, 193, 11, 'PerDay', 30, 'slip_20240912_111006_66e2699ed31f4.jpg', '2024-09-12 11:09:25', 'C1', '2024-09-11 08:00:00'),
(0000000122, 112, 19, '1', '40', 3, 161, 11, 'PerDay', 33, 'slip_20240912_130811_66e2854b79aaf.png', '2024-09-12 13:07:31', 'A20', '2024-09-11 23:59:58'),
(0000000123, 113, 19, '1', '1000', 3, 161, 11, 'PerMonth', 33, 'slip_20240912_130821_66e2855508d09.png', '2024-09-12 13:07:40', 'A1', '2024-09-11 23:59:58'),
(0000000124, 114, 6, '1', '40', 4, 84, 11, 'PerDay', 33, 'slip_20240912_233003_66e3170b337b5.png', '2024-09-12 23:29:25', 'A1', '2024-09-11 23:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการจอง',
  `member_id` int(6) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'รหัสลูกค้า',
  `booking_status` int(3) UNSIGNED DEFAULT NULL COMMENT 'สถานะการจอง',
  `booking_type` varchar(20) NOT NULL COMMENT 'รายวัน, รายเดือน',
  `zone_id` int(3) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'รหัสประเภทโซน',
  `booking_amount` int(11) NOT NULL COMMENT 'จำนวนล็อคที่จะจอง',
  `total_price` float NOT NULL COMMENT 'ราคารวม',
  `product_type` int(11) DEFAULT NULL COMMENT 'ประเภทสินค้า',
  `sub_product_type` int(11) NOT NULL,
  `slip_img` varchar(45) DEFAULT NULL,
  `book_lock_number` text DEFAULT NULL,
  `booking_date` datetime DEFAULT NULL COMMENT 'วันเวลาที่จอง',
  `expiration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_status`
--

CREATE TABLE `booking_status` (
  `id` int(3) UNSIGNED NOT NULL COMMENT 'รหัสสถานะการจอง',
  `status` varchar(50) NOT NULL COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `booking_status`
--

INSERT INTO `booking_status` (`id`, `status`) VALUES
(1, 'ยืนยันการจอง(ยังไม่ชำระเงิน)'),
(2, 'ชำระเงินแล้ว(รอตรอจสอบการชำระเงิน)'),
(3, 'ชำระเงินแล้ว(รอรับเลขล็อค)'),
(4, 'ได้รับเลขล็อคแล้ว'),
(5, 'ส่งคำขอยกเลิกแล้ว'),
(6, 'ยกเลิก'),
(7, 'ส่งคำขอขอคืนเงินแล้ว'),
(8, 'คืนเงินเรียบร้อยแล้ว'),
(9, 'ชำระเงินผ่านเหรียญแล้ว(รอรับเลขล็อค)'),
(10, 'ยกเลิกคำขอเนื่องจากคำขอหมดอายุ'),
(11, 'หมดอายุการจอง'),
(12, 'ยกเลิก(ประเภทสินค้าไม่สอดล้องกับโซน)'),
(13, 'คืนเงินเรียบร้อยแล้ว(ประเภทสินค้าไม่สอดคล้องกับโซน');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `cat_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `cat_name`) VALUES
(3, 'อาหาร'),
(4, 'เครื่องดื่ม'),
(6, 'เสื้อผ้าและแฟชั่น'),
(7, 'จิปาถะ เบ็ดเตล็ด'),
(8, 'เปิดท้ายของมือสอง');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `comment`, `rating`, `created_at`) VALUES
(1, 6, 'ดีมากๆงับ', 5, '2024-08-16 13:48:42'),
(12, 13, 'ดีมากๆ', 5, '2024-09-06 09:54:36'),
(13, 14, 'ตลาดบริการดีมากๆเลยค่ะ จัดสรรล็อคได้ดีมากๆ', 5, '2024-09-06 15:51:54'),
(14, 16, 'ดีมากๆงับ', 5, '2024-09-07 09:38:41'),
(15, 17, 'ดีครับ ใช้งานง่าย', 5, '2024-09-09 02:49:24'),
(16, 18, 'ดีมากคราฟพี่ชาย', 4, '2024-09-09 02:58:56'),
(17, 19, 'พี่ว่าดี ผมก็ว่าดีงับ', 5, '2024-09-10 07:42:17'),
(18, 22, 'เพิ่มระบบนำทางและเพิ่มสีสัน', 5, '2024-09-10 15:25:24'),
(19, 22, 'มีคลิปแนะนำการใช้งานสำหรับผู้สูงอายุ', 5, '2024-09-10 15:26:04'),
(20, 15, 'ดีไซน์สวยใช้งานง่าย', 5, '2024-09-10 18:16:16'),
(21, 25, 'Very good', 5, '2024-09-12 04:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `locks`
--

CREATE TABLE `locks` (
  `id_locks` int(11) NOT NULL COMMENT 'ไอดีล็อค',
  `lock_name` varchar(10) NOT NULL COMMENT 'ชื่อเลขล็อต',
  `zone_id` int(3) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'รหัสประเภทโซน',
  `booking_id` int(10) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'รหัสการจอง',
  `available` int(3) DEFAULT NULL COMMENT 'สถานะ ว่าง หรือ จองแล้ว '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `locks`
--

INSERT INTO `locks` (`id_locks`, `lock_name`, `zone_id`, `booking_id`, `available`) VALUES
(537, 'B1', 029, NULL, 0),
(538, 'B2', 029, NULL, 0),
(539, 'B3', 029, NULL, 0),
(540, 'B4', 029, NULL, 0),
(541, 'B5', 029, NULL, 0),
(542, 'B6', 029, NULL, 0),
(543, 'B7', 029, NULL, 0),
(544, 'B8', 029, NULL, 0),
(545, 'B9', 029, NULL, 0),
(546, 'B10', 029, NULL, 0),
(547, 'B11', 029, NULL, 0),
(548, 'B12', 029, NULL, 0),
(549, 'B13', 029, NULL, 0),
(550, 'B14', 029, NULL, 0),
(551, 'B15', 029, NULL, 0),
(552, 'B16', 029, NULL, 0),
(553, 'B17', 029, NULL, 0),
(554, 'B18', 029, NULL, 0),
(555, 'B19', 029, NULL, 0),
(556, 'B20', 029, NULL, 0),
(557, 'C1', 030, NULL, 0),
(558, 'C2', 030, NULL, 0),
(559, 'C3', 030, NULL, 0),
(560, 'C4', 030, NULL, 0),
(561, 'C5', 030, NULL, 0),
(562, 'C6', 030, NULL, 0),
(563, 'C7', 030, NULL, 0),
(564, 'C8', 030, NULL, 0),
(565, 'C9', 030, NULL, 0),
(566, 'C10', 030, NULL, 0),
(567, 'C11', 030, NULL, 0),
(568, 'C12', 030, NULL, 0),
(569, 'C13', 030, NULL, 0),
(570, 'C14', 030, NULL, 0),
(571, 'C15', 030, NULL, 0),
(572, 'C16', 030, NULL, 0),
(573, 'C17', 030, NULL, 0),
(574, 'C18', 030, NULL, 0),
(575, 'C19', 030, NULL, 0),
(576, 'C20', 030, NULL, 0),
(617, 'A1', 033, NULL, 0),
(618, 'A2', 033, NULL, 0),
(619, 'A3', 033, NULL, 0),
(620, 'A4', 033, NULL, 0),
(621, 'A5', 033, NULL, 0),
(622, 'A6', 033, NULL, 0),
(623, 'A7', 033, NULL, 0),
(624, 'A8', 033, NULL, 0),
(625, 'A9', 033, NULL, 0),
(626, 'A10', 033, NULL, 0),
(627, 'A11', 033, NULL, 0),
(628, 'A12', 033, NULL, 0),
(629, 'A13', 033, NULL, 0),
(630, 'A14', 033, NULL, 0),
(631, 'A15', 033, NULL, 0),
(632, 'A16', 033, NULL, 0),
(633, 'A17', 033, NULL, 0),
(634, 'A18', 033, NULL, 0),
(635, 'A19', 033, NULL, 0),
(636, 'A20', 033, NULL, 0),
(667, 'D1', 036, NULL, 0),
(668, 'D2', 036, NULL, 0),
(669, 'D3', 036, NULL, 0),
(670, 'D4', 036, NULL, 0),
(671, 'D5', 036, NULL, 0),
(672, 'D6', 036, NULL, 0),
(673, 'D7', 036, NULL, 0),
(674, 'D8', 036, NULL, 0),
(675, 'D9', 036, NULL, 0),
(676, 'D10', 036, NULL, 0),
(677, 'D11', 036, NULL, 0),
(678, 'D12', 036, NULL, 0),
(679, 'D13', 036, NULL, 0),
(680, 'D14', 036, NULL, 0),
(681, 'D15', 036, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `operating_hours`
--

CREATE TABLE `operating_hours` (
  `id` int(11) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operating_hours`
--

INSERT INTO `operating_hours` (`id`, `opening_time`, `closing_time`) VALUES
(1, '09:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `idsub_category` int(11) NOT NULL,
  `id_category` int(11) DEFAULT NULL,
  `sub_cat_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`idsub_category`, `id_category`, `sub_cat_name`) VALUES
(84, 4, 'น้ำดื่ม'),
(85, 4, 'น้ำผลไม้'),
(86, 4, 'เครื่องดื่มสมุนไพร'),
(87, 4, 'เครื่องดื่มมีแอลกอฮอล์'),
(88, 6, 'เสื้อผ้าผู้หญิง'),
(89, 6, 'เสื้อผ้าผู้ชาย'),
(90, 6, 'เสื้อผ้าเด็ก'),
(91, 6, 'แฟชั่นตามฤดูกาล'),
(92, 6, 'แฟชั่นสไตล์'),
(93, 6, 'เครื่องประดับ'),
(94, 7, 'ของสะสม'),
(95, 7, 'ของที่ระลึก'),
(96, 7, 'ของตกแต่ง'),
(97, 7, 'อุปกรณ์การเขียน'),
(98, 7, 'เครื่องใช้ในบ้าน'),
(99, 7, 'อุปกรณ์เทคโนโลยี'),
(100, 7, 'ของขวัญและของที่ระลึก'),
(161, 3, 'อาหารคาว'),
(162, 3, 'อาหารหวาน'),
(163, 3, 'อาหารทานเล่น'),
(164, 3, 'อาหารเช้า'),
(165, 3, 'อาหารเพื่อสุขภาพ'),
(166, 3, 'อาหารจานเดียว'),
(187, 8, 'เสื้อผ้าและเครื่องแต่งกาย'),
(188, 8, 'ของใช้ในบ้าน'),
(189, 8, 'ของเล่นและเกม'),
(190, 8, 'หนังสือและสื่อบันเทิง'),
(191, 8, 'อุปกรณ์กีฬา'),
(192, 8, 'ของสะสม'),
(193, 8, 'อุปกรณ์อิเล็กทรอนิกส์'),
(194, 8, 'สินค้าทำมือ'),
(195, 8, '(Handmade)');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสลูกค้า',
  `prefix` enum('นาย','นาง','นางสาว') NOT NULL COMMENT 'คำนำหน้าชื่อ',
  `firstname` varchar(255) NOT NULL COMMENT 'ชื่อ',
  `lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `tel` varchar(11) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `email` varchar(255) NOT NULL COMMENT 'อีเมลล์',
  `username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `userrole` int(3) NOT NULL COMMENT '1=ลูกค้า,2=แอดมิน',
  `shop_name` varchar(50) NOT NULL COMMENT 'ชื่อร้านค้า',
  `token` int(11) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `prefix`, `firstname`, `lastname`, `tel`, `email`, `username`, `password`, `userrole`, `shop_name`, `token`, `last_login`) VALUES
(000005, 'นาย', 'แอดมิน', 'admin', '0011212312', 'admin@ex.com', 'admin', 'admin', 1, 'admin', 9999, '2024-09-12 09:28:46'),
(000006, 'นาย', 'User', 'Test', '0222222222', 'userTest@gmail.com', 'user', 'user', 0, 'UserShop', 40, '2024-09-12 09:28:49'),
(000010, 'นาย', 'ทดสอบ', 'ระบบ', '0891247281', 'Test@gmail.com', 'Test', 'test8888', 0, 'TestShop', 80, '2024-08-24 17:02:28'),
(000013, 'นางสาว', 'ทดสอบ', 'ระบบ', '0123453124', 'usertest@gmail.com', 'usertest', '1212312121a', 0, 'แก้ไขชื่อร้าน', 0, '2024-09-06 16:50:10'),
(000014, 'นางสาว', 'ณัฐเนตร', 'พยัคฆ์เดช', '0945347566', '66010915510@msu.ac.th', 'Mix', 'nm060847', 0, 'mmiixx', 0, '2024-09-06 23:58:06'),
(000015, 'นางสาว', 'Kan', 'Ok', '0902738970', 'kanokwan.pd@rmuti.ac.th', 'Pin', 'kanokwan13', 0, 'P', 0, '2024-09-10 11:56:23'),
(000016, 'นาย', 'นนทชัย', 'โพธิ์ศรี', '0881726738', 'GasUser@gmail.com', 'GasUser', 'nontachai01', 0, 'GasMOdernShop', 80, '2024-09-07 21:43:31'),
(000017, 'นาย', 'จตุพล', 'สิงห์กระโจม', '064574845', 'Chatupon21396@gmail.com', 'Chatupon', '12345678aa', 0, 'Chatupon Shop', 1000, '2024-09-08 19:45:54'),
(000018, 'นางสาว', 'พลอยด์', 'ตี้', '0648924402', 'ploitii6@gmail.com', 'Paolow_m', '0258', 0, 'ขายแมลงทอด', 7000, '2024-09-08 19:54:36'),
(000019, 'นาย', 'นนทชัย', 'โพธิ์ศรี', '0818267489', 'nontachai@ex.com', 'nontachai', '1212312121a', 0, 'GGasShop', 0, '2024-09-11 23:07:19'),
(000020, 'นาย', 'Wwwut', 'Wong', '0933505147', 'Wutthichai@gmail.com', 'Hee', 'bestkung', 0, 'Foodfit', 0, '2024-09-10 08:46:03'),
(000021, 'นางสาว', 'ธนาภรณ์', 'ผิวขาว', '0984299926', 'tanaphorn.che@gmail.com', 'Kaew', 'kaew180534', 0, 'KT shop', 0, '2024-09-10 07:47:21'),
(000022, 'นางสาว', 'ปาริชาติ', 'โพธิ์ศรี', '0647765475', 'giftja2547@gmail.com', 'Gifttt', '12345678gg', 0, 'Pividger', 0, '2024-09-10 08:24:09'),
(000023, 'นาง', 'ปราณี', 'โพธิ์ศรี', '0956606123', 'prosri2517@hotmail.com', '040717', 'pro040717', 0, 'ร้านกินอิ่ม', 0, '2024-09-10 08:44:06'),
(000024, 'นางสาว', 'กมลชนก', 'คล่องดี', '0621761315', 'Kamonchanok15525@gmail.com', 'Tawann.', 'Cha080946', 0, 'TAWAN DAY', 1600, '2024-09-10 08:47:38'),
(000025, 'นาย', 'เตชิต', 'รุ่งทิม', '0955670581', 'techit.ru@rmuti.ac.th', 'techit', '12345678kuy', 0, 'www_kaikong_com', 0, '2024-09-11 21:08:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userrole`
--

CREATE TABLE `tbl_userrole` (
  `role_id` int(3) NOT NULL COMMENT 'รหัส',
  `role_name` varchar(50) NOT NULL COMMENT 'ชื่อ role'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_userrole`
--

INSERT INTO `tbl_userrole` (`role_id`, `role_name`) VALUES
(0, 'nm_user'),
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `zone_detail`
--

CREATE TABLE `zone_detail` (
  `zone_id` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสโซน',
  `zone_name` varchar(50) NOT NULL COMMENT 'ชื่อโซน',
  `zone_detail` varchar(45) NOT NULL,
  `pricePerDate` float DEFAULT NULL COMMENT 'ราคาต่อวัน',
  `pricePerMonth` float DEFAULT NULL COMMENT 'ราคาต่อเดือน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `zone_detail`
--

INSERT INTO `zone_detail` (`zone_id`, `zone_name`, `zone_detail`, `pricePerDate`, `pricePerMonth`) VALUES
(029, 'B', 'เสื้อผ้าและแฟชั่น', 40, 1000),
(030, 'C', 'จิปาถะ,เบ็ดเตล็ด', 40, 1000),
(033, 'A', 'อาหารและเครื่องดื่ม', 40, 1000),
(036, 'D', 'เปิดท้ายขายของมือสอง', 50, 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked`
--
ALTER TABLE `booked`
  ADD PRIMARY KEY (`id_booked`),
  ADD KEY `already_bookedbooked_ibfk_1_idx` (`booking_id`),
  ADD KEY `dfs_idx` (`member_id`),
  ADD KEY `asdw_idx` (`zone_id`),
  ADD KEY `csdsf_idx` (`product_type`),
  ADD KEY `asdw_idx1` (`sub_product_type`),
  ADD KEY `fk__idx` (`booking_status`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `booking_status` (`booking_status`),
  ADD KEY `asdw_idx` (`product_type`);

--
-- Indexes for table `booking_status`
--
ALTER TABLE `booking_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `locks`
--
ALTER TABLE `locks`
  ADD PRIMARY KEY (`id_locks`,`lock_name`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `locks_ibfk_3_idx` (`lock_name`);

--
-- Indexes for table `operating_hours`
--
ALTER TABLE `operating_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`idsub_category`),
  ADD KEY `fkk_cat_subcat_idx` (`id_category`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `userrole` (`userrole`);

--
-- Indexes for table `tbl_userrole`
--
ALTER TABLE `tbl_userrole`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `zone_detail`
--
ALTER TABLE `zone_detail`
  ADD PRIMARY KEY (`zone_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked`
--
ALTER TABLE `booked`
  MODIFY `id_booked` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการจองแบบเรียบร้อยแล้ว', AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการจอง', AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `booking_status`
--
ALTER TABLE `booking_status`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'รหัสสถานะการจอง', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `locks`
--
ALTER TABLE `locks`
  MODIFY `id_locks` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีล็อค', AUTO_INCREMENT=682;

--
-- AUTO_INCREMENT for table `operating_hours`
--
ALTER TABLE `operating_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `idsub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสลูกค้า', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `zone_detail`
--
ALTER TABLE `zone_detail`
  MODIFY `zone_id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสโซน', AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked`
--
ALTER TABLE `booked`
  ADD CONSTRAINT `fk_cat` FOREIGN KEY (`product_type`) REFERENCES `category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`booking_status`) REFERENCES `booking_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`member_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `tbl_user` (`user_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`zone_id`) REFERENCES `zone_detail` (`zone_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`booking_status`) REFERENCES `booking_status` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`product_type`) REFERENCES `category` (`id_category`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `locks`
--
ALTER TABLE `locks`
  ADD CONSTRAINT `locks_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `locks_ibfk_2` FOREIGN KEY (`zone_id`) REFERENCES `zone_detail` (`zone_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `fkk_subcat` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`userrole`) REFERENCES `tbl_userrole` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
