<?php
session_start();
require("../condb.php");

// ตรวจสอบว่า user_id ถูกส่งมาหรือไม่
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $userId = $conn->real_escape_string($_GET['user_id']);

    // เตรียมคำสั่ง SQL เพื่อลบข้อมูล
    $sql = "DELETE FROM tbl_user WHERE user_id = '$userId'";

    if ($conn->query($sql) === TRUE) {
        // ทำลายเซสชัน
        $_SESSION = array();
        session_destroy();

        // ส่งกลับข้อความให้ SweetAlert2 แสดงผล
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>ลบโปรไฟล์เรียบร้อย</title>
                  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
              </head>
              <body>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
                  <script>
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'ลบโปรไฟล์เรียบร้อยแล้ว',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ตกลง'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../admin/login.php';
                        }
                    });
                  </script>
              </body>
              </html>";
    } else {
        // ส่งกลับข้อความให้ SweetAlert2 แสดงผลในกรณีเกิดข้อผิดพลาด
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>เออเร่อในการลบโปรไฟล์</title>
                  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
              </head>
              <body>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
                  <script>
                    Swal.fire({
                        title: 'ผิดพลาด!',
                        text: 'เกิดข้อผิดพลาดในการลบโปรไฟล์: " . $conn->error . "',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ตกลง'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.history.back();
                        }
                    });
                  </script>
              </body>
              </html>";
    }
} else {
    // ส่งกลับข้อความให้ SweetAlert2 แสดงผลในกรณีไม่มี user_id
    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>เออเร่อ</title>
              <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
          </head>
          <body>
              <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
              <script>
                Swal.fire({
                    title: 'ข้อผิดพลาด!',
                    text: 'ไม่มี user_id ที่จะลบ',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back();
                    }
                });
              </script>
          </body>
          </html>";
}

// ปิดการเชื่อมต่อ
$conn->close();
