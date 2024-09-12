<?php
session_start();
require("../condb.php");

try {
    // กำหนดตัวแปร current_time
    $current_time = date('Y-m-d H:i:s');

    // แสดง current_time สำหรับการดีบัก
    echo 'Current Time: ' . $current_time . '<br>';

    // เริ่มการทำธุรกรรม
    $conn->begin_transaction();

    // อัปเดตสถานะ booking_status = 10 สำหรับการจองที่หมดอายุ
    $update_status_query = "UPDATE booking 
                            SET booking_status = 10 
                            WHERE (booking_date < DATE_ADD(NOW(), INTERVAL 1 DAY) 
                            AND booking_type = 'PerDay' AND book_lock_number IS NULL AND slip_img IS NULL)
                            OR (booking_date < DATE_ADD(NOW(), INTERVAL 1 MONTH) 
                            AND booking_type = 'PerMonth' AND book_lock_number IS NULL AND slip_img IS NULL)";
    if ($conn->query($update_status_query) === FALSE) {
        throw new Exception("ไม่สามารถอัปเดตสถานะการจองได้: " . $conn->error);
    }

    // อัปเดตสถานะ booking_status = 11 สำหรับการจองที่หมดอายุ
    $update_status_query_expired = "UPDATE booking
                                        SET booking_status = 11
                                        WHERE (booking_type = 'PerDay' AND expiration_date < '$current_time')
                                        OR (booking_type = 'PerMonth' AND expiration_date < '$current_time')";
    if ($conn->query($update_status_query_expired) === FALSE) {
        throw new Exception("ไม่สามารถอัปเดตสถานะการจองเป็น 11 ได้: " . $conn->error);
    }

    // ย้ายการจองที่หมดอายุหรือที่มีสถานะ booking_status = 10 ไปยังตาราง booked
    $move_query = "INSERT INTO booked (booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, booked_lock_number, slip_img, expiration_date)
                   SELECT booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, book_lock_number, slip_img, expiration_date
                   FROM booking
                   WHERE expiration_date <= NOW() OR booking_status = 10 OR booking_status = 11";
    if ($conn->query($move_query) === FALSE) {
        throw new Exception("ไม่สามารถย้ายการจองที่หมดอายุได้: " . $conn->error);
    }
    $affected_rows_move = $conn->affected_rows;

    // ดึง lock_name ที่ต้องอัปเดตจากตาราง booking
    $get_locks_query = "SELECT DISTINCT book_lock_number FROM booking WHERE expiration_date <= NOW() OR booking_status = 10 OR booking_status = 11";
    $result = $conn->query($get_locks_query);
    if ($result === FALSE) {
        throw new Exception("ไม่สามารถดึงข้อมูลล็อคได้: " . $conn->error);
    }

    $lock_names = [];
    while ($row = $result->fetch_assoc()) {
        $lock_names[] = $row['book_lock_number']; // เก็บข้อมูลจากทุกแถว
    }

    // อัปเดตล็อก
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
    $affected_rows_update = $conn->affected_rows;

    // ลบการจองที่หมดอายุหรือที่มี booking_status = 10 ออกจากตาราง booking
    $delete_query = "DELETE FROM booking WHERE expiration_date <= NOW() OR booking_status = 10 OR booking_status = 11";
    if ($conn->query($delete_query) === FALSE) {
        throw new Exception("ไม่สามารถลบการจองที่หมดอายุได้: " . $conn->error);
    }
    $affected_rows_delete = $conn->affected_rows;

    // ทำการ commit ธุรกรรม
    $conn->commit();

    // แสดง SweetAlert โดยใช้ echo HTML
    echo '
        <html>
            <head>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: "สำเร็จ!",
                        text: "ดำเนินการสำเร็จ: จำนวนแถวที่ถูกอัปเดตสถานะ: ' . $affected_rows_move . ', จำนวนแถวที่ถูกย้าย: ' . $affected_rows_move . ', จำนวนแถวที่ถูกอัปเดต: ' . $affected_rows_update . ', จำนวนแถวที่ถูกลบ: ' . $affected_rows_delete . '",
                        icon: "success",
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                    }).then(function() {
                        window.location.href = "index.php"; // เปลี่ยนเป็นหน้าที่ต้องการหลังแสดง Swal
                    });
                </script>
            </body>
        </html>';
} catch (Exception $e) {
    // ทำการ rollback ธุรกรรมหากเกิดข้อผิดพลาด
    $conn->rollback();

    // แสดง SweetAlert ข้อผิดพลาดโดยใช้ echo HTML
    echo '
        <html>
            <head>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        text: "' . htmlspecialchars($e->getMessage()) . '",
                        icon: "error",
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                    });
                </script>
            </body>
        </html>';
}

$conn->close();
