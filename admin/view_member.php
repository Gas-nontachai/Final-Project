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
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                        window.location.href = "../login.php";
                    
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

if ($userrole == 0) {
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
    <style>
        body {
            background-image: url(../asset/img/img.market2.jpg);
            width: 100%;
            height: 100%;
            background-repeat: repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <!-- Nav -->
    <?php include('./admin_nav.php'); ?>

    <!-- Display -->
    <div class="container my-4 px-2 border bgcolor py-4 rounded overflow-auto" style="width: 90%; height: 40rem;">
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
                    // กำหนดค่า $results_per_page
                    $results_per_page = 5; // จำนวนสมาชิกที่ต้องการแสดงต่อหน้า

                    // คำนวณจำนวนหน้าทั้งหมด
                    $sql_total = "SELECT COUNT(*) FROM tbl_user";
                    $result_total = $conn->query($sql_total);
                    $row_total = $result_total->fetch_row();
                    $total_records = $row_total[0];

                    // ตรวจสอบว่า $results_per_page มากกว่า 0
                    if ($results_per_page > 0) {
                        $total_pages = ceil($total_records / $results_per_page);
                    } else {
                        echo "Error: Results per page must be greater than 0.";
                        exit;
                    }

                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $adjacents = 1; // จำนวนหน้าที่จะแสดงข้างหน้าและข้างหลังเลขหน้า

                    echo "<nav>";
                    echo "<ul class='pagination justify-content-center'>";

                    // ปุ่ม Previous
                    if ($current_page > 1) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page - 1) . "'>Previous</a></li>";
                    }

                    // แสดงปุ่มเลขหน้า
                    if ($total_pages <= (1 + ($adjacents * 2))) {
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $current_page) {
                                echo "<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                            }
                        }
                    } else {
                        if ($current_page <= ($adjacents * 2)) {
                            for ($i = 1; $i <= (1 + ($adjacents * 2)); $i++) {
                                if ($i == $current_page) {
                                    echo "<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                                }
                            }
                            echo "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page=" . $total_pages . "'>" . $total_pages . "</a></li>";
                        } elseif ($current_page > ($total_pages - ($adjacents * 2))) {
                            echo "<li class='page-item'><a class='page-link' href='?page=1'>1</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                            for ($i = ($total_pages - (1 + ($adjacents * 2))); $i <= $total_pages; $i++) {
                                if ($i == $current_page) {
                                    echo "<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                                }
                            }
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='?page=1'>1</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                            for ($i = ($current_page - $adjacents); $i <= ($current_page + $adjacents); $i++) {
                                if ($i == $current_page) {
                                    echo "<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                                }
                            }
                            echo "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page=" . $total_pages . "'>" . $total_pages . "</a></li>";
                        }
                    }

                    // ปุ่ม Next
                    if ($current_page < $total_pages) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page + 1) . "'>Next</a></li>";
                    }

                    echo "</ul>";
                    echo "</nav>";

                    // ค้นหาข้อมูลตาม search_query
                    $sql = "SELECT * FROM tbl_user";
                    if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
                        $search_query = $conn->real_escape_string($_GET['search_query']);
                        $sql .= " WHERE user_id LIKE '%$search_query%' 
                OR CONCAT_WS(' ', prefix, firstname, lastname) LIKE '%$search_query%' 
                OR username LIKE '%$search_query%' 
                OR tel LIKE '%$search_query%'";
                    }

                    if (isset($_GET['reset'])) {
                        $sql = "SELECT * FROM tbl_user";
                    }

                    // การแบ่งหน้า
                    $start_from = ($current_page - 1) * $results_per_page;
                    $sql .= " LIMIT $start_from, $results_per_page";

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
                            $fullmembername = htmlspecialchars($row["prefix"] . " " . $row["firstname"] . " " . $row["lastname"]);
                            $password = htmlspecialchars($row["password"]);
                            $canDelete = (strtotime($row['last_login']) < strtotime('-1 year')) ? '' : 'disabled';
                            echo "<tr data-user-id='" . htmlspecialchars($row["user_id"]) . "'>";
                            echo "<td><strong>" . htmlspecialchars($row["user_id"]) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                            echo "<td><span class='password-toggle' data-password='$password'>********</span></td>";
                            echo "<td>" . $fullmembername . "</td>";
                            echo "<td>" . htmlspecialchars($row["tel"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["shop_name"]) . "</td>";
                            echo "<td>" . ($row["userrole"] == 1 ? "แอดมิน" : "ผู้ใช้ทั่วไป") . "</td>";
                            echo "<td class='d-flex'>
                        <button class='btn mx-1 btn-sm btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#editModal' data-user-id='" . htmlspecialchars($row["user_id"]) . "'>แก้ไข</button>
                        <button class='btn mx-1 btn-sm btn-danger delete-btn' $canDelete data-user-id='" . htmlspecialchars($row["user_id"]) . "'>ลบ</button>
                    </td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
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
                            <label for="edit_tel" class="form-label">เบอร์โทรศัพท์</label>
                            <input oninput="check_tel()" type="tel" class="form-control" name="tel" id="edit_tel">
                            <span id="span_tel" class=""></span>
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
        function check_tel() {
            var input = document.getElementById('edit_tel');
            var value = input.value;
            const span_tel = document.getElementById('span_tel');

            if (value.length < 10) {
                span_tel.style.color = "red";
                span_tel.textContent = "กรุณากรอกให้ครบ 10 หลัก";
            } else if (value.length > 10) {
                span_tel.style.color = "yellow";
                span_tel.textContent = "กรุณากรอกไม่เกิน 10 หลัก";
                input.value = value.slice(0, 10);

                setTimeout(function() {
                    span_tel.style.color = "green";
                    span_tel.textContent = "ครบ 10 หลัก";
                }, 2000);
            } else {
                span_tel.style.color = "green";
                span_tel.textContent = "ครบ 10 หลัก";
            }

            return true;
        }
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
                document.getElementById('togglePassword').textContent = isVisible ? 'แสดง' : 'ซ่อน';
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