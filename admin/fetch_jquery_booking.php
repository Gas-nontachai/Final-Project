<?php
session_start();
require("../condb.php");

$results_per_page = 10; // กำหนดจำนวนผลลัพธ์ต่อหน้า
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $results_per_page;

// สร้าง SQL สำหรับการค้นหา
$sql = "SELECT B.booking_status, 
            B.booking_id, 
            CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) AS fullname, 
            B.booking_amount, 
            B.total_price, 
            C.cat_name, 
            SC.sub_cat_name, 
            BS.status, 
            B.booking_type 
        FROM booked AS B
        LEFT JOIN booking_status AS BS ON B.booking_status = BS.id
        LEFT JOIN tbl_user AS U ON B.member_id = U.user_id
        LEFT JOIN category AS C ON B.product_type = C.id_category
        LEFT JOIN sub_category AS SC ON B.sub_product_type = SC.idsub_category";

// ตรวจสอบว่ามีการตั้งค่าคำค้นหาหรือไม่
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = $conn->real_escape_string($_GET['search_query']);
    $sql .= " WHERE B.booking_id LIKE '%$search_query%' OR CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) LIKE '%$search_query%'";
}

// การแบ่งหน้า
$sql .= " LIMIT $start_from, $results_per_page";

$result = $conn->query($sql);
$output = '<table class="table table-striped">';
$output .= '<thead><tr><th>รหัสการจอง</th><th>ชื่อ-สกุล</th><th>จำนวนการจองและราคา</th><th>ประเภทสินค้า</th><th>สถานะการจอง</th><th>ประเภทการจอง</th><th>Action</th></tr></thead><tbody>';

function getBadgeClass($status)
{
    switch ($status) {
        case '4':
            return 'bg-success text-white'; // สีเขียว
        case '6':
            return 'bg-danger text-dark'; // สีเหลือง
        case '10':
            return 'bg-danger text-dark'; // สีแดง
        case '11':
            return 'bg-danger text-white'; // สีน้ำเงิน
        default:
            return 'bg-secondary text-white'; // สีเทา สำหรับสถานะอื่น ๆ
    }
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // กำหนดประเภทการจอง
        switch ($row["booking_type"]) {
            case 'PerDay':
                $booking_type_display = 'รายวัน';
                break;
            case 'PerMonth':
                $booking_type_display = 'รายเดือน';
                break;
            default:
                $booking_type_display = 'ไม่ทราบประเภทการจอง';
                break;
        }

        // ปรับรูปแบบของข้อมูลที่แสดง
        $output .= '<tr>';
        $output .= '<td><strong>' . (is_null($row["booking_id"]) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : htmlspecialchars($row["booking_id"])) . '</strong></td>';
        $output .= '<td>' . (is_null($row['fullname']) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : htmlspecialchars($row['fullname'])) . '</td>';
        $output .= '<td>' . (is_null($row['booking_amount']) || is_null($row['total_price']) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : htmlspecialchars($row['booking_amount']) . ' ล็อค รวม: ' . htmlspecialchars($row['total_price']) . ' ฿') . '</td>';
        $output .= '<td>' . (is_null($row['cat_name']) || is_null($row['sub_cat_name']) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : htmlspecialchars($row['cat_name']) . ' (' . htmlspecialchars($row['sub_cat_name']) . ')') . '</td>';
        $output .= '<td>' . (is_null($row['status']) ?
            "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" :
            "<span class='badge " . getBadgeClass($row['booking_status']) . "'>" . htmlspecialchars($row['status']) . "</span>") . '</td>';
        $output .= '<td>' . (is_null($booking_type_display) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : htmlspecialchars($booking_type_display)) . '</td>';
        $output .= '<td><button class="btn btn-primary">ดู</button></td>';
        $output .= '</tr>';
    }
} else {
    $output .= '<tr><td colspan="7">ไม่พบข้อมูล</td></tr>';
}
$output .= '</tbody></table>';

// Pagination
$sql_total = "SELECT COUNT(*) FROM booked";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_row();
$total_records = $row_total[0];
$total_pages = ceil($total_records / $results_per_page);

$pagination = '<ul class="pagination justify-content-center">';
if ($current_page > 1) {
    $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . ($current_page - 1) . '">Previous</a></li>';
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $current_page) {
        $pagination .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
    } else {
        // Show '...' when there are gaps between pages
        if ($i == 1 || $i == $total_pages || ($i >= $current_page - 1 && $i <= $current_page + 1)) {
            $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
        } elseif ($pagination[strlen($pagination) - 1] !== '...' && ($i == 2 || $i == $total_pages - 1)) {
            $pagination .= '<li class="page-item"><span class="page-link">...</span></li>';
        }
    }
}

if ($current_page < $total_pages) {
    $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . ($current_page + 1) . '">Next</a></li>';
}
$pagination .= '</ul>';


// ส่งผลลัพธ์เป็น JSON
echo json_encode(['results' => $output, 'pagination' => $pagination]);

$conn->close();
