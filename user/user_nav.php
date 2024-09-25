<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .swal2-container {
            z-index: 9999 !important;
            /* ปรับค่าให้เหมาะสมตามที่ต้องการ */
        }

        .bgcolor {
            background-color: rgba(255, 255, 255, 0.9);
            padding-bottom: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .modal-backdrop {
            z-index: 1040 !important;
            /* ให้ backdrop อยู่ต่ำกว่า navbar */
        }
    </style>
</head>
<nav style="width: 100%;" class="navbar navbar-expand-lg navbar-light bg-light">
    <div style="width: 100%;" class=" d-flex flex-column ">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="./index.php" class="icon-link icon-link-hover nav-link active" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);">
                            <i class="bi bi-house-door"></i> หน้าแรก
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./order.php" class="icon-link icon-link-hover nav-link active" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);">
                            <i class="bi bi-pencil-square"></i> จองพื้นที่การขาย
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./booking_history.php" class="icon-link icon-link-hover nav-link active" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);">
                            <i class="bi bi-clock-history"></i> ประวัติการจอง
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./comment_page.php" class="icon-link icon-link-hover nav-link active" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);">
                            <i class="bi bi-chat-dots"></i> แสดงความคิดเห็นตลาด
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../asset/pdf/คู่มือการใช้งานสำหรับผู้ใช้งาน.pdf" target="_blank" class="icon-link icon-link-hover nav-link active" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);">
                            <i class="bi bi-file-earmark-text"></i> คู่มือการใช้งาน
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./contactus.php" class="icon-link icon-link-hover nav-link active" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);">
                            <i class="bi bi-envelope"></i> ช่องทางการติดต่อ
                        </a>
                    </li>
                </ul>

                <a class="navbar-brand" href="./index.php">จองล็อค.คอม</a>
            </div>
            <button id="navbar-toggler" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <!-- Timer -->
        <div class="col-12 d-flex justify-content-between px-2">
            <div>
                <?php
                require("../condb.php");

                $currentTime = date('H:i:s'); // เวลาปัจจุบัน
                // ดึงข้อมูลจาก database
                $sql_time = "SELECT opening_time, closing_time FROM operating_hours LIMIT 1";
                $result = $conn->query($sql_time);
                $row_time = $result->fetch_assoc();

                $openingTime = $row_time['opening_time'];
                $closingTime = $row_time['closing_time'];
                ?>
                <span id="time"></span>
                <span id="status"></span>
                <div id="opening_time">เวลาเปิด-ปิดระบบ(
                    <?php echo $openingTime; ?> - <?php echo $closingTime; ?>
                    )
                </div>

            </div>

            <!-- profile btn -->
            <div class="d-flex  justify-content-between ">

                <div class="d-flex  align-items-center">
                    <div class="col d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-coin"
                            viewBox="0 0 16 16">
                            <path
                                d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z" />
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                        </svg>
                        <p class="ms-1">
                            <strong>
                                <?php
                                echo $_SESSION["token"];
                                ?>
                            </strong>

                        </p>
                    </div>
                    <button class="btn " type="button" data-bs-toggle="modal" data-bs-target="#ProfileModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle"
                            viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="ProfileModal" tabindex="-1" aria-labelledby="ProfileModalLabel" aria-hidden="true">
    <?php
    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("SELECT user_id, username, shop_name, tel, email, token, 
                                  firstname, lastname, userrole, 
                                  CONCAT(prefix, firstname, ' ', lastname) AS fullname
                        FROM market_booking.tbl_user
                        WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    // Bind the results to variables
    $stmt->bind_result($SQLuser_id, $SQLusername, $SQLshop_name, $SQLtel, $SQLemail, $SQLtoken, $SQLfirstname, $SQLlastname, $SQLuserrole, $SQLfullname);
    // Fetch the results
    $stmt->fetch();
    // Output the token (or any other variable as needed)
    $token = htmlspecialchars($SQLtoken);
    ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ProfileModalLabel"><strong>โปรไฟล์ผู้ใช้งาน</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">รหัสสมาชิก:</th>
                            <td><?php echo $SQLuser_id; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">ชื่อผู้ใช้(Username):</th>
                            <td><?php echo $SQLusername; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">ชื่อร้าน:</th>
                            <td><?php echo $SQLshop_name; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">ชื่อ-นามสกุล:</th>
                            <td><?php echo $SQLfullname; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">เบอร์โทรศัพท์:</th>
                            <td><?php echo $SQLtel; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">อีเมล:</th>
                            <td><?php echo $SQLemail; ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="mb-3 row">
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-user-id="<?php echo $user_id; ?>">ลบโปรไฟล์</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#EditModal">แก้ไขโปรไฟล์</button>
                <a href='#' class='btn btn-danger' onclick="confirmLogout()">ออกจากระบบ</a>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Edit Profile Modal -->
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update_profile.php" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EditModalLabel"><strong>โปรไฟล์ผู้ใช้งาน</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>รหัสสมาชิก:</strong> <?php echo $SQLuser_id; ?></p>
                    <p><strong>ชื่อผู้ใช้(Username):</strong> <?php echo $SQLusername; ?></p>
                    <div class="mb-3 row">
                        <label for="shopname" class="col-sm-3 col-form-label"><strong>ชื่อร้านค้า:</strong></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="editshopname" id="editshopname" value="<?php echo $SQLshop_name; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="fullname" class="col-sm-3 col-form-label"><strong>ชื่อ-นามสกุล:</strong></label>
                        <div class="col-sm-3">
                            <select id="prefixSelect" class="form-control" name="editprefix">
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="editfirstname" value="<?php echo $SQLfirstname; ?>">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="editlastname" value="<?php echo $SQLlastname; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tel" class="col-sm-3 col-form-label"><strong>เบอร์โทรศัพท์:</strong></label>
                        <div class="col-sm-9">
                            <input oninput="check_tel()" type="tel" class="form-control" name="edittel" id="edittel" value="<?php echo $SQLtel; ?>">
                            <span id="span_tel" class=""></span>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label"><strong>อีเมล:</strong></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="editemail" id="editemail" value="<?php echo $SQLemail; ?>">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">อัพเดตโปรไฟล์</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require("../condb.php");

$currentTime = date('H:i:s'); // เวลาปัจจุบัน
// ดึงข้อมูลจาก database
$sql_time = "SELECT opening_time, closing_time FROM operating_hours LIMIT 1";
$result = $conn->query($sql_time);
$row_time = $result->fetch_assoc();

$openingTime = $row_time['opening_time'];
$closingTime = $row_time['closing_time'];
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function check_tel() {
        var input = document.getElementById('edittel');
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

    function updateTime() {
        var now = new Date();
        var currentTime = now.toTimeString().split(' ')[0];

        document.getElementById('time').innerHTML = "เวลาปัจจุบัน : " + currentTime;

        var openingTime = "<?php echo $openingTime; ?>";
        var closingTime = "<?php echo $closingTime; ?>";

        // แปลงเวลาจาก string เป็น Date object
        var nowDate = new Date();
        var openingDate = new Date(nowDate.toDateString() + ' ' + openingTime);
        var closingDate = new Date(nowDate.toDateString() + ' ' + closingTime);

        // ตรวจสอบว่าช่วงเวลาปิดข้ามวันหรือไม่
        if (closingDate <= openingDate) {
            // ช่วงเวลาเปิด-ปิดข้ามวัน เช่น 23:00:00 ถึง 05:00:00
            if (now >= openingDate || now <= closingDate) {
                document.getElementById('status').innerHTML = "<span style='color: green;'>(ระบบเปิด)</span>";
            } else {
                document.getElementById('status').innerHTML = "<span style='color: red;'>(ระบบปิด)</span>";
            }
        } else {
            // ช่วงเวลาเปิด-ปิดในวันเดียวกัน
            if (now >= openingDate && now <= closingDate) {
                document.getElementById('status').innerHTML = "<span style='color: green;'>(ระบบเปิด)</span>";
            } else {
                document.getElementById('status').innerHTML = "<span style='color: red;'>(ระบบปิด)</span>";
            }
        }

    }

    // เรียกใช้ฟังก์ชัน updateTime ทุกๆ 1 วินาที
    setInterval(updateTime, 1000);

    function confirmLogout(booking_id) {
        Swal.fire({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณกำลังจะออกจากระบบน้า",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่, ออกจากระบบ!",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './logout.php';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');

                // First confirmation step
                Swal.fire({
                    title: 'ยืนยันการลบ?',
                    text: "คุณแน่ใจว่าต้องการลบโปรไฟล์นี้หรือไม่?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบ!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Second confirmation step with dropdown
                        Swal.fire({
                            title: 'ยืนยันการลบ!',
                            text: "เลือก 'ยืนยันที่จะลบโปรไฟล์' จาก dropdown เพื่อดำเนินการต่อ:",
                            input: 'select',
                            inputOptions: {
                                '': 'ล้อเล่นไม่ลบหรอก',
                                'not_delete': 'ล้อเล่นไม่ลบหรอก',
                                'change_mind': 'เปลี่ยนใจละ',
                                'not_delete': 'ไม่ลบดีกว่า',
                                'confirm': 'ยืนยันที่จะลบโปรไฟล์',
                                'second_confirm': 'ยืนยันที่จะลบโปรไฟล์ดีไหมน้า หรือไม่ลบดี',
                            },
                            inputPlaceholder: 'เลือกตัวเลือก',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ยืนยัน',
                            cancelButtonText: 'ยกเลิก',
                            preConfirm: (inputValue) => {
                                if (inputValue !== 'confirm') {
                                    Swal.showValidationMessage('คุณต้องเลือก "ยืนยันที่จะลบโปรไฟล์" เพื่อดำเนินการต่อ');
                                    return false;
                                }
                                return true;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Proceed with the deletion
                                window.location.href = `delete_profile.php?user_id=${encodeURIComponent(userId)}`;
                            }
                        });
                    }
                });
            });
        });
    });
</script>
</nav>