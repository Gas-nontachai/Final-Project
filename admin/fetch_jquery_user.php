<?php
session_start();
require("../condb.php");

$results_per_page = 6; // Number of users per page
$adjacents = 2; // Number of adjacent pages to show

// Calculate total pages
$sql_total = "SELECT COUNT(*) FROM tbl_user";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_row();
$total_records = $row_total[0];
$total_pages = ceil($total_records / $results_per_page);

// Current page setup
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($total_pages, $current_page)); // Ensure it's within bounds
$start_from = ($current_page - 1) * $results_per_page;

// Prepare the search query
$sql = "SELECT * FROM tbl_user";
$params = [];

if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = trim($_GET['search_query']);
    $sql .= " WHERE user_id LIKE ? OR CONCAT_WS(' ', prefix, firstname, lastname) LIKE ? OR username LIKE ? OR tel LIKE ?";
    $search_wildcard = '%' . $conn->real_escape_string($search_query) . '%';
    $params = [$search_wildcard, $search_wildcard, $search_wildcard, $search_wildcard];
}

// Pagination
$sql .= " LIMIT ?, ?";
$params[] = $start_from;
$params[] = $results_per_page;

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
if ($params) {
    $types = str_repeat('s', count($params) - 2) . 'ii'; // Types for the bind
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    // Display results
    $output = '<table id="myTable" class="table table-striped">
        <thead>
            <tr>
                <th>รหัสสมาชิก</th>
                <th>ชื่อผู้ใช้</th>
                <th>ชื่อเต็ม</th>
                <th>หมายเลขโทรศัพท์</th>
                <th>อีเมล</th>
                <th>ชื่อร้าน</th>
                <th>บทบาทของผู้ใช้</th>
                <th>การกระทำ</th>
            </tr>
        </thead>
        <tbody>';

    // Get the current date
    $current_date = new DateTime();

    foreach ($rows as $row) {
        $fullmembername = htmlspecialchars($row["prefix"] . " " . $row["firstname"] . " " . $row["lastname"]);

        // Check if last_login is older than 365 days
        $last_login = strtotime($row["last_login"]);
        $current_time = time(); // เวลาปัจจุบันในรูปแบบ timestamp
        $one_year_ago = strtotime('-1 year', $current_time); // เวลาหนึ่งปีก่อน

        $disable_delete = $last_login >= $one_year_ago ? 'disabled' : '';

        $output .= "<tr data-user-id='" . htmlspecialchars($row["user_id"]) . "'>
            <td><strong>" . htmlspecialchars($row["user_id"]) . "</strong></td>
            <td>" . htmlspecialchars($row["username"]) . "</td>
            <td>" . $fullmembername . "</td>
            <td>" . htmlspecialchars($row["tel"]) . "</td>
            <td>" . htmlspecialchars($row["email"]) . "</td>
            <td>" . htmlspecialchars($row["shop_name"]) . "</td>
            <td>" . ($row["userrole"] == 1 ? "แอดมิน" : "ผู้ใช้ทั่วไป") . "</td>
            <td class='d-flex'>
                <button class='btn mx-1 btn-sm btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#editModal' data-user-id='" . htmlspecialchars($row["user_id"]) . "'>แก้ไข</button>
                <button class='btn mx-1 btn-sm btn-danger delete-btn' data-user-id='" . htmlspecialchars($row["user_id"]) . "' $disable_delete>ลบ</button>
            </td>
        </tr>";
    }


    $output .= '</tbody></table>
    <script>
        // การคลิกปุ่มแก้ไข
        document.querySelectorAll(\'.edit-btn\').forEach(button => {
            button.addEventListener(\'click\', function() {
                const userId = this.getAttribute(\'data-user-id\');
                fetch(`./get_user.php?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById(\'edit_user_id\').value = data.user_id;
                        document.getElementById(\'edit_username\').value = data.username;
                        document.getElementById(\'edit_password\').value = data.password; // จัดการนี้อย่างปลอดภัย
                        document.getElementById(\'edit_tel\').value = data.tel;
                        document.getElementById(\'edit_email\').value = data.email;
                        document.getElementById(\'edit_token\').value = data.token;
                        document.getElementById(\'edit_shop_name\').value = data.shop_name;
                    });
            });
        });

        document.getElementById(\'editForm\').addEventListener(\'submit\', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            // แสดงค่าของ FormData ในคอนโซล
            for (const [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            fetch(\'update_user.php\', {
                method: \'POST\',
                body: formData
            }).then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire({
                        title: \'สำเร็จ\',
                        text: \'ข้อมูลผู้ใช้ถูกอัปเดตเรียบร้อยแล้ว\',
                        icon: \'success\',
                        confirmButtonText: \'ตกลง\'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: \'ข้อผิดพลาด\',
                        text: result.message || \'ไม่สามารถอัปเดตข้อมูลผู้ใช้ได้\',
                        icon: \'error\',
                        confirmButtonText: \'ตกลง\'
                    });
                }
            }).catch(error => {
                Swal.fire({
                    title: \'ข้อผิดพลาด\',
                    text: \'เกิดข้อผิดพลาดที่ไม่คาดคิด กรุณาลองใหม่อีกครั้งในภายหลัง\',
                    icon: \'error\',
                    confirmButtonText: \'ตกลง\'
                });
            });
        });

        document.querySelectorAll(\'.delete-btn\').forEach(button => {
            button.addEventListener(\'click\', function() {
                const userId = this.getAttribute(\'data-user-id\');
                const canDelete = !this.hasAttribute(\'disabled\');
                if (canDelete) {
                    Swal.fire({
                        title: \'คุณแน่ใจไหม?\',
                        text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
                        icon: \'warning\',
                        showCancelButton: true,
                        confirmButtonColor: \'#3085d6\',
                        cancelButtonColor: \'#d33\',
                        confirmButtonText: \'ใช่, ลบเลย!\'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`delete_user.php?user_id=${userId}`)
                                .then(response => response.json())
                                .then(result => {
                                    if (result.success) {
                                        Swal.fire(\'ลบแล้ว!\', \'ผู้ใช้ถูกลบเรียบร้อยแล้ว\', \'success\').then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(\'ข้อผิดพลาด\', result.message || \'ไม่สามารถลบผู้ใช้ได้\', \'error\');
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(\'ข้อผิดพลาด\', \'เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์\', \'error\');
                                });
                        }
                    });
                } else {
                    Swal.fire(\'ไม่อนุญาต\', \'ไม่สามารถลบผู้ใช้นี้ได้\', \'info\');
                }
            });
        });
    </script>';


    // Pagination
    $pagination = '<ul class="pagination justify-content-center">';
    if ($current_page > 1) {
        $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . ($current_page - 1) . '">Previous</a></li>';
    }

    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            $pagination .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
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

    // Return JSON response
    echo json_encode(['results' => $output, 'pagination' => $pagination]);
} else {
    echo json_encode(['results' => 'ไม่พบข้อมูล', 'pagination' => '']);
}

$stmt->close();
$conn->close();
