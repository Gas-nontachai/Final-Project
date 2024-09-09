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
if (!isset($_SESSION["username"])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch booking details
    $query = "SELECT * FROM market_booking.booking WHERE booking_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $booking_id);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error executing query: ' . $stmt->error]);
        exit();
    }
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch booking details
        $row = $result->fetch_assoc();

        // Update booking status
        $update_booking_query = "UPDATE market_booking.booking SET booking_status = 12 WHERE booking_id = ?";
        $stmt_update = $conn->prepare($update_booking_query);
        $stmt_update->bind_param("s", $booking_id);
        if (!$stmt_update->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error updating booking status: ' . $stmt_update->error]);
            exit();
        }

        // Move booking to booked table
        $move_query = "INSERT INTO booked (booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, booked_lock_number, slip_img, expiration_date)
                        SELECT booking_id, member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date, book_lock_number, slip_img, expiration_date
                        FROM booking WHERE booking_id = ?";
        $stmt_move = $conn->prepare($move_query);
        $stmt_move->bind_param("s", $booking_id);
        if (!$stmt_move->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error moving booking: ' . $stmt_move->error]);
            exit();
        }

        // Delete booking from the booking table
        $delete_booking_query = "DELETE FROM booking WHERE booking_id = ?";
        $stmt_delete = $conn->prepare($delete_booking_query);
        $stmt_delete->bind_param("s", $booking_id);
        if (!$stmt_delete->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error deleting booking: ' . $stmt_delete->error]);
            exit();
        }

        // Success response
        echo json_encode(['success' => true, 'message' => 'ยกเลิกการจองเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบการจอง']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ไม่ได้ระบุรหัสการจอง']);
}
