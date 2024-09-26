<?php
require("../condb.php");

if (isset($_POST['booking_id']) && $_POST['booking_id'] > 0) {
    $booking_id = (int)$_POST['booking_id'];
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
                B.booking_date,
                B.expiration_date  
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

        function formatBookingDate($dateString)
        {
            if ($dateString) {
                $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
                if ($dateTime) {
                    $day = $dateTime->format('d');
                    $month = $dateTime->format('n');
                    $year = $dateTime->format('Y') + 543;

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
            }
            return null;
        }

        $bookingDetails['display_expiration_date'] = formatBookingDate($bookingDetails['expiration_date']);
        $bookingDetails['display_booking_date'] = formatBookingDate($bookingDetails['booking_date']);

        // Display booking details
        echo '<table class="table table-striped-columns">';
        echo '<thead><tr><th>หมายเลขการจอง</th><td>' . ($bookingDetails['booking_id'] ?: 'ข้อมูลไม่ถูกต้อง') . '</td></tr></thead>';
        echo '<tbody>';
        echo '<tr><th scope="row">ชื่อ-สกุล</th><td>' . ($bookingDetails['fullname'] ?: 'ข้อมูลไม่ถูกต้อง') . '</td></tr>';
        echo '<tr><th scope="row">จำนวนการจอง</th><td>' . ($bookingDetails['booking_amount'] ?: 'ข้อมูลไม่ถูกต้อง') . '</td></tr>';
        echo '<tr><th scope="row">ราคารวม</th><td>' . ($bookingDetails['total_price'] ?: 'ข้อมูลไม่ถูกต้อง') . '</td></tr>';
        echo '<tr><th scope="row">ประเภทสินค้า</th><td>' . $bookingDetails['cat_name'] . ' (' . $bookingDetails['sub_cat_name'] . ')</td></tr>';
        echo '<tr><th scope="row">สถานะการจอง</th><td>' . ($bookingDetails['status'] ?: 'ข้อมูลไม่ถูกต้อง') . '</td></tr>';
        echo '<tr><th scope="row">ประเภทการจอง</th><td>' . ($bookingDetails['booking_type'] === 'PerDay' ? 'รายวัน' : ($bookingDetails['booking_type'] === 'PerMonth' ? 'รายเดือน' : 'ไม่ทราบประเภทการจอง')) . '</td></tr>';
        echo '<tr><th scope="row">เลขล็อคที่ได้รับ</th><td>' . ($bookingDetails['booked_lock_number'] ?: 'ยังไม่ได้รับเลขล็อคหรือข้อมูลสูญหาย') . '</td></tr>';
        echo '<tr><th scope="row">วันที่จอง</th><td>' . ($bookingDetails['display_booking_date'] ?: 'ข้อมูลไม่ถูกต้อง') . '</td></tr>';
        echo '<tr><th scope="row">วันหมดอายุการจอง</th><td>' . ($bookingDetails['display_expiration_date'] ?: 'ดำเนินการยังไม่เสร็จสิ้น') . '</td></tr>';

        if ($bookingDetails['slip_img']) {
            echo '<tr><th scope="row">รูปภาพใบเสร็จ</th><td><img src="../asset/slip_img/' . $bookingDetails['slip_img'] . '" alt="ภาพใบเสร็จ" class="img-fluid"></td></tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p>ไม่พบการจอง</p>';
    }

    $stmt->close();
} else {
    echo '<p>หมายเลขการจองไม่ถูกต้อง</p>';
}

$conn->close();
