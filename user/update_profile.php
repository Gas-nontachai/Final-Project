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
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                        window.location.href = "../login.php";
                });
            });
        </script>
    </body>
    </html>';
    exit();
}
if ($_SESSION["userrole"] == 1) {
    session_destroy();
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ไม่มีสิทธิ์เข้าถึง</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "หน้านี้สำหรับผู้ใช้ทั่วไป คุณคือผู้ดูแลระบบ",
                    icon: "error",
                    showConfirmButton: true
                }).then((result) => {
                    window.location.href = "../login.php";
                });
            });
        </script>
    </body>
    </html>';
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ดึงและทำความสะอาดข้อมูลฟอร์ม
    $user_id = $_SESSION['user_id'];
    $shop_name = htmlspecialchars(trim($_POST['editshopname']));
    $prefix = htmlspecialchars(trim($_POST['editprefix']));
    $firstname = htmlspecialchars(trim($_POST['editfirstname']));
    $lastname = htmlspecialchars(trim($_POST['editlastname']));
    $tel = htmlspecialchars(trim($_POST['edittel']));
    $email = htmlspecialchars(trim($_POST['editemail']));

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
                        showConfirmButton: true
                    }).then((result) => {
                        window.history.back();
                    });
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // ตรวจสอบว่าเบอร์โทรศัพท์ซ้ำกับผู้ใช้คนอื่นหรือไม่
    $sql = "SELECT COUNT(*) FROM tbl_user WHERE tel = ? AND user_id != ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $tel, $user_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo '<!DOCTYPE html>
            <html lang="th">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>เบอร์โทรศัพท์ซ้ำ</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "เบอร์โทรศัพท์นี้ถูกใช้โดยผู้ใช้คนอื่นแล้ว",
                            icon: "error",
                            showConfirmButton: true
                        }).then((result) => {
                            window.history.back();
                        });
                    });
                </script>
            </body>
            </html>';
            exit();
        }
    } else {
        echo "ข้อผิดพลาดในการเตรียมคำสั่งตรวจสอบเบอร์โทรศัพท์: " . $conn->error;
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
                                showConfirmButton: true
                            }).then((result) => {
                                window.location.href = "./index.php"; // เปลี่ยนเส้นทางไปยังหน้าหลัก
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
