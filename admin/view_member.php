<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>กรุณาล็อคอินก่อน</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "กรุณาล็อคอินก่อน",
                    icon: "error",
                    timer: 2000, 
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "../admin/login.php";
                    }
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$shop_name = $_SESSION["shop_name"];
$prefix = $_SESSION["prefix"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$tel = $_SESSION["tel"];
$email = $_SESSION["email"];
$userrole = $_SESSION["userrole"];
$fullname = $prefix . ' ' . $firstname . ' ' . $lastname;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Nav -->
    <?php include('./admin_nav.php'); ?>

    <!-- Display -->
    <div class="container my-4 p-2 border border-dark-subtle rounded overflow-auto" style="width: 90%; height: 40rem;">
        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#categort"><strong>สมาชิกในระบบ</strong></a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-2 mx-2 p-2" id="categort">
                <div>
                    <h1>สมาชิกในระบบ</h1>
                </div>
                <div class="mt-2">
                    <form method="GET">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="search_query" placeholder="ค้นหาด้วยรหัสสมาชิก ชื่อนามสกุล ชื่อผู้ใช้ หรือหมายเลขโทรศัพท์" value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
                            <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                            <a href="?reset=true" class="btn btn-outline-secondary">รีเซ็ต</a>
                        </div>
                    </form>
                    <?php
                    // จำนวนระเบียนต่อหน้า
                    $records_per_page = 10;

                    // รับหน้าปัจจุบันจาก query string, ถ้าไม่ตั้งค่าให้ค่าเริ่มต้นเป็น 1
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                    // คำนวณระเบียนเริ่มต้นสำหรับหน้าปัจจุบัน
                    $start_from = ($current_page - 1) * $records_per_page;

                    // สร้างคำสั่ง SQL ด้วยการแบ่งหน้า
                    $sql = "SELECT * FROM tbl_user";

                    if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
                        $search_query = $_GET['search_query'];
                        $sql .= " WHERE user_id LIKE '%$search_query%' 
                          OR CONCAT_WS(' ', prefix, firstname, lastname) LIKE '%$search_query%' 
                          OR username LIKE '%$search_query%'
                          OR tel LIKE '%$search_query%'";
                    }

                    if (isset($_GET['reset'])) {
                        $sql = "SELECT * FROM tbl_user";
                    }

                    // นับจำนวนระเบียนทั้งหมด
                    $total_records_sql = $sql;
                    $result_count = $conn->query($total_records_sql);
                    $total_records = $result_count->num_rows;

                    // แก้ไขคำสั่ง SQL เพื่อรวม LIMIT และ OFFSET สำหรับการแบ่งหน้า
                    $sql .= " LIMIT $start_from, $records_per_page";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='table table-striped'>";
                        echo "<thead>
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
                </thead>";
                        echo "<tbody>";

                        while ($row = $result->fetch_assoc()) {
                            $fullmembername = $row["prefix"] . "" . $row["firstname"] . " " . $row["lastname"];
                            $password = htmlspecialchars($row["password"]); // ทำความสะอาดข้อมูลเพื่อความปลอดภัย
                            $canDelete = (strtotime($row['last_login']) < strtotime('-1 year')) ? '' : 'disabled';
                            echo "<tr data-user-id='" . $row["user_id"] . "'>";
                            echo "<td><strong>" . $row["user_id"] . "</strong></td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td><span class='password-toggle' data-password='$password'>********</span></td>";
                            echo "<td>" . $fullmembername . "</td>";
                            echo "<td>" . $row["tel"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["shop_name"] . "</td>";
                            echo "<td>" . $row["userrole"] . "
                        <span class='question-icon mx-2' data-bs-toggle='tooltip' data-bs-placement='right' title='0 ผู้ใช้งานทั่วไป<br>1 แอดมิน/ผู้ดูแลระบบ'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-patch-question-fill' viewBox='0 0 16 16'>
                                <path d='M5.933.87a2.89 2.89 0 0 1 4.134 0l.622.638.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622-.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01zM7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0m1.602-2.027c.04-.534.198-.815.846-1.26.674-.475 1.05-1.09 1.05-1.986 0-1.325-.92-2.227-2.262-2.227-1.02 0-1.792.492-2.1 1.29A1.7 1.7 0 0 0 6 5.48c0 .393.203.64.545.64.272 0 .455-.147.564-.51.158-.592.525-.915 1.074-.915.61 0 1.03.446 1.03.96 0 .556-.433.867-1.014 1.318-.725.485-.947.821-.948 1.27z'/>
                            </svg>
                        </span></td>";
                            echo "<td class='d-flex'>
                    <button class='btn mx-1 btn-sm btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#editModal' data-user-id='" . $row["user_id"] . "'>แก้ไข</button>
                        <button class='btn mx-1 btn-sm btn-danger delete-btn' $canDelete data-user-id='" . $row["user_id"] . "'>ลบ</button>
                        </td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";

                        // การควบคุมการแบ่งหน้า
                        $total_pages = ceil($total_records / $records_per_page);
                        echo "<nav aria-label='Page navigation'>";
                        echo "<ul class='pagination'>";

                        for ($page = 1; $page <= $total_pages; $page++) {
                            $active = ($page == $current_page) ? 'active' : '';
                            echo "<li class='page-item $active'><a class='page-link' href='?page=$page" . (isset($_GET['search_query']) ? "&search_query=" . urlencode($_GET['search_query']) : '') . "'>$page</a></li>";
                        }

                        echo "</ul>";
                        echo "</nav>";
                    } else {
                        echo "ไม่พบข้อมูล";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal แก้ไข -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">แก้ไขผู้ใช้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_user_id" name="user_id">
                        <div class="mb-3">
                            <label for="edit_username" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" id="edit_username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="edit_shop_name" class="form-label">ชื่อร้านค้า</label>
                            <input type="text" class="form-control" id="edit_shop_name" name="shop_name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">รหัสผ่าน</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="edit_password" name="password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">แสดง</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tel" class="form-label">โทรศัพท์</label>
                            <input type="text" class="form-control" id="edit_tel" name="tel">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_token" class="form-label">เหรียญ</label>
                            <input type="number" class="form-control " id="edit_token" name="token">
                        </div>
                        <div class="mb-3 row">
                            <label for="userRoleSelect" class="col-sm-3 col-form-label"><strong>ประเภทผู้ใช้งาน:</strong></label>
                            <div class="col-sm-9">
                                <select id="userRoleSelect" class="form-control" name="user_role">
                                    <option value="0">ผู้ใช้งานทั่วไป</option>
                                    <option value="1">แอดมิน/ผู้ดูแลระบบ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9K8l8BA+Gz2D40/2dPj4cHPm0w43FA9e2k8I4pU1U7e5S9K7c02" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-VoPF2pPpG8kc7Us7A5qOYeZ8y7Gz7W0C3P2BujJ8JhJ6O1KoFnvXtHktv5I4SKfQ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // การสลับการแสดงรหัสผ่าน
            document.querySelectorAll('.password-toggle').forEach(el => {
                el.addEventListener('click', () => {
                    const isVisible = el.classList.toggle('visible-password');
                    el.textContent = isVisible ? el.dataset.password : '********';
                });
            });

            // การสลับการแสดงรหัสผ่านใน Modal แก้ไข
            document.getElementById('togglePassword').addEventListener('click', () => {
                const passwordField = document.getElementById('edit_password');
                const isVisible = passwordField.type === 'text';
                passwordField.type = isVisible ? 'password' : 'text';
                document.getElementById('togglePassword').textContent = isVisible ? 'Show' : 'Hide';
            });

            // การคลิกปุ่มแก้ไข
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    fetch(`./get_user.php?user_id=${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('edit_user_id').value = data.user_id;
                            document.getElementById('edit_username').value = data.username;
                            document.getElementById('edit_password').value = data.password; // จัดการนี้อย่างปลอดภัย
                            document.getElementById('edit_tel').value = data.tel;
                            document.getElementById('edit_email').value = data.email;
                            document.getElementById('edit_token').value = data.token;
                            document.getElementById('edit_shop_name').value = data.shop_name;
                        });
                });
            });

            document.getElementById('editForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                // แสดงค่าของ FormData ในคอนโซล
                for (const [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                fetch('update_user.php', {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            Swal.fire({
                                title: 'สำเร็จ',
                                text: 'ข้อมูลผู้ใช้ถูกอัปเดตเรียบร้อยแล้ว',
                                icon: 'success',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'ข้อผิดพลาด',
                                text: result.message || 'ไม่สามารถอัปเดตข้อมูลผู้ใช้ได้',
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            title: 'ข้อผิดพลาด',
                            text: 'เกิดข้อผิดพลาดที่ไม่คาดคิด กรุณาลองใหม่อีกครั้งในภายหลัง',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    });
            });


            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const canDelete = !this.hasAttribute('disabled');
                    if (canDelete) {
                        Swal.fire({
                            title: 'คุณแน่ใจไหม?',
                            text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ใช่, ลบเลย!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`delete_user.php?user_id=${userId}`)
                                    .then(response => response.json())
                                    .then(result => {
                                        if (result.success) {
                                            Swal.fire('ลบแล้ว!', 'ผู้ใช้ถูกลบเรียบร้อยแล้ว', 'success').then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('ข้อผิดพลาด', result.message || 'ไม่สามารถลบผู้ใช้ได้', 'error');
                                        }
                                    })
                                    .catch(error => {
                                        Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
                                    });
                            }
                        });
                    } else {
                        Swal.fire('ไม่อนุญาต', 'ไม่สามารถลบผู้ใช้นี้ได้', 'info');
                    }
                });
            });

        });
    </script>

</body>

</html>