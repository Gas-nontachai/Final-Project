<?php
header('Content-Type: application/json');
require("../condb.php");

// ตรวจสอบว่ามีพารามิเตอร์ที่ต้องการหรือไม่
if (
    isset($_POST['user_id']) &&
    isset($_POST['username']) &&
    isset($_POST['shop_name']) &&
    isset($_POST['tel']) &&
    isset($_POST['password']) &&  // เพิ่มการเช็ค password
    isset($_POST['token']) &&
    isset($_POST['email']) &&
    isset($_POST['user_role'])
) {
    $user_id = $_POST['user_id'];
    $username = trim($_POST['username']);
    $shop_name = trim($_POST['shop_name']);
    $tel = trim($_POST['tel']);
    $password = trim($_POST['password']); // รับค่า password จาก POST
    $token = trim($_POST['token']);
    $email = trim($_POST['email']);
    $userrole = trim($_POST['user_role']);

    // ตรวจสอบค่าว่าง
    if (empty($username) || empty($shop_name) || empty($password) || empty($tel) || empty($email)) {
        $missing_fields = [];

        if (empty($username)) {
            $missing_fields[] = 'ชื่อผู้ใช้';
        }
        if (empty($shop_name)) {
            $missing_fields[] = 'ชื่อร้าน';
        }
        if (empty($password)) {
            $missing_fields[] = 'รหัสผ่าน';
        }
        if (empty($tel)) {
            $missing_fields[] = 'หมายเลขโทรศัพท์';
        }
        if (empty($email)) {
            $missing_fields[] = 'อีเมล';
        }

        $message = 'กรุณากรอกข้อมูลให้ครบถ้วน: ' . implode(', ', $missing_fields);
        echo json_encode(['success' => false, 'message' => $message]);
        exit();
    }

    // ตรวจสอบการซ้ำของชื่อผู้ใช้
    $check_username = "SELECT * FROM tbl_user WHERE username = ? AND user_id != ?";
    $stmt = $conn->prepare($check_username);
    $stmt->bind_param("si", $username, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบการซ้ำของหมายเลขโทรศัพท์ แต่ข้ามการตรวจสอบของผู้ใช้ปัจจุบัน
    $check_tel = "SELECT * FROM tbl_user WHERE tel = ? AND user_id != ?";
    $stmt_tel = $conn->prepare($check_tel);
    $stmt_tel->bind_param("si", $tel, $user_id);
    $stmt_tel->execute();
    $result_tel = $stmt_tel->get_result();

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Username นี้ได้มีการสมัครไปแล้ว']);
        exit();
    } else if (mysqli_num_rows($result_tel) > 0) {
        echo json_encode(['success' => false, 'message' => 'หมายเลขโทรศัพท์นี้ได้สมัครสมาชิกไปแล้ว']);
        exit();
    } else {
        $sql = "UPDATE tbl_user SET 
                username = ?, 
                shop_name = ?, 
                tel = ?, 
                password = ?, 
                token = ?, 
                email = ?, 
                userrole = ?
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $username, $shop_name, $tel, $password, $token, $email, $userrole, $user_id);

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
