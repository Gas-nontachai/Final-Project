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

        // Determine the booking type display
        if ($bookingDetails["booking_type"] === 'PerDay') {
            $bookingDetails['booking_type_display'] = 'รายวัน';
        } elseif ($bookingDetails["booking_type"] === 'PerMonth') {
            $bookingDetails['booking_type_display'] = 'รายเดือน';
        } else {
            $bookingDetails['booking_type_display'] = 'ไม่ทราบประเภทการจอง';
        }

        echo json_encode($bookingDetails);
    } else {
        echo json_encode(['error' => 'ไม่พบการจอง']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
