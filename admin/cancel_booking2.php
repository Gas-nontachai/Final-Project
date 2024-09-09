<?php
session_start();
require("../condb.php");
if ($_SESSION["userrole"] == 0) {
    session_destroy();
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ไม่มีสิทธิ์เข้าถึง</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "คุณไม่มีสิทธิ์เข้าถึง เฉพาะผู้ดูแลเท่านั้น",
                    icon: "error",
                    showConfirmButton: true
                }).then((result) => {
                    window.location.href = "../login.php";
                });
            });
        </script>
    </body>
    </html>';
    exit();
}
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

        // ดึง lock_name ที่ต้องอัปเดตจากตาราง booking
        $get_locks_query = "SELECT DISTINCT book_lock_number FROM booking WHERE expiration_date <= NOW()";
        $result = $conn->query($get_locks_query);
        if ($result === FALSE) {
            throw new Exception("ไม่สามารถดึงข้อมูลล็อคได้: " . $conn->error);
        }

        $lock_names = [];
        while ($row = $result->fetch_assoc()) {
            $lock_names[] = $row['book_lock_number']; // เก็บข้อมูลจากทุกแถว
        }

        // อัปเดตล็อค
        foreach ($lock_names as $lock_name) {
            $lock_numbers = explode(',', $lock_name);
            foreach ($lock_numbers as $number) {
                $number = trim($number); // ตัดช่องว่างรอบๆ
                $update_locks_query = "UPDATE locks 
                                       SET booking_id = NULL, available = 0 
                                       WHERE lock_name = ?";
                $stmt = $conn->prepare($update_locks_query);
                if ($stmt === FALSE) {
                    throw new Exception("ไม่สามารถเตรียมคำสั่งอัปเดตล็อคได้: " . $conn->error);
                }
                $stmt->bind_param('s', $number);
                if ($stmt->execute() === FALSE) {
                    throw new Exception("ไม่สามารถอัปเดตล็อค: " . $stmt->error);
                }
                $stmt->close();
            }
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
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "ยกเลิกการจองเรียบร้อย",
                   icon: "success",
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                        window.location.href = "./refund_page.php"; // เปลี่ยนเส้นทางไปยังหน้า index.php
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
