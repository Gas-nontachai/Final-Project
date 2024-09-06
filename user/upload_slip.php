<?php
session_start();
require("../condb.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = '2';
    $date = date('d-m-Y');

    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
        $file_info = pathinfo($_FILES['receipt']['name']);
        $file_ext = $file_info['extension'];
        $date = date('Ymd_His');
        $file_name = "slip_" . $date . "_" . uniqid() . "." . $file_ext;
        $file_tmp = $_FILES['receipt']['tmp_name'];

        // ย้ายไฟล์ไปยังโฟลเดอร์ที่ต้องการและเพิ่มนามสกุลไฟล์
        if (move_uploaded_file($file_tmp, "../asset/slip_img/" . $file_name)) {
            // อัพเดทฐานข้อมูล
            $sql = "UPDATE booking
                    SET booking_status = '$status', slip_img = '$file_name' 
                    WHERE booking_id = '$booking_id'";

            if (mysqli_query($conn, $sql)) {
                echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>อัปโหลดสลิปสำเร็จ กำลังรอการตรวจสอบ</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "อัปโหลดสลิปสำเร็จ กำลังรอการตรวจสอบ",
                                icon: "success",
                                timer: 2000,
                                timerProgressBar: true, // แสดงแถบความก้าวหน้า
                                showConfirmButton: false // ซ่อนปุ่ม "OK"
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href = "./index.php"; // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                                }
                            });
                        });
                    </script>
                </body>
                </html>';                exit();
            } else {
                echo "ข้อผิดพลาด: ไม่สามารถดำเนินการตามคำสั่ง SQL ได้ " . mysqli_error($conn);
            }
        } else {
            echo "ไม่สามารถย้ายไฟล์ที่อัปโหลดได้.";
        }
    } else {
        echo "ไม่มีไฟล์ถูกอัปโหลดหรือเกิดข้อผิดพลาดในการอัปโหลด.";
    }

    // ปิดการเชื่อมต่อ
    mysqli_close($conn);
}
?>
