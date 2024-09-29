<?php
require("../condb.php");

// ตรวจสอบว่ามีค่า zone_name ถูกส่งมาหรือไม่
if (isset($_POST['zone_name'])) {
    $zone_name = $_POST['zone_name'];

    // Query จำนวนล็อคที่เหลือในโซนที่ถูกเลือก
    $sql = "SELECT COUNT(*) as available_locks
            FROM locks
            WHERE lock_name LIKE ? AND available = '0'"; // ใช้ available = '1' เพื่อค้นหาล็อคที่ว่าง

    // เตรียม statement
    $stmt = $conn->prepare($sql);

    // ตรวจสอบว่า $stmt ไม่เป็น false
    if ($stmt === false) {
        // แสดงข้อความข้อผิดพลาดจาก MySQLi
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    // เตรียมค่า searchTerm สำหรับ LIKE
    $searchTerm = $zone_name . '%'; // ใช้ '%' สำหรับ LIKE
    $stmt->bind_param("s", $searchTerm); // ใช้ bind_param เพื่อป้องกัน SQL Injection
    $stmt->execute();
    $result = $stmt->get_result();

    // ดึงค่าจำนวนล็อคที่เหลือ
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['available_locks']; // ส่งค่าจำนวนล็อคกลับไปที่ front-end
    } else {
        echo "0"; // หากไม่มีล็อคว่างในโซนนี้
    }

    // ปิด statement และ connection
    $stmt->close();
    $conn->close();
} else {
    echo "No zone name provided"; // ตรวจสอบหากไม่มี zone_name
}
