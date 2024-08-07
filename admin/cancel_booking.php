<?php
session_start();
require("../condb.php");

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
    exit();
}

// เริ่มการทำธุรกรรม (transaction)
$conn->begin_transaction();
$booking_id = $_GET['booking_id'];

try {
    // อัปเดตข้อมูลใน booking
    $updateSql = "UPDATE booking SET booking_status = '6' WHERE booking_id = $booking_id";
    if (!$conn->query($updateSql)) {
        throw new Exception("Error updating record: " . $conn->error);
    }

    // ดึงข้อมูลที่อัปเดตจาก booking
    $selectSql = "SELECT * FROM booking WHERE booking_id = $booking_id";
    $result = $conn->query($selectSql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // คัดลอกข้อมูลไปยัง booked
        $insertSql = "INSERT INTO booked (booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, slip_img, booking_date) 
                      VALUES ('" . $row['booking_id'] . "', '" . $row['member_id'] . "', '" . $row['booking_status'] . "', '" . $row['booking_type'] . "', '" . $row['zone_id'] . "', '" . $row['booking_amount'] . "', '" . $row['total_price'] . "', '" . $row['product_type'] . "', '" . $row['sub_product_type'] . "', '" . $row['slip_img'] . "', '" . $row['booking_date'] . "')";
        if (!$conn->query($insertSql)) {
            throw new Exception("Error inserting record: " . $conn->error);
        }
    } else {
        throw new Exception("No record found with booking_id: " . $booking_id);
    }

    // ยืนยันการทำธุรกรรม (commit)
    $conn->commit();
    echo '<script>alert("ยกเลิกการจองเรียบร้อย"); window.location.href = "./confirm_reserve.php";</script>';
} catch (Exception $e) {
    // หากมีข้อผิดพลาดให้ยกเลิกการทำธุรกรรม (rollback)
    $conn->rollback();
    echo $e->getMessage();
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
