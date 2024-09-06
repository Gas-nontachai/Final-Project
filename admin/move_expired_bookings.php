<?php session_start();
require("../condb.php");

try {
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
                                    WHERE (expiration_date < DATE_ADD(NOW(), INTERVAL 1 DAY) 
                                    AND booking_type = 'PerDay')
                                    OR (expiration_date < DATE_ADD(NOW(), INTERVAL 1 MONTH) 
                                    AND booking_type = 'PerMonth')";
    if ($conn->query($update_status_query_expired) === FALSE) {
        throw new Exception("ไม่สามารถอัปเดตสถานะการจองเป็น 11 ได้: " . $conn->error);
    }

    // ย้ายการจองที่หมดอายุหรือที่มีสถานะ booking_status = 10 ไปยังตาราง booked
    $move_query = "INSERT INTO booked (booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, book_lock_number, slip_img, expiration_date)
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

    // แสดงจำนวนแถวที่ได้รับผลกระทบ
    echo "จำนวนแถวที่ถูกอัปเดตสถานะ: $affected_rows_move<br>";
    echo "จำนวนแถวที่ถูกย้าย: $affected_rows_move<br>";
    echo "จำนวนแถวที่ถูกอัปเดต: $affected_rows_update<br>";
    echo "จำนวนแถวที่ถูกลบ: $affected_rows_delete<br>";
} catch (Exception $e) {
    // ทำการ rollback ธุรกรรมหากเกิดข้อผิดพลาด
    $conn->rollback();

    // แสดงหรือบันทึกข้อผิดพลาด
    echo 'ข้อผิดพลาด: ' . htmlspecialchars($e->getMessage()) . "<br>";
    echo 'คำสั่ง SQL ที่ล้มเหลว: ' . htmlspecialchars($conn->error);
}

$conn->close();
