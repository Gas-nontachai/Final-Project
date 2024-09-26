<?php
session_start();
require("../condb.php");

$timeFrame = isset($_GET['timeFrame']) ? $_GET['timeFrame'] : 'monthly'; // ตั้งค่าเริ่มต้นเป็น 'monthly'

// SQL Queries ตามช่วงเวลาที่เลือก
if ($timeFrame == 'weekly') {
    $sql = "SELECT DATE_FORMAT(b.booking_date, '%Y-%u') AS booking_week, 
                   COUNT(b.id_booked) AS total_bookings, 
                   SUM(b.total_price) AS total_revenue
            FROM booked b
            WHERE b.booking_date >= DATE_SUB(NOW(), INTERVAL 10 WEEK)  -- จำกัดแค่ 7 สัปดาห์
            GROUP BY booking_week
            ORDER BY booking_week ASC
            LIMIT 4";
} elseif ($timeFrame == 'daily') {
    $sql = "SELECT 
                DATE(b.booking_date) AS booking_date, 
                COUNT(b.id_booked) AS total_bookings, 
                SUM(b.total_price) AS total_revenue
            FROM 
                booked b
            WHERE 
                b.booking_date >= DATE_SUB(NOW(), INTERVAL 10 DAY)  -- จำกัดแค่ 10 วัน
            GROUP BY 
                DATE(b.booking_date)  -- รวมข้อมูลตามวันที่
            ORDER BY 
                booking_date DESC  -- แสดงวันที่ล่าสุดก่อน
            LIMIT 7";
} else {
    $sql = "SELECT DATE_FORMAT(b.booking_date, '%Y-%m') AS booking_month, 
                   COUNT(b.id_booked) AS total_bookings, 
                   SUM(b.total_price) AS total_revenue
            FROM booked b
            WHERE b.booking_date >= DATE_SUB(NOW(), INTERVAL 10 MONTH)  -- จำกัดแค่ 7 เดือน
            GROUP BY booking_month
            ORDER BY booking_month ASC
            LIMIT 4";
}

$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();
echo json_encode($data);
