<?php
session_start();
require("../condb.php");

$timeFrame = isset($_GET['timeFrame']) ? $_GET['timeFrame'] : 'monthly'; // ตั้งค่าเริ่มต้นเป็น 'monthly'

// SQL Queries ตามช่วงเวลาที่เลือก
if ($timeFrame == 'weekly') {
    $sql = "SELECT 
                DATE_FORMAT(b.booking_date, '%Y-%u') AS booking_week, 
                COUNT(CASE WHEN b.booking_type = 'perMonth' THEN b.id_booked END) AS total_bookings_month,
                COUNT(CASE WHEN b.booking_type = 'perDay' THEN b.id_booked END) AS total_bookings_day,
                SUM(CASE WHEN b.booking_type = 'perMonth' THEN b.total_price ELSE 0 END) AS total_revenue_month,
                SUM(CASE WHEN b.booking_type = 'perDay' THEN b.total_price ELSE 0 END) AS total_revenue_day
            FROM booked b
            WHERE b.booking_date >= DATE_SUB(NOW(), INTERVAL 10 WEEK)  -- จำกัดแค่ 10 สัปดาห์
            GROUP BY booking_week
            ORDER BY booking_week ASC
            LIMIT 4";
} elseif ($timeFrame == 'daily') {
    $sql = "SELECT 
                DATE(b.booking_date) AS booking_date, 
                COUNT(CASE WHEN b.booking_type = 'perMonth' THEN b.id_booked END) AS total_bookings_month,
                COUNT(CASE WHEN b.booking_type = 'perDay' THEN b.id_booked END) AS total_bookings_day,
                SUM(CASE WHEN b.booking_type = 'perMonth' THEN b.total_price ELSE 0 END) AS total_revenue_month,
                SUM(CASE WHEN b.booking_type = 'perDay' THEN b.total_price ELSE 0 END) AS total_revenue_day
            FROM booked b
            WHERE b.booking_date >= DATE_SUB(NOW(), INTERVAL 10 DAY)  -- จำกัดแค่ 10 วัน
            GROUP BY DATE(b.booking_date)
            ORDER BY booking_date DESC
             LIMIT 7";
} else {  // monthly
    $sql = "SELECT 
                DATE_FORMAT(b.booking_date, '%Y-%m') AS booking_month, 
                COUNT(CASE WHEN b.booking_type = 'perMonth' THEN b.id_booked END) AS total_bookings_month,
                COUNT(CASE WHEN b.booking_type = 'perDay' THEN b.id_booked END) AS total_bookings_day,
                SUM(CASE WHEN b.booking_type = 'perMonth' THEN b.total_price ELSE 0 END) AS total_revenue_month,
                SUM(CASE WHEN b.booking_type = 'perDay' THEN b.total_price ELSE 0 END) AS total_revenue_day
            FROM booked b
            WHERE b.booking_date >= DATE_SUB(NOW(), INTERVAL 10 MONTH)  -- จำกัดแค่ 10 เดือน
            GROUP BY booking_month
            ORDER BY booking_month ASC
             LIMIT 4";
}

$result = $conn->query($sql);
$data = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = array("message" => "No data found");
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($data);
