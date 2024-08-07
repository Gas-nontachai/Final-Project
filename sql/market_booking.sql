-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 05:10 PM
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
  `booking_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสการจอง',
  `booking_amount` varchar(45) NOT NULL,
  `total_price` varchar(45) NOT NULL,
  `product_type` varchar(45) NOT NULL,
  `sub_product_type` varchar(45) NOT NULL,
  `member_id` int(6) UNSIGNED NOT NULL COMMENT 'รหัสลูกค้า',
  `booking_status` int(3) UNSIGNED NOT NULL COMMENT 'สถานะการจอง',
  `booking_type` varchar(45) NOT NULL,
  `zone_id` int(3) UNSIGNED NOT NULL COMMENT 'รหัสประเภทโซน',
  `slip_img` varchar(20) NOT NULL COMMENT 'log',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันเวลาที่จอง',
  `booked_lock_number` varchar(10) DEFAULT NULL COMMENT 'เลขล็อคที่จะได้'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `booked`
--

INSERT INTO `booked` (`id_booked`, `booking_id`, `booking_amount`, `total_price`, `product_type`, `sub_product_type`, `member_id`, `booking_status`, `booking_type`, `zone_id`, `slip_img`, `booking_date`, `booked_lock_number`) VALUES
(0000000001, 0000000004, '1', '100', '4', '25', 4, 6, 'PerMonth', 22, '', '2024-08-07 05:12:03', NULL);

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
  `product_type` int(6) UNSIGNED NOT NULL COMMENT 'ประเภทสินค้า',
  `sub_product_type` varchar(45) NOT NULL,
  `slip_img` varchar(45) DEFAULT NULL,
  `book_lock_number` varchar(45) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันเวลาที่จอง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `member_id`, `booking_status`, `booking_type`, `zone_id`, `booking_amount`, `total_price`, `product_type`, `sub_product_type`, `slip_img`, `book_lock_number`, `booking_date`) VALUES
(0000000003, 000004, 4, 'PerDay', 016, 1, 50, 3, '21', 'slip_20240805_090841_66b0342990296.jpg', 'A1', '2024-08-07 09:26:07'),
(0000000004, 000004, 6, 'PerMonth', 022, 1, 100, 4, '25', NULL, NULL, '2024-08-07 05:12:03'),
(0000000005, 000004, 4, 'PerDay', 016, 3, 150, 3, '22', 'slip_20240805_102106_66b045222fbba.jpg', 'A2, A3, A4', '2024-08-07 09:26:33');

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
(3, 'Food'),
(4, 'Dress'),
(6, 'Etc');

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
(257, 'A1', 016, 0000000003, 1),
(258, 'A2', 016, 0000000005, 1),
(259, 'A3', 016, 0000000005, 1),
(260, 'A4', 016, 0000000005, 1),
(261, 'A5', 016, NULL, 0),
(262, 'A6', 016, NULL, 0),
(263, 'A7', 016, NULL, 0),
(264, 'A8', 016, NULL, 0),
(265, 'A9', 016, NULL, 0),
(266, 'A10', 016, NULL, 0),
(267, 'A11', 016, NULL, 0),
(268, 'A12', 016, NULL, 0),
(269, 'A13', 016, NULL, 0),
(270, 'A14', 016, NULL, 0),
(271, 'A15', 016, NULL, 0),
(272, 'A16', 016, NULL, 0),
(273, 'A17', 016, NULL, 0),
(274, 'A18', 016, NULL, 0),
(275, 'A19', 016, NULL, 0),
(276, 'A20', 016, NULL, 0),
(347, 'B1', 021, NULL, 0),
(348, 'B2', 021, NULL, 0),
(349, 'B3', 021, NULL, 0),
(350, 'B4', 021, NULL, 0),
(351, 'B5', 021, NULL, 0),
(352, 'B6', 021, NULL, 0),
(353, 'B7', 021, NULL, 0),
(354, 'B8', 021, NULL, 0),
(355, 'B9', 021, NULL, 0),
(356, 'B10', 021, NULL, 0),
(357, 'B11', 021, NULL, 0),
(358, 'B12', 021, NULL, 0),
(359, 'B13', 021, NULL, 0),
(360, 'B14', 021, NULL, 0),
(361, 'B15', 021, NULL, 0),
(362, 'B16', 021, NULL, 0),
(363, 'B17', 021, NULL, 0),
(364, 'B18', 021, NULL, 0),
(365, 'B19', 021, NULL, 0),
(366, 'B20', 021, NULL, 0),
(367, 'C1', 022, NULL, 0),
(368, 'C2', 022, NULL, 0),
(369, 'C3', 022, NULL, 0),
(370, 'C4', 022, NULL, 0),
(371, 'C5', 022, NULL, 0),
(372, 'C6', 022, NULL, 0),
(373, 'C7', 022, NULL, 0),
(374, 'C8', 022, NULL, 0),
(375, 'C9', 022, NULL, 0),
(376, 'C10', 022, NULL, 0),
(377, 'C11', 022, NULL, 0),
(378, 'C12', 022, NULL, 0),
(379, 'C13', 022, NULL, 0),
(380, 'C14', 022, NULL, 0),
(381, 'C15', 022, NULL, 0),
(382, 'C16', 022, NULL, 0),
(383, 'C17', 022, NULL, 0),
(384, 'C18', 022, NULL, 0),
(385, 'C19', 022, NULL, 0),
(386, 'C20', 022, NULL, 0),
(387, 'C21', 022, NULL, 0),
(388, 'C22', 022, NULL, 0),
(389, 'C23', 022, NULL, 0),
(390, 'C24', 022, NULL, 0),
(391, 'C25', 022, NULL, 0),
(392, 'C26', 022, NULL, 0),
(393, 'C27', 022, NULL, 0),
(394, 'C28', 022, NULL, 0),
(395, 'C29', 022, NULL, 0),
(396, 'C30', 022, NULL, 0),
(397, 'C31', 022, NULL, 0),
(398, 'C32', 022, NULL, 0),
(399, 'C33', 022, NULL, 0),
(400, 'C34', 022, NULL, 0),
(401, 'C35', 022, NULL, 0),
(402, 'C36', 022, NULL, 0),
(403, 'C37', 022, NULL, 0),
(404, 'C38', 022, NULL, 0),
(405, 'C39', 022, NULL, 0),
(406, 'C40', 022, NULL, 0),
(407, 'C41', 022, NULL, 0),
(408, 'C42', 022, NULL, 0),
(409, 'C43', 022, NULL, 0),
(410, 'C44', 022, NULL, 0),
(411, 'C45', 022, NULL, 0),
(412, 'C46', 022, NULL, 0),
(413, 'C47', 022, NULL, 0),
(414, 'C48', 022, NULL, 0),
(415, 'C49', 022, NULL, 0),
(416, 'C50', 022, NULL, 0);

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
  `id_category` varchar(45) NOT NULL,
  `sub_cat_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`idsub_category`, `id_category`, `sub_cat_name`) VALUES
(20, '3', 'drink'),
(21, '3', 'fastfood'),
(22, '3', 'etc'),
(23, '4', '1Hand'),
(24, '4', '2Hand'),
(25, '4', 'ETC'),
(73, '6', 'etc1'),
(74, '6', 'etc2'),
(75, '6', 'etc3'),
(76, '6', 'etc4'),
(77, '6', 'etc5');

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
(000005, 'นาย', 'แอดมิน', 'admin', '0999999999', 'admin', 'admin', 'admin888', 1, 'admin');

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
(016, 'A', 'Food', 50, 1000),
(021, 'B', 'Something', 50, 1000),
(022, 'C', 'Cloth', 50, 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked`
--
ALTER TABLE `booked`
  ADD PRIMARY KEY (`id_booked`),
  ADD KEY `booked_ibfk_1_idx` (`booking_id`),
  ADD KEY `booked_ibfk_2_idx` (`booked_lock_number`),
  ADD KEY `already_bookedbooked_ibfk_1_idx` (`booking_id`),
  ADD KEY `already_booked_ibfk_2_idx` (`zone_id`),
  ADD KEY `already_booked_ibfk_3_idx` (`member_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `booking_status` (`booking_status`);

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
-- Indexes for table `locks`
--
ALTER TABLE `locks`
  ADD PRIMARY KEY (`id_locks`,`lock_name`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `locks_ibfk_3_idx` (`lock_name`);

--
-- Indexes for table `pre_category`
--
ALTER TABLE `pre_category`
  ADD PRIMARY KEY (`idpre_category`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`idsub_category`);

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
  MODIFY `id_booked` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการจองแบบเรียบร้อยแล้ว', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสการจอง', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `booking_status`
--
ALTER TABLE `booking_status`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'รหัสสถานะการจอง', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `locks`
--
ALTER TABLE `locks`
  MODIFY `id_locks` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีล็อค', AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT for table `pre_category`
--
ALTER TABLE `pre_category`
  MODIFY `idpre_category` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `idsub_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

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
  MODIFY `user_id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสลูกค้า', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zone_detail`
--
ALTER TABLE `zone_detail`
  MODIFY `zone_id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสโซน', AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked`
--
ALTER TABLE `booked`
  ADD CONSTRAINT `already_booked_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `already_booked_ibfk_2` FOREIGN KEY (`zone_id`) REFERENCES `zone_detail` (`zone_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `already_booked_ibfk_3` FOREIGN KEY (`member_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `already_booked_ibfk_4` FOREIGN KEY (`booked_lock_number`) REFERENCES `locks` (`lock_name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `tbl_user` (`user_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`zone_id`) REFERENCES `zone_detail` (`zone_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`booking_status`) REFERENCES `booking_status` (`id`);

--
-- Constraints for table `locks`
--
ALTER TABLE `locks`
  ADD CONSTRAINT `locks_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`),
  ADD CONSTRAINT `locks_ibfk_2` FOREIGN KEY (`zone_id`) REFERENCES `zone_detail` (`zone_id`);

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
