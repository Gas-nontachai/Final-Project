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
                B.expiration_date, 
                C.cat_name, 
                SC.sub_cat_name, 
                BS.status, 
                B.booking_type, 
                B.slip_img, 
                B.book_lock_number, 
                B.booking_date
            FROM market_booking.booking AS B
            LEFT JOIN booking_status AS BS ON B.booking_status = BS.id
            LEFT JOIN tbl_user AS U ON B.member_id = U.user_id
            LEFT JOIN category AS C ON B.product_type = C.id_category
            LEFT JOIN sub_category AS SC ON B.sub_product_type = SC.idsub_category
            WHERE B.booking_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $bookingDetails = $result->fetch_assoc();

            // ฟังก์ชันในการปรับฟอร์แมตวันที่
            function formatBookingDate($dateString)
            {
                $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
                if ($dateTime) {
                    $day = $dateTime->format('d');
                    $month = $dateTime->format('n');
                    $year = $dateTime->format('Y') + 543; // เพิ่มปี 543

                    $monthsTh = [
                        1 => 'ม.ค.',
                        2 => 'ก.พ.',
                        3 => 'มี.ค.',
                        4 => 'เม.ย.',
                        5 => 'พ.ค.',
                        6 => 'มิ.ย.',
                        7 => 'ก.ค.',
                        8 => 'ส.ค.',
                        9 => 'ก.ย.',
                        10 => 'ต.ค.',
                        11 => 'พ.ย.',
                        12 => 'ธ.ค.'
                    ];

                    return sprintf(
                        '%s/%s/%s เวลา %s:%s',
                        $day,
                        $monthsTh[$month],
                        $year,
                        $dateTime->format('H'),
                        $dateTime->format('i')
                    );
                }
                return null;
            }

            // ปรับฟอร์แมตวันที่
            $bookingDetails['display_booking_date'] = !empty($bookingDetails['booking_date']) ? formatBookingDate($bookingDetails['booking_date']) : null;
            $bookingDetails['display_expiration_date'] = !empty($bookingDetails['expiration_date']) ? formatBookingDate($bookingDetails['expiration_date']) : null;

            // Determine the booking type display
            switch ($bookingDetails["booking_type"]) {
                case 'PerDay':
                    $bookingDetails['booking_type_display'] = 'รายวัน';
                    break;
                case 'PerMonth':
                    $bookingDetails['booking_type_display'] = 'รายเดือน';
                    break;
                default:
                    $bookingDetails['booking_type_display'] = 'ไม่ทราบประเภทการจอง';
                    break;
            }

            echo json_encode($bookingDetails);
        } else {
            echo json_encode(['error' => 'ไม่พบการจอง']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'ข้อผิดพลาดในการเตรียมคำสั่ง SQL']);
    }

    $conn->close();
    exit;
}
