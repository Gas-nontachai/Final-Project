<?php session_start();
require("../condb.php");

do {
    // เริ่มการทำธุรกรรม
    $conn->begin_transaction();

    try {
        // ย้ายการจองที่หมดอายุไปยังตาราง booked
        $move_query = "INSERT INTO booked (booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, booked_lock_number, slip_img, expiration_date)
                       SELECT booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, book_lock_number, slip_img, expiration_date
                       FROM booking
                       WHERE expiration_date <= NOW()";
        if ($conn->query($move_query) === FALSE) {
            throw new Exception("ไม่สามารถย้ายการจองที่หมดอายุได้: " . $conn->error);
        }

        // ตรวจสอบจำนวนแถวที่ถูกย้าย
        $affected_rows_move = $conn->affected_rows;

        // ดึง lock_name ที่ต้องอัปเดตจากตาราง booking
        $get_locks_query = "SELECT DISTINCT book_lock_number FROM booking WHERE expiration_date <= NOW()";
        $result = $conn->query($get_locks_query);
        if ($result === FALSE) {
            throw new Exception("ไม่สามารถดึงข้อมูลล็อกได้: " . $conn->error);
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
                    throw new Exception("ไม่สามารถเตรียมคำสั่งอัปเดตล็อกได้: " . $conn->error);
                }
                $stmt->bind_param('s', $number);
                if ($stmt->execute() === FALSE) {
                    throw new Exception("ไม่สามารถอัปเดตล็อก: " . $stmt->error);
                }
                $stmt->close();
            }
        }

        // ตรวจสอบจำนวนแถวที่ถูกอัปเดต
        $affected_rows_update = $conn->affected_rows;

        // ลบการจองที่หมดอายุออกจากตาราง booking
        $delete_query = "DELETE FROM booking WHERE expiration_date <= NOW()";
        if ($conn->query($delete_query) === FALSE) {
            throw new Exception("ไม่สามารถลบการจองที่หมดอายุได้: " . $conn->error);
        }

        // ตรวจสอบจำนวนแถวที่ถูกลบ
        $affected_rows_delete = $conn->affected_rows;

        // ทำการ commit ธุรกรรม
        $conn->commit();

        // แสดงจำนวนแถวที่ได้รับผลกระทบ
        echo "จำนวนแถวที่ถูกย้าย: $affected_rows_move<br>";
        echo "จำนวนแถวที่ถูกอัปเดต: $affected_rows_update<br>";
        echo "จำนวนแถวที่ถูกลบ: $affected_rows_delete<br>";

        // ตรวจสอบจำนวนแถวที่ถูกลบ
        if ($affected_rows_delete == 0) {
            // ถ้าไม่มีข้อมูลที่ได้รับผลกระทบ ให้หยุดลูป
            break;
        }
    } catch (Exception $e) {
        // ทำการ rollback ธุรกรรมหากเกิดข้อผิดพลาด
        $conn->rollback();

        // แสดงหรือบันทึกข้อผิดพลาด
        echo 'ข้อผิดพลาด: ' . htmlspecialchars($e->getMessage()) . "<br>";
        echo 'คำสั่ง SQL ที่ล้มเหลว: ' . htmlspecialchars($conn->error);
        break; // หยุดลูปหากเกิดข้อผิดพลาด
    }
} while (true);

$conn->close();
