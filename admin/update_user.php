<?php
header('Content-Type: application/json');
require("../condb.php");

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
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password']; // ควรพิจารณาเข้ารหัสก่อนเก็บในฐานข้อมูล
    $shop_name = $_POST['shop_name'];
    $tel = $_POST['tel'];
    $token = $_POST['token']; // แก้ไขจาก $tel เป็น $token
    $email = $_POST['email'];
    $userrole = $_POST['user_role'];

    // ตรวจสอบการซ้ำของชื่อผู้ใช้
    $check_username = "SELECT * FROM tbl_user WHERE username = ?";
    $stmt = $conn->prepare($check_username);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบการซ้ำของหมายเลขโทรศัพท์
    $check_tel = "SELECT * FROM tbl_user WHERE tel = ?";
    $stmt_tel = $conn->prepare($check_tel);
    $stmt_tel->bind_param("s", $tel);
    $stmt_tel->execute();
    $result_tel = $stmt_tel->get_result();

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Username นี้ได้มีการสมัครไปแล้ว']);
        exit();
    } else if (mysqli_num_rows($result_tel) > 0) {
        echo json_encode(['success' => false, 'message' => 'หมายเลขโทรศัพท์นี้ได้สมัครสมาชิกไปแล้ว']);
        exit();
    } else {
        // เข้ารหัสรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
        $stmt->bind_param("sssssssi", $username, $hashed_password, $shop_name, $tel, $token, $email, $userrole, $user_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปเดตข้อมูลผู้ใช้: ' . $stmt->error]);
        }

        $stmt->close();
    }

    $stmt_tel->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ข้อมูลที่ต้องการหายไป']);
}
?>
