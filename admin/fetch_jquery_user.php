<?php
session_start();
require("../condb.php");

$results_per_page = 5; // จำนวนสมาชิกที่ต้องการแสดงต่อหน้า
$adjacents = 2; // จำนวนหน้าใกล้เคียงที่จะแสดง

// คำนวณจำนวนหน้าทั้งหมด
$sql_total = "SELECT COUNT(*) FROM tbl_user";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_row();
$total_records = $row_total[0];
$total_pages = ceil($total_records / $results_per_page);

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($current_page - 1) * $results_per_page;

// ค้นหาข้อมูลตาม search_query
$sql = "SELECT * FROM tbl_user";
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = $conn->real_escape_string($_GET['search_query']);
    $sql .= " WHERE user_id LIKE '%$search_query%'
OR CONCAT_WS(' ', prefix, firstname, lastname) LIKE '%$search_query%'
OR username LIKE '%$search_query%'
OR tel LIKE '%$search_query%'";
}

// การแบ่งหน้า
$sql .= " LIMIT $start_from, $results_per_page";

$result = $conn->query($sql);
$rows = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    // แสดงผลลัพธ์
    $output = '<table id="myTable" class="table table-striped">
    <thead>
        <tr>
            <th>รหัสสมาชิก</th>
            <th>ชื่อผู้ใช้</th>
            <th>รหัสผ่าน</th>
            <th>ชื่อเต็ม</th>
            <th>หมายเลขโทรศัพท์</th>
            <th>อีเมล</th>
            <th>ชื่อร้าน</th>
            <th>บทบาทของผู้ใช้</th>
            <th>การกระทำ</th>
        </tr>
    </thead>
    <tbody>';

    foreach ($rows as $row) {
        $fullmembername = htmlspecialchars($row["prefix"] . " " . $row["firstname"] . " " . $row["lastname"]);
        $password = htmlspecialchars($row["password"]);
        $output .= "<tr data-user-id='" . htmlspecialchars($row["user_id"]) . "'>
            <td><strong>" . htmlspecialchars($row["user_id"]) . "</strong></td>
            <td>" . htmlspecialchars($row["username"]) . "</td>
            <td><span class='password-toggle' data-password='$password'>********</span></td>
            <td>" . $fullmembername . "</td>
            <td>" . htmlspecialchars($row["tel"]) . "</td>
            <td>" . htmlspecialchars($row["email"]) . "</td>
            <td>" . htmlspecialchars($row["shop_name"]) . "</td>
            <td>" . ($row["userrole"] == 1 ? "แอดมิน" : "ผู้ใช้ทั่วไป") . "</td>
            <td class='d-flex'>
                <button class='btn mx-1 btn-sm btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#editModal' data-user-id='" . htmlspecialchars($row["user_id"]) . "'>แก้ไข</button>
                <button class='btn mx-1 btn-sm btn-danger delete-btn' data-user-id='" . htmlspecialchars($row["user_id"]) . "'>ลบ</button>
            </td>
        </tr>";
    }

    $output .= '</tbody>
</table>';

    // Pagination
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
} else {
    echo json_encode(['results' => 'ไม่พบข้อมูล', 'pagination' => '']);
}
