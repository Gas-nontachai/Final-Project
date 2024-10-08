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
    <link rel="stylesheet" href="../asset/css/font.css">
</head>
<body>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "ออกจากระบบเรียบร้อย",
                 icon: "success",
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
            }).then((result) => {
                        window.location.href = "../login.php";
                
            });
        });
    </script>
</body>
</html>';
exit();
