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
        $file_tmp = $_FILES['receipt']['tmp_name'];
        $file_mime = mime_content_type($file_tmp); // ตรวจสอบชนิดไฟล์

        // ตรวจสอบว่าชนิดไฟล์เป็นภาพ (jpeg, png, gif)
        if (in_array($file_mime, ['image/jpeg', 'image/png', 'image/gif'])) {
            $date = date('Ymd_His');
            $file_name = "slip_" . $date . "_" . uniqid() . "." . $file_ext;

            // ย้ายไฟล์ไปยังโฟลเดอร์ที่ต้องการ
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
                                    showConfirmButton: true
                                }).then((result) => {
                                    window.location.href = "./order.php";
                                });
                            });
                        </script>
                    </body>
                    </html>';
                    exit();
                } else {
                    echo '<!DOCTYPE html>
                    <html lang="th">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>ข้อผิดพลาด</title>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <link rel="stylesheet" href="../asset/css/font.css">
                        </head>
                    <body>
                        <script>
                            Swal.fire({
                                title: "เกิดข้อผิดพลาดในการอัพเดทฐานข้อมูล",
                                text: "' . mysqli_error($conn) . '",
                                icon: "error",
                                confirmButtonText: "ตกลง"
                            }).then((result) => {
                                    window.location.href = "./order.php";
                                });
                        </script>
                    </body>
                    </html>';
                }
            } else {
                echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>ข้อผิดพลาด</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        Swal.fire({
                            title: "ไม่สามารถย้ายไฟล์ที่อัปโหลดได้",
                            icon: "error",
                            confirmButtonText: "ตกลง"
                        }).then((result) => {
                                    window.location.href = "./order.php";
                                });
                    </script>
                </body>
                </html>';
            }
        } else {
            echo '<!DOCTYPE html>
            <html lang="th">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ข้อผิดพลาด</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: "รองรับเฉพาะไฟล์รูปภาพเท่านั้น (JPEG, PNG, GIF)",
                        icon: "error",
                        confirmButtonText: "ตกลง"
                    }).then((result) => {
                                    window.location.href = "./order.php";
                                });
                </script>
            </body>
            </html>';
        }
    } else {
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ข้อผิดพลาด</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                Swal.fire({
                    title: "ไม่มีไฟล์ถูกอัปโหลดหรือเกิดข้อผิดพลาดในการอัปโหลด",
                    icon: "error",
                    confirmButtonText: "ตกลง"
                }).then((result) => {
                                    window.location.href = "./order.php";
                                });
            </script>
        </body>
        </html>';
    }

    // ปิดการเชื่อมต่อ
    mysqli_close($conn);
}
