<?php
session_start();
require("../condb.php");

// Variable to store messages for JavaScript
$jsMessage = "";

do {
    // เริ่มการทำธุรกรรม
    $conn->begin_transaction();

    try {
        // อัปเดตสถานะ booking_status = 10 สำหรับการจองที่มี booking_date < 1 วันจากเวลาปัจจุบัน และ booking_type เป็น PerDay หรือ PerMonth
        $update_status_query = "UPDATE booking 
                                SET booking_status = 10 
                                WHERE (booking_date < DATE_ADD(NOW(), INTERVAL 1 DAY) 
                                AND booking_type = 'PerDay')
                                OR (booking_date < DATE_ADD(NOW(), INTERVAL 1 MONTH) 
                                AND booking_type = 'PerMonth')";
        if ($conn->query($update_status_query) === FALSE) {
            throw new Exception("ไม่สามารถอัปเดตสถานะการจองได้: " . $conn->error);
        }

        // ย้ายการจองที่หมดอายุหรือที่มีสถานะ booking_status = 10 ไปยังตาราง booked
        $move_query = "INSERT INTO booked (booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, booked_lock_number, slip_img, expiration_date)
                       SELECT booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, book_lock_number, slip_img, expiration_date
                       FROM booking
                       WHERE expiration_date <= NOW() OR booking_status = 10";
        if ($conn->query($move_query) === FALSE) {
            throw new Exception("ไม่สามารถย้ายการจองที่หมดอายุได้: " . $conn->error);
        }

        // ตรวจสอบจำนวนแถวที่ถูกย้าย
        $affected_rows_move = $conn->affected_rows;

        // ดึง lock_name ที่ต้องอัปเดตจากตาราง booking
        $get_locks_query = "SELECT DISTINCT book_lock_number FROM booking WHERE expiration_date <= NOW() OR booking_status = 10";
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

        // ลบการจองที่หมดอายุหรือที่มี booking_status = 10 ออกจากตาราง booking
        $delete_query = "DELETE FROM booking WHERE expiration_date <= NOW() OR booking_status = 10";
        if ($conn->query($delete_query) === FALSE) {
            throw new Exception("ไม่สามารถลบการจองที่หมดอายุได้: " . $conn->error);
        }

        // ตรวจสอบจำนวนแถวที่ถูกลบ
        $affected_rows_delete = $conn->affected_rows;

        // ทำการ commit ธุรกรรม
        $conn->commit();

        // แสดงจำนวนแถวที่ได้รับผลกระทบ และเตรียมการ redirect
        $jsMessage = "Swal.fire({
                        title: 'สำเร็จ!',
                        html: 'จำนวนแถวที่ถูกอัปเดตสถานะ: $affected_rows_move<br>จำนวนแถวที่ถูกย้าย: $affected_rows_move<br>จำนวนแถวที่ถูกอัปเดต: $affected_rows_update<br>จำนวนแถวที่ถูกลบ: $affected_rows_delete',
                        icon: 'success',
                        confirmButtonText: 'ตกลง'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';
                        }
                    });";

        if ($affected_rows_delete == 0) {
            break;
        }
    } catch (Exception $e) {
        // ทำการ rollback ธุรกรรมหากเกิดข้อผิดพลาด และเตรียมการ redirect
        $conn->rollback();

        // แสดงข้อผิดพลาดผ่าน SweetAlert และเตรียมการ redirect
        $jsMessage = "Swal.fire({
                        title: 'ข้อผิดพลาด!',
                        html: 'ข้อผิดพลาด: " . addslashes($e->getMessage()) . "',
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';
                        }
                    });";
        break;
    }
} while (true);

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลลัพธ์การดำเนินการ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
</head>

<body>
    <script>
        // Execute the Swal message and handle redirect
        <?php echo $jsMessage; ?>
    </script>
</body>

</html>