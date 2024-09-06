<?php
session_start();
require("../condb.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];      // รับค่า booking_id จากฟอร์ม
    $total_price = $_POST['total_price'];    // รับค่า total_price จากฟอร์ม
    $user_id = $_SESSION['user_id'];          // ใช้ user_id จาก session

    // ดึงจำนวนเหรียญปัจจุบันของผู้ใช้จาก tbl_user
    $sql = "SELECT token FROM tbl_user WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $current_token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // ตรวจสอบว่าผู้ใช้มีเหรียญเพียงพอหรือไม่
    if ($current_token >= $total_price) {
        // หักจำนวนเหรียญออกจาก tbl_user
        $new_token_balance = $current_token - $total_price;
        $sql_update_token = "UPDATE tbl_user SET token = ? WHERE user_id = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update_token);
        mysqli_stmt_bind_param($stmt_update, 'is', $new_token_balance, $user_id);
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);

        // อัปเดตสถานะการจองเป็น 9 ในตาราง booking
        $status = 9;
        $sql_update_booking = "UPDATE booking SET booking_status = ? WHERE booking_id = ?";
        $stmt_booking = mysqli_prepare($conn, $sql_update_booking);
        mysqli_stmt_bind_param($stmt_booking, 'is', $status, $booking_id);
        if (mysqli_stmt_execute($stmt_booking)) {
            echo '<!DOCTYPE html>
            <html lang="th">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ชำระเงินด้วย Token สำเร็จ</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "ชำระเงินด้วย Token สำเร็จ",
                             icon: "success",
                                timer: 2000, 
                                timerProgressBar: true, // แสดงแถบความก้าวหน้า
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = "./index.php";
                            }
                        });
                    });
                </script>
            </body>
            </html>';
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตสถานะการจอง: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_booking);
    } else {
        // กรณีเหรียญไม่พอ
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>เหรียญไม่เพียงพอ</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "เหรียญของคุณไม่เพียงพอ",
                        text: "กรุณาเติมเหรียญเพื่อดำเนินการต่อ",
                        icon: "error",
                        timer: 2000, 
                        timerProgressBar: true, // แสดงแถบความก้าวหน้า
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                    }).then(() => {
                        window.location.href = "./index.php"; 
                    });
                });
            </script>
        </body>
        </html>';
    }

    // ปิดการเชื่อมต่อ
    mysqli_close($conn);
}
