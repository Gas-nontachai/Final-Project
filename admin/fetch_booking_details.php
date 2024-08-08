<?php
session_start();
require("../condb.php");

if (isset($_POST['fetch_booking_details'])) {
    $booking_id = intval($_POST['booking_id']);

    $sql = "SELECT BK.booking_id, BK.book_lock_number, ZD.zone_name, ZD.zone_detail, C.cat_name, SC.sub_cat_name, BK.booking_type, BK.booking_status, BK.booking_amount, BK.slip_img, BS.status, BK.booking_date 
            FROM booking AS BK 
            INNER JOIN booking_status AS BS ON BK.booking_status = BS.id
            INNER JOIN category AS C ON BK.product_type = C.id_category
            INNER JOIN sub_category AS SC ON BK.sub_product_type = SC.idsub_category
            INNER JOIN zone_detail AS ZD ON BK.zone_id = ZD.zone_id
            WHERE BK.booking_id = ?";

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
