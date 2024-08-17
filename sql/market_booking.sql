-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 12:03 PM
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
  `member_id` int(6) UNSIGNED NOT NULL COMMENT 'รหัสลูกค้า',
  `booking_amount` varchar(45) NOT NULL,
  `total_price` varchar(45) NOT NULL,
  `product_type` int(11) NOT NULL,
  `sub_product_type` int(11) NOT NULL,
  `booking_status` int(3) UNSIGNED NOT NULL COMMENT 'สถานะการจอง',
  `booking_type` int(11) NOT NULL,
  `zone_id` int(3) UNSIGNED NOT NULL COMMENT 'รหัสประเภทโซน',
  `slip_img` varchar(45) DEFAULT NULL COMMENT 'log',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันเวลาที่จอง',
  `booked_lock_number` varchar(10) DEFAULT NULL COMMENT 'เลขล็อคที่จะได้',
  `expiration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `booked`
--

INSERT INTO `booked` (`id_booked`, `booking_id`, `member_id`, `booking_amount`, `total_price`, `product_type`, `sub_product_type`, `booking_status`, `booking_type`, `zone_id`, `slip_img`, `booking_date`, `booked_lock_number`, `expiration_date`) VALUES
(0000000001, 4, 4, '1', '100', 4, 25, 6, 0, 22, '', '2024-08-07 05:12:03', NULL, NULL),
(0000000009, 7, 6, '2', '100', 4, 23, 4, 0, 22, NULL, '2024-08-07 16:49:59', 'C1, C2', '2024-08-07 23:40:58'),
(0000000013, 3, 4, '1', '50', 3, 21, 4, 0, 16, NULL, '2024-08-07 17:09:33', 'A1', '2024-08-07 23:40:58'),
(0000000014, 5, 4, '3', '150', 3, 22, 4, 0, 16, NULL, '2024-08-07 17:09:33', 'A2, A3, A4', '2024-08-07 23:40:58'),
(0000000015, 6, 6, '1', '50', 3, 20, 4, 0, 16, NULL, '2024-08-07 17:09:33', 'A20', '2024-08-07 23:40:58'),
(0000000016, 9, 6, '3', '150', 3, 20, 4, 0, 16, NULL, '2024-08-07 17:14:24', 'A1, A2, A3', '2024-08-07 23:59:58'),
(0000000017, 10, 6, '1', '50', 6, 73, 4, 0, 21, NULL, '2024-08-07 17:14:24', 'B1', '2024-08-07 23:59:58'),
(0000000019, 11, 6, '3', '150', 3, 20, 4, 0, 16, NULL, '2024-08-07 17:31:09', 'A1, A4, A6', '2024-08-07 23:59:58'),
(0000000020, 12, 6, '3', '150', 3, 20, 4, 0, 16, NULL, '2024-08-07 17:33:20', 'A1, A2, A3', '2024-08-07 23:59:58'),
(0000000021, 13, 6, '3', '150', 3, 20, 4, 0, 16, NULL, '2024-08-07 17:37:28', 'A1, A2, A3', '2024-08-07 23:59:58'),
(0000000022, 14, 6, '5', '250', 3, 20, 4, 0, 16, NULL, '2024-08-07 17:39:26', 'A4, A7, A8', '2024-08-07 23:59:58'),
(0000000023, 8, 6, '3', '3000', 6, 73, 4, 0, 21, NULL, '2024-07-07 16:18:32', 'B1, B2, B3', '2024-07-07 23:18:23'),
(0000000024, 15, 6, '2', '100', 3, 20, 4, 0, 16, NULL, '2024-08-08 14:25:19', 'A1, A2', '2024-08-07 23:59:58'),
(0000000026, 16, 6, '3', '150', 3, 20, 4, 0, 16, NULL, '2024-08-08 14:32:16', 'A1, A2, A3', '2024-08-07 23:59:58'),
(0000000027, 17, 6, '2', '2000', 3, 21, 4, 0, 21, NULL, '2024-08-08 14:32:16', 'B1, B2', '2024-07-07 21:31:15'),
(0000000028, 18, 6, '2', '80', 3, 20, 6, 0, 28, 'slip_20240809_014836', '2024-08-09 09:48:26', NULL, NULL),
(0000000029, 18, 6, '2', '80', 3, 20, 6, 0, 28, 'slip_20240809_014836', '2024-08-09 09:53:15', NULL, NULL),
(0000000030, 20, 6, '2', '80', 3, 125, 6, 0, 33, 'slip_20240809_183925', '2024-08-09 11:43:29', NULL, NULL),
(0000000031, 21, 6, '1', '40', 3, 125, 6, 0, 33, NULL, '2024-08-09 11:45:03', NULL, NULL),
(0000000032, 22, 6, '1', '40', 4, 85, 6, 0, 33, NULL, '2024-08-09 11:46:27', NULL, NULL),
(0000000033, 23, 6, '2', '80', 3, 125, 4, 0, 33, NULL, '2024-08-09 11:47:34', 'A1, A2', '2024-08-07 23:59:58'),
(0000000034, 24, 6, '1', '40', 3, 125, 4, 0, 33, NULL, '2024-08-09 14:50:59', 'A1', '2024-08-08 23:59:58'),
(0000000035, 25, 6, '1', '40', 3, 125, 4, 0, 33, 'slip_20240809_215258', '2024-08-09 14:53:17', 'A1', '2024-08-08 23:59:58'),
(0000000036, 26, 6, '2', '80', 3, 125, 4, 0, 33, 'slip_20240809_215422_66b62d9e9080e.jpg', '2024-08-09 14:56:34', 'A1, A2', '2024-08-08 23:59:58'),
(0000000037, 27, 6, '2', '80', 3, 125, 6, 0, 33, NULL, '2024-08-13 13:08:55', NULL, NULL),
(0000000038, 29, 6, '3', '120', 3, 125, 6, 0, 33, NULL, '2024-08-16 12:48:32', NULL, NULL),
(0000000039, 28, 6, '2', '80', 3, 125, 4, 0, 33, 'slip_20240813_200906_66bb5af254f0f.jpg', '2024-08-13 13:09:16', 'A1, A2', '2024-08-13 23:59:58');

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
  `book_lock_number` varchar(45) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันเวลาที่จอง',
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
(6, 'ยกเลิก');

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
(7, 'จิปาถะของจุ๊บจิ๊บ'),
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
(3, 4, 'ดีมากค้าบบ', 5, '2024-08-17 04:36:43');

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
(597, 'D1', 032, NULL, 0),
(598, 'D2', 032, NULL, 0),
(599, 'D3', 032, NULL, 0),
(600, 'D4', 032, NULL, 0),
(601, 'D5', 032, NULL, 0),
(602, 'D6', 032, NULL, 0),
(603, 'D7', 032, NULL, 0),
(604, 'D8', 032, NULL, 0),
(605, 'D9', 032, NULL, 0),
(606, 'D10', 032, NULL, 0),
(607, 'D11', 032, NULL, 0),
(608, 'D12', 032, NULL, 0),
(609, 'D13', 032, NULL, 0),
(610, 'D14', 032, NULL, 0),
(611, 'D15', 032, NULL, 0),
(612, 'D16', 032, NULL, 0),
(613, 'D17', 032, NULL, 0),
(614, 'D18', 032, NULL, 0),
(615, 'D19', 032, NULL, 0),
(616, 'D20', 032, NULL, 0),
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
(636, 'A20', 033, NULL, 0);

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
(1, '09:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pre_category`
--

CREATE TABLE `pre_category` (
  `idpre_category` int(11) NOT NULL,
  `pre_cat_name` varchar(45) NOT NULL,
  `subdetail` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(101, 8, 'เสื้อผ้าและเครื่องแต่งกาย'),
(102, 8, 'เครื่องใช้ไฟฟ้า'),
(103, 8, 'เฟอร์นิเจอร์'),
(104, 8, 'ของตกแต่งบ้าน'),
(105, 8, 'หนังสือและสื่อบันเทิง'),
(106, 8, 'อุปกรณ์กีฬาและออกกำลังกาย'),
(107, 8, 'ของสะสม'),
(108, 8, 'เครื่องครัวและอุปกรณ์ทำอาหาร'),
(109, 8, 'ของเล่นและเกม'),
(110, 8, 'อุปกรณ์สำนักงานและเครื่องเขียน'),
(125, 3, 'อาหารคาว'),
(126, 3, 'อาหารหวาน'),
(127, 3, 'อาหารทานเล่น'),
(128, 3, 'อาหารเช้า'),
(129, 3, 'อาหารเพื่อสุขภาพ'),
(130, 3, 'อาหารจานเดียว');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `id_comment` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสคอมเม้น',
  `comment_score` int(2) NOT NULL COMMENT 'คะแนนการคอมเม้น',
  `user_comment` text NOT NULL COMMENT 'แสดงความคิดเห็น',
  `member_id` int(6) UNSIGNED DEFAULT NULL COMMENT 'รหัสผู้ใช้'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

CREATE TABLE `tbl_payments` (
  `paymentID` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสสลิป',
  `booking_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการจอง',
  `payments_img` varchar(45) NOT NULL COMMENT 'รูปภาพสลิป',
  `paymentDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันเวลาแนบสลิป'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `shop_name` varchar(50) NOT NULL COMMENT 'ชื่อร้านค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `prefix`, `firstname`, `lastname`, `tel`, `email`, `username`, `password`, `userrole`, `shop_name`) VALUES
(000001, 'นาย', 'Nontachai', 'Prosri', '0885639233', 'bigboy2546.77@gmail.com', 'GGas', 'nontachai01', 1, 'GGasShop'),
(000003, 'นาง', 'Kanokwan', 'Phakdee', '0888888888', 'Kanokwan.ph@gmail.com', 'Kanok', 'kanok123', 1, 'KanokShop'),
(000004, 'นาย', 'Nontachai', 'Prosri', '0889999999', 'bigboy2546.77@gmail.com', 'GGas2', 'nontachai01', 0, 'GGasShop'),
(000005, 'นาย', 'แอดมิน', 'admin', '0999999999', 'admin', 'admin', 'admin888', 1, 'admin'),
(000006, 'นาย', 'User', 'User', '0888888888', 'user', 'user', 'user8888', 0, 'user');

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
(030, 'C', 'จิปาถะของจุ๊บจิ๊บ', 40, 1000),
(032, 'D', 'เปิดท้ายของมือสอง', 40, 800),
(033, 'A', 'อาหารและเครื่องดื่ม', 40, 1000);

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
-- Indexes for table `pre_category`
--
ALTER TABLE `pre_category`
  ADD PRIMARY KEY (`idpre_category`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`idsub_category`),
  ADD KEY `fkk_cat_subcat_idx` (`id_category`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `booking_id` (`booking_id`);

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
  MODIFY `id_booked` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการจองแบบเรียบร้อยแล้ว', AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการจอง', AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `booking_status`
--
ALTER TABLE `booking_status`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'รหัสสถานะการจอง', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `locks`
--
ALTER TABLE `locks`
  MODIFY `id_locks` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีล็อค', AUTO_INCREMENT=637;

--
-- AUTO_INCREMENT for table `operating_hours`
--
ALTER TABLE `operating_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pre_category`
--
ALTER TABLE `pre_category`
  MODIFY `idpre_category` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `id_comment` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสคอมเม้น';

--
-- AUTO_INCREMENT for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  MODIFY `paymentID` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสสลิป';

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสลูกค้า', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zone_detail`
--
ALTER TABLE `zone_detail`
  MODIFY `zone_id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสโซน', AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked`
--
ALTER TABLE `booked`
  ADD CONSTRAINT `fk_cat` FOREIGN KEY (`product_type`) REFERENCES `category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`booking_status`) REFERENCES `booking_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`member_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `tbl_user` (`user_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`zone_id`) REFERENCES `zone_detail` (`zone_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`booking_status`) REFERENCES `booking_status` (`id`),
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
-- Constraints for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD CONSTRAINT `tbl_comment_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `tbl_user` (`user_id`);

--
-- Constraints for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD CONSTRAINT `tbl_payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`);

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`userrole`) REFERENCES `tbl_userrole` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
