<?php
session_start();
require("../condb.php");

if (isset($_POST['fetch_booking_details'])) {
    $booking_id = intval($_POST['booking_id']);

    $sql = "SELECT 
                B.booking_id, 
                CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) AS fullname, 
                B.booking_amount, 
                B.total_price, 
                C.cat_name, 
                SC.sub_cat_name, 
                BS.status, 
                B.booking_type, 
                B.slip_img, 
                B.booked_lock_number, 
                B.booking_date
            FROM market_booking.booked AS B
            LEFT JOIN booking_status AS BS ON B.booking_status = BS.id
            LEFT JOIN tbl_user AS U ON B.member_id = U.user_id
            LEFT JOIN category AS C ON B.product_type = C.id_category
            LEFT JOIN sub_category AS SC ON B.sub_product_type = SC.idsub_category
            WHERE B.booking_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $bookingDetails = $result->fetch_assoc();
        echo json_encode($bookingDetails);
    } else {
        echo json_encode(['error' => 'ไม่พบการจอง']);
    }
    $stmt->close();
    $conn->close();
    exit;
}
?>
