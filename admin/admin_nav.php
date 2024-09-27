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
<?php
// กำหนดตัวแปรเพื่อเก็บชื่อไฟล์หน้าเปิดอยู่
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav style="width: 100%;" class="navbar navbar-expand-lg navbar-light bg-light">
    <div style="width: 100%;" class="d-flex flex-column ">
        <div class="container-fluid border-bottom border-dark">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="./index.php"
                            class="icon-link icon-link-hover nav-link <?php echo ($current_page == 'index.php') ? 'active rounded-top' : ''; ?>"
                            style="<?php echo ($current_page == 'index.php') ? 'background-color: #4A4947; color: white; --bs-icon-link-transform: translate3d(0, -.125rem, 0);' : 'color: black; --bs-icon-link-transform: translate3d(0, -.125rem, 0);'; ?>">
                            <i class="bi bi-house-door"></i> หน้าแรก
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./confirm_reserve.php"
                            class="icon-link icon-link-hover nav-link <?php echo ($current_page == 'confirm_reserve.php') ? 'active rounded-top' : ''; ?>"
                            style="<?php echo ($current_page == 'confirm_reserve.php') ? 'background-color: #4A4947; color: white; --bs-icon-link-transform: translate3d(0, -.125rem, 0);' : 'color: black; --bs-icon-link-transform: translate3d(0, -.125rem, 0);'; ?>">
                            <i class="bi bi-pencil-square"></i> ปรับเปลี่ยนสถานะการจอง
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./refund_page.php"
                            class="icon-link icon-link-hover nav-link <?php echo ($current_page == 'refund_page.php') ? 'active rounded-top' : ''; ?>"
                            style="<?php echo ($current_page == 'refund_page.php') ? 'background-color: #4A4947; color: white; --bs-icon-link-transform: translate3d(0, -.125rem, 0);' : 'color: black; --bs-icon-link-transform: translate3d(0, -.125rem, 0);'; ?>">
                            <i class="bi bi-x-circle"></i> คำขอยกเลิก/คืนเงิน
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./crud_page.php"
                            class="icon-link icon-link-hover nav-link <?php echo ($current_page == 'crud_page.php') ? 'active rounded-top' : ''; ?>"
                            style="<?php echo ($current_page == 'crud_page.php') ? 'background-color: #4A4947; color: white; --bs-icon-link-transform: translate3d(0, -.125rem, 0);' : 'color: black; --bs-icon-link-transform: translate3d(0, -.125rem, 0);'; ?>">
                            <i class="bi bi-geo-alt"></i> จัดการพื้นที่การขาย
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./manage_cat.php"
                            class="icon-link icon-link-hover nav-link <?php echo ($current_page == 'manage_cat.php') ? 'active rounded-top' : ''; ?>"
                            style="<?php echo ($current_page == 'manage_cat.php') ? 'background-color: #4A4947; color: white; --bs-icon-link-transform: translate3d(0, -.125rem, 0);' : 'color: black; --bs-icon-link-transform: translate3d(0, -.125rem, 0);'; ?>">
                            <i class="bi bi-box"></i> จัดการประเภทสินค้า
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./view_member.php"
                            class="icon-link icon-link-hover nav-link <?php echo ($current_page == 'view_member.php') ? 'active rounded-top' : ''; ?>"
                            style="<?php echo ($current_page == 'view_member.php') ? 'background-color: #4A4947; color: white; --bs-icon-link-transform: translate3d(0, -.125rem, 0);' : 'color: black; --bs-icon-link-transform: translate3d(0, -.125rem, 0);'; ?>">
                            <i class="bi bi-people"></i> ดูข้อมูลสมาชิก
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./booking_history.php"
                            class="icon-link icon-link-hover nav-link <?php echo ($current_page == 'booking_history.php') ? 'active rounded-top' : ''; ?>"
                            style="<?php echo ($current_page == 'booking_history.php') ? 'background-color: #4A4947; color: white; --bs-icon-link-transform: translate3d(0, -.125rem, 0);' : 'color: black; --bs-icon-link-transform: translate3d(0, -.125rem, 0);'; ?>">
                            <i class="bi bi-calendar-check"></i> ประวัติการจอง
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./stat_booking.php"
                            class="icon-link icon-link-hover nav-link <?php echo ($current_page == 'stat_booking.php') ? 'active rounded-top' : ''; ?>"
                            style="<?php echo ($current_page == 'stat_booking.php') ? 'background-color: #4A4947; color: white; --bs-icon-link-transform: translate3d(0, -.125rem, 0);' : 'color: black; --bs-icon-link-transform: translate3d(0, -.125rem, 0);'; ?>">
                            <i class="bi bi-bar-chart"></i> สถิติการจอง
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../asset/pdf/คู่มือการใช้งานระบบสำหรับผู้ดูแลระบบ.pdf" target="_blank" class="icon-link icon-link-hover nav-link active" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);">
                            <i class="bi bi-book"></i> คู่มือการใช้งาน
                        </a>
                    </li>
                </ul>
                <a class="navbar-brand" href="./index.php">จองล็อค.คอม(แอดมิน)</a>
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
                <strong>
                    <span id="time"></span>
                    <span id="status"></span>
                </strong>
                <strong>
                    <div id="opening_time">เวลาเปิด-ปิดระบบ(<a href="#" data-bs-toggle="modal" data-bs-target="#editTimeModal">
                            <?php echo $openingTime; ?> - <?php echo $closingTime; ?>)</a></div>
                </strong>
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
                            <td><?php echo $user_id; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">ชื่อผู้ใช้(Username):</th>
                            <td><?php echo $username; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">ชื่อ-นามสกุล:</th>
                            <td><?php echo $fullname; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">เบอร์โทรศัพท์:</th>
                            <td><?php echo $tel; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">อีเมล:</th>
                            <td><?php echo $email; ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ManulExpiredModal">ปรับหมดอายุคำขอแบบกดมือ</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <a href="./logout.php" type="button" class="btn btn-danger">ล็อกเอ้าท์</a>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Manul Expired Modal -->
<div class="modal fade" id="ManulExpiredModal" tabindex="-1" aria-labelledby="ManulExpiredModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ManulExpiredModalLabel"><strong>ปรับหมดอายุคำขอแบบกดมือ</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>เมื่อคุณกดปุ่ม "ยืนยัน", ระบบจะทำการปรับสถานะคำขอให้เป็น "หมดอายุ" ซึ่งจะมีผลดังนี้:</p>
                <ul>
                    <li>อัปเดตสถานะการจองที่มีวันหมดอายุ หรือที่มีสถานะ "หมดอายุ" ในฐานข้อมูล.</li>
                    <li>ย้ายข้อมูลการจองที่หมดอายุไปยังตาราง "booked" เพื่อเก็บประวัติ.</li>
                    <li>อัปเดตสถานะล็อค (lock) ที่เกี่ยวข้องให้พร้อมใช้งานอีกครั้ง.</li>
                    <li>ลบข้อมูลการจองที่หมดอายุออกจากตาราง "booking".</li>
                    <li>ระบบจะนำทางคุณไปยังหน้าใหม่เพื่อแสดงผลลัพธ์การดำเนินการนี้.</li>
                </ul>
                <p>คุณแน่ใจหรือไม่ว่าต้องการดำเนินการต่อ?</p>
                <button type="button" class="btn btn-danger" id="confirmManualExpire">ยืนยัน</button>
            </div>

        </div>
    </div>
</div>
<!-- Modal สำหรับแก้ไขเวลาเปิด-ปิด -->
<div class="modal fade" id="editTimeModal" tabindex="-1" aria-labelledby="editTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateTimeForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTimeModalLabel">แก้ไขเวลาเปิด-ปิดระบบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="openingTime" class="form-label">เวลาเปิด</label>
                        <input type="time" class="form-control" id="openingTime" name="opening_time" value="<?php echo $openingTime; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="closingTime" class="form-label">เวลาปิด</label>
                        <input type="time" class="form-control" id="closingTime" name="closing_time" value="<?php echo $closingTime; ?>" required>
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
<script>
    document.querySelector('.navbar-toggler').addEventListener('click', function() {
        console.log('Toggler clicked');
        const navbar = document.querySelector('.navbar');
        if (navbar.classList.contains('collapsed')) {
            navbar.classList.remove('collapsed');
            navbar.classList.add('expanded');
        } else {
            navbar.classList.remove('expanded');
            navbar.classList.add('collapsed');
        }
    });

    document.getElementById('confirmManualExpire').addEventListener('click', function() {
        Swal.fire({
            title: 'ยืนยันการปรับสถานะ',
            text: "คุณแน่ใจหรือไม่ว่าต้องการปรับสถานะหมดอายุคำขอนี้?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ฉันแน่ใจ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ดำเนินการตามที่ต้องการเมื่อได้รับการยืนยัน
                window.location.href = 'manual_expired_bookings.php'; // เปลี่ยน URL ตามต้องการ
            }
        });
    });
</script>
<!-- JavaScript สำหรับ Swal และการอัพเดตเวลา -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ฟังก์ชันการแสดงผล Swal เมื่อสำเร็จ
    function showSuccessSwal() {
        Swal.fire({
            icon: 'success',
            title: 'แก้ไขเวลาเปิด-ปิดสำเร็จ',
            showConfirmButton: true,
            didClose: () => {
                // Refresh the page
                location.reload();
            }
        });
    }


    function updateTime() {
        var now = new Date();
        var currentTime = now.toTimeString().split(' ')[0];

        document.getElementById('time').innerHTML = currentTime;

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

    // เมื่อกด submit ฟอร์ม
    document.getElementById('updateTimeForm').addEventListener('submit', function(e) {
        e.preventDefault(); // ป้องกันการโหลดหน้าใหม่

        var formData = new FormData(this);

        // ส่งข้อมูลไปที่ PHP ด้วย AJAX
        fetch('update_time.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
            .then(data => {
                // แสดง Swal เมื่อสำเร็จ
                showSuccessSwal();

                // ปิด modal หลังจาก Swal แสดงผล
                setTimeout(function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('editTimeModal'));
                    modal.hide();
                }, 1500);
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถแก้ไขเวลาได้'
                });
            });
    });
</script>