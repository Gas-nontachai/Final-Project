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
        throw new Exception("อัปเดตผิดพลาด: " . $conn->error);
    }

    // ดึงข้อมูลที่อัปเดตจาก booking
    $selectSql = "SELECT * FROM booking WHERE booking_id = $booking_id";
    $result = $conn->query($selectSql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // คัดลอกข้อมูลไปยัง booked
        $insertSql = "INSERT INTO booked (booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, slip_img, booking_date) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("isssissssss", $row['booking_id'], $row['member_id'], $row['booking_status'], $row['booking_type'], $row['zone_id'], $row['booking_amount'], $row['total_price'], $row['product_type'], $row['sub_product_type'], $row['slip_img'], $row['booking_date']);
        if (!$stmt->execute()) {
            throw new Exception("ย้ายข้อมูลผิดพลาด: " . $stmt->error);
        }

        // ลบข้อมูลจาก booking หลังจากคัดลอกไปยัง booked
        $deleteSql = "DELETE FROM booking WHERE booking_id = $booking_id";
        if (!$conn->query($deleteSql)) {
            throw new Exception("ลบข้อมูลผิดพลาด: " . $conn->error);
        }
    } else {
        throw new Exception("ไม่มีผลการค้นหาจากรหัสการจอง: " . $booking_id);
    }

    // ยืนยันการทำธุรกรรม (commit)
    $conn->commit();

    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ยกเลิกการจองเรียบร้อย</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "ยกเลิกการจองเรียบร้อย",
                    icon: "success",
                    timer: 2000, // แสดงเป็นเวลา 2 วินาที
                    timerProgressBar: true, // แสดงแถบความก้าวหน้า
                    showConfirmButton: false // ซ่อนปุ่ม "OK"
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "./confirm_reserve.php"; // เปลี่ยนเส้นทางไปยังหน้า index.php
                    }
                });
            });
        </script>
    </body>
    </html>';
} catch (Exception $e) {
    // หากมีข้อผิดพลาดให้ยกเลิกการทำธุรกรรม (rollback)
    $conn->rollback();
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}

// ปิดการเชื่อมต่อ
$conn->close();
