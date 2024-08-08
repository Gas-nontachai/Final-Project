<?php
session_start();
require("../condb.php");

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "../admin/login.php";</script>';
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
        echo '<script>alert("กรุณากรอกข้อมูลให้ครบถ้วน."); window.history.back();</script>';
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
            echo '<script>alert("อัพเดตข้อมูลแล้ว กรุณาล็อกอินใหม่"); window.location.href = "./logout.php";</script>';
        } else {
            echo "ข้อผิดพลาดในการอัพเดตข้อมูลโปรไฟล์: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error;
    }
} else {
    header("Location: ../admin/logout.php");
    exit();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
