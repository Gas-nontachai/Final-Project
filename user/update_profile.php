<?php
session_start();
require("../condb.php");

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
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
                        timer: 2000, 
                        timerProgressBar: true, // แสดงแถบความก้าวหน้า
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "../login.php";
                    }
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ดึงและทำความสะอาดข้อมูลฟอร์ม
    $user_id = $_SESSION['user_id']; // สมมติว่า user_id ถูกเก็บในเซสชัน
    $shop_name = htmlspecialchars($_POST['editshopname']);
    $prefix = htmlspecialchars($_POST['editprefix']);
    $firstname = htmlspecialchars($_POST['editfirstname']);
    $lastname = htmlspecialchars($_POST['editlastname']);
    $tel = htmlspecialchars($_POST['edittel']);
    $email = htmlspecialchars($_POST['editemail']);

    // ตรวจสอบข้อมูลที่กรอก
    if (empty($shop_name) || empty($prefix) || empty($firstname) || empty($lastname) || empty($tel) || empty($email)) {
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>กรุณากรอกข้อมูลในช่องที่ต้องกรอกทั้งหมด</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "กรุณากรอกข้อมูลในช่องที่ต้องกรอกทั้งหมด",
                        icon: "error",
                        timer: 2000, 
                        timerProgressBar: true, // แสดงแถบความก้าวหน้า
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                           window.history.back();
                        }
                    });
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // เตรียมคำสั่ง SQL
    $sql = "UPDATE tbl_user SET 
                shop_name = ?, 
                prefix = ?, 
                firstname = ?, 
                lastname = ?, 
                tel = ?, 
                email = ? 
            WHERE user_id = ?";

    // เริ่มต้นและดำเนินการคำสั่ง SQL ที่เตรียมไว้
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssi", $shop_name, $prefix, $firstname, $lastname, $tel, $email, $user_id);

        if ($stmt->execute()) {

            echo '<!DOCTYPE html>
                    <html lang="th">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>อัพเดตข้อมูลแล้ว</title>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <link rel="stylesheet" href="../asset/css/font.css">
                    </head>
                    <body>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire({
                                    title: "อัพเดตข้อมูลแล้ว",
                                     icon: "success",
                                timer: 2000, 
                                timerProgressBar: true, // แสดงแถบความก้าวหน้า
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        window.location.href = "./index.php"; // เปลี่ยนเส้นทางไปยังหน้าล็อกอิน
                                    }
                                });
                            });
                        </script>
                    </body>
                    </html>';
        } else {
            echo "ข้อผิดพลาดในการอัพเดตข้อมูลโปรไฟล์: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error;
    }
} else {
    header("Location: ./logout.php");
    exit();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
