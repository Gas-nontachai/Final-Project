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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <form id="searchForm" method="GET">
                        <div class="input-group mb-3">
                            <input class="form-control" id="search" type="text" name="search_query" placeholder="ค้นหาด้วยรหัสสมาชิก ชื่อนามสกุล ชื่อผู้ใช้ หรือหมายเลขโทรศัพท์" value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
                            <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                            <a href="?reset=true" class="btn btn-outline-secondary">รีเซ็ต</a>
                        </div>
                    </form>

                    <div id="resultsContainer">
                        <!-- ผลลัพธ์ที่ค้นหาจะแสดงที่นี่ -->
                    </div>

                    <nav id="paginationNav" aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="paginationLinks"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadData(); // โหลดข้อมูลเมื่อเริ่มต้น
            $(document).on('click', '#paginationLinks .page-link', function(e) {
                e.preventDefault(); // ป้องกันการโหลดหน้าใหม่
                var page = $(this).attr('data-page'); // ดึงหมายเลขหน้าจาก data attribute
                loadData(page); // โหลดข้อมูลด้วยหมายเลขหน้า
            });

            // เมื่อมีการพิมพ์ในฟิลด์ค้นหา
            $('#search').on('input', function() {
                loadData(); // โหลดข้อมูลใหม่เมื่อมีการค้นหา
            });

            function loadData(page = 1) {
                var searchQuery = $('#search').val(); // รับค่าการค้นหา

                $.ajax({
                    url: 'fetch_jquery_user.php', // URL ของ PHP ที่จัดการกับการค้นหา
                    method: 'GET',
                    data: {
                        search_query: searchQuery,
                        page: page // ส่งหมายเลขหน้าไปด้วย
                    },
                    success: function(data) {
                        // ตรวจสอบว่าข้อมูลที่ได้รับคือ JSON หรือไม่
                        try {
                            var jsonData = JSON.parse(data); // แปลง JSON string เป็น object

                            // แสดงผลลัพธ์ใน #resultsContainer
                            $('#resultsContainer').html(jsonData.results);

                            // แสดงผลลัพธ์ของ pagination
                            $('#paginationLinks').html(jsonData.pagination);
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#resultsContainer').html('ไม่สามารถแสดงผลลัพธ์ได้');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $('#resultsContainer').html('เกิดข้อผิดพลาดในการเชื่อมต่อ');
                    }
                });
            }

        });
    </script>



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