<?php
session_start();

// ทำลายเซสชัน
$_SESSION = array();
session_destroy();

// ตั้งค่าการแสดงการแจ้งเตือนด้วย SweetAlert2
echo '<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ออกจากระบบ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "ออกจากระบบเรียบร้อย",
                icon: "success",
                timer: 2000, // แสดงเป็นเวลา 3 วินาที
                timerProgressBar: true, // แสดงแถบความก้าวหน้า
                showConfirmButton: false // ซ่อนปุ่ม "OK"
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.href = "../admin/login.php"; // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                }
            });
        });
    </script>
</body>
</html>';
exit();
