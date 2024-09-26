<?php
session_start();
require("../condb.php");
$date = $_GET['start_date']; // รับวันเริ่มต้นจาก URL
$end_date = $_GET['end_date']; // รับวันสิ้นสุดจาก URL

// Query เพื่อดึงข้อมูลการจองตามช่วงวัน
$query = "SELECT 
    zd.zone_name,
    COUNT(b.id_booked) AS booking_amount 
FROM booked b
JOIN zone_detail zd ON b.zone_id = zd.zone_id
WHERE DATE(b.booking_date) BETWEEN '$date' AND '$end_date'
GROUP BY zd.zone_name";
$result = mysqli_query($conn, $query);

// เตรียมข้อมูลสำหรับกราฟ
$data = [];
$data['labels'] = [];
$data['booking_amounts'] = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data['labels'][] = $row['zone_name'];
    $data['booking_amounts'][] = $row['booking_amount'];
}

// ส่งข้อมูลเป็น JSON
echo json_encode($data);
