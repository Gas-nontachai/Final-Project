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
    $updateSql = "UPDATE booking SET booking_status = '7' WHERE booking_id = $booking_id";
    if (!$conn->query($updateSql)) {
        throw new Exception("อัพเดตผิดพลาด: " . $conn->error);
    }

    // ยืนยันการทำธุรกรรม (commit)
    $conn->commit();
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ส่งคำขอคืนเงินเรียบร้อย</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "ส่งคำขอคืนเงินเรียบร้อย",
                    title: "หลังจากผู้ดูแลระบบยืนยันแล้วคุณจะได้รับเหรียญตามเงินที่จ่ายไป",
                    icon: "success",
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                        window.location.href = "./order.php"; // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                    
                });
            });
        </script>
    </body>
    </html>';
} catch (Exception $e) {
    // หากมีข้อผิดพลาดให้ยกเลิกการทำธุรกรรม (rollback)
    $conn->rollback();
    echo $e->getMessage();
}

// ปิดการเชื่อมต่อ
$conn->close();
