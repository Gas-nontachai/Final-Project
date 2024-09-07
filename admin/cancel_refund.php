<?php
session_start();
require("../condb.php");

// ตรวจสอบว่า user ได้ล็อกอินหรือไม่
if (!isset($_SESSION["username"])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาล็อกอินเพื่อดำเนินการ']);
    exit();
}

// ตรวจสอบว่ามีการส่ง booking_id มาใน URL หรือไม่
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // ค้นหาข้อมูลการจองจาก booking_id ที่ส่งมา
    $query = "
        SELECT 
            B.booking_id, 
            CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) AS fullname, 
            B.booking_amount, 
            B.total_price, 
            C.cat_name, 
            SC.sub_cat_name, 
            BS.status, 
            B.booking_type, 
            B.slip_img, 
            B.book_lock_number, 
            B.booking_date, 
            U.user_id,
            U.token
        FROM market_booking.booking AS B
        LEFT JOIN booking_status AS BS ON B.booking_status = BS.id
        LEFT JOIN tbl_user AS U ON B.member_id = U.user_id
        LEFT JOIN category AS C ON B.product_type = C.id_category
        LEFT JOIN sub_category AS SC ON B.sub_product_type = SC.idsub_category
        WHERE B.booking_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // หากพบ booking_id ให้ทำการอัปเดตสถานะเป็น 8
        $row = $result->fetch_assoc();
        $total_price = $row['total_price'];
        $user_id = $row['user_id'];
        $current_token = $row['token'];  // เก็บ token ปัจจุบันของผู้ใช้

        // อัปเดตสถานะการจองเป็น 8
        $update_booking_query = "UPDATE market_booking.booking SET booking_status = 13 WHERE booking_id = ?";
        $stmt_update = $conn->prepare($update_booking_query);
        $stmt_update->bind_param("s", $booking_id);

        if ($stmt_update->execute()) {
            // เพิ่ม token ของผู้ใช้ใน tbl_user
            $new_token = $current_token + $total_price;
            $update_token_query = "UPDATE tbl_user SET token = ? WHERE user_id = ?";
            $stmt_token_update = $conn->prepare($update_token_query);
            $stmt_token_update->bind_param("di", $new_token, $user_id);

            if ($stmt_token_update->execute()) {
                // ย้ายข้อมูลจาก booking ไปยัง booked โดยใช้ prepared statement
                $move_query = "
                    INSERT INTO booked 
                    (booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, booked_lock_number, slip_img, expiration_date)
                    SELECT booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, book_lock_number, slip_img, expiration_date
                    FROM booking
                    WHERE booking_id = ?
                ";

                $stmt_move = $conn->prepare($move_query);
                $stmt_move->bind_param("s", $booking_id);

                if ($stmt_move->execute()) {
                    // ลบข้อมูลออกจาก booking หลังจากย้ายเสร็จ
                    $delete_booking_query = "DELETE FROM booking WHERE booking_id = ?";
                    $stmt_delete = $conn->prepare($delete_booking_query);
                    $stmt_delete->bind_param("s", $booking_id);

                    if ($stmt_delete->execute()) {
                        // ส่งข้อมูล JSON กลับไป
                        echo json_encode([
                            'success' => true,
                            'message' => 'การคืนเงินหมายเลขการจอง ' . $booking_id . ' เสร็จสิ้นแล้ว และ token ของผู้ใช้ถูกอัปเดตเรียบร้อย'
                        ]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูลการจองจาก booking']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการย้ายข้อมูลไปยัง booked']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปเดต token ของผู้ใช้']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปเดตสถานะการจอง']);
        }
    } else {
        // ถ้าไม่พบ booking_id นี้
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลการจองในระบบ']);
    }
} else {
    // ถ้าไม่มีการส่ง booking_id มา
    echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลการจอง']);
}
