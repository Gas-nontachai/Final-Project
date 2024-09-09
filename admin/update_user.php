<?php
header('Content-Type: application/json');
require("../condb.php");
if ($_SESSION["userrole"] == 0) {
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
                    title: "คุณไม่มีสิทธิ์เข้าถึง เฉพาะผู้ดูแลเท่านั้น",
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
// ตรวจสอบว่ามีพารามิเตอร์ที่ต้องการหรือไม่
if (
    isset($_POST['user_id']) &&
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['shop_name']) &&
    isset($_POST['tel']) &&
    isset($_POST['token']) &&
    isset($_POST['email']) &&
    isset($_POST['user_role'])
) {

    // ดีบัก: แสดงข้อมูลที่ได้รับจาก POST
    error_log(print_r($_POST, true));

    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password']; // ควรพิจารณาเข้ารหัสก่อนเก็บในฐานข้อมูล
    $shop_name = $_POST['shop_name'];
    $tel = $_POST['tel'];
    $token = $_POST['token']; // แก้ไขจาก $tel เป็น $token
    $email = $_POST['email'];
    $userrole = $_POST['user_role'];

    // เตรียม SQL statement เพื่ออัปเดตข้อมูลผู้ใช้
    $sql = "UPDATE tbl_user SET 
            username = ?, 
            password = ?, 
            shop_name = ?, 
            tel = ?, 
            token = ?, 
            email = ?, 
            userrole = ?
            WHERE user_id = ?";

    $stmt = $conn->prepare($sql);

    // เรียกใช้ bind_param ให้ถูกต้อง
    $stmt->bind_param("sssssssi", $username, $password, $shop_name, $tel, $token, $email, $userrole, $user_id);

    // เรียกใช้คำสั่งและตรวจสอบความสำเร็จ
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปเดตข้อมูลผู้ใช้: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ข้อมูลที่ต้องการหายไป']);
}

$conn->close();
