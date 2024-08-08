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
                echo '<script>alert("อัปโหลดสลิปสำเร็จ กำลังรอการตรวจสอบ"); window.location.href = "index.php";</script>';
                exit();
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
