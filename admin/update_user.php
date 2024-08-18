<?php
header('Content-Type: application/json');
require("../condb.php");

// ตรวจสอบว่ามีพารามิเตอร์ที่ต้องการหรือไม่
if (isset($_POST['user_id']) && 
    isset($_POST['username']) && 
    isset($_POST['password']) && 
    isset($_POST['shop_name']) && 
    isset($_POST['tel']) && 
    isset($_POST['email']) && 
    isset($_POST['user_role'])) {

    // ดีบัก: แสดงข้อมูลที่ได้รับจาก POST
    error_log(print_r($_POST, true));

    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $shop_name = $_POST['shop_name'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $userrole = $_POST['user_role'];

    // เตรียม SQL statement เพื่ออัปเดตข้อมูลผู้ใช้
    $sql = "UPDATE tbl_user SET 
            username = ?, 
            password = ?, 
            shop_name = ?, 
            tel = ?, 
            email = ?, 
            userrole = ?
            WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    
    // เรียกใช้ bind_param ให้ถูกต้อง
    $stmt->bind_param("ssssssi", $username, $password, $shop_name, $tel, $email, $userrole, $user_id);

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
?>
