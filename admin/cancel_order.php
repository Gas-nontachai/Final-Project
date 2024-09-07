<?php
session_start();
require("../condb.php");

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
        echo json_encode(['success' => true, 'message' => 'Booking successfully cancelled']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Booking not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Booking ID not provided']);
}
