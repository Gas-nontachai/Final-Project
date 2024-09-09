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

    $sql = "SELECT BK.booking_status, BK.expiration_date, BK.book_lock_number, U.tel, BK.total_price, BK.booking_id, CONCAT(U.prefix, U.firstname , ' ', U.lastname) AS fullname, BS.status, BK.booking_status, ZD.zone_name, ZD.zone_detail, C.cat_name, SC.sub_cat_name, BK.booking_type, BK.booking_amount, BK.slip_img, BK.booking_date 
            FROM booking AS BK 
            INNER JOIN booking_status AS BS ON BK.booking_status = BS.id
            INNER JOIN tbl_user AS U ON BK.member_id = U.user_id
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
