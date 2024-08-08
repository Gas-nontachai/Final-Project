<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อกอินก่อน"); window.location.href = "./login.php";</script>';
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<script>alert("รหัสหมวดหมู่ไม่ถูกต้อง"); window.location.href = "./manage_cat.php";</script>';
    exit();
}

$category_id = $_GET['id'];

// ลบหมวดหมู่ย่อยก่อน
$sql_delete_subcategories = "DELETE FROM sub_category WHERE id_category = '$category_id'";
if ($conn->query($sql_delete_subcategories)) {
    // ลบหมวดหมู่
    $sql_delete_category = "DELETE FROM category WHERE id_category = '$category_id'";
    if ($conn->query($sql_delete_category)) {
        echo '<script>alert("ลบหมวดหมู่และหมวดหมู่ย่อยเรียบร้อยแล้ว!"); window.location.href = "./manage_cat.php";</script>';
    } else {
        echo "เกิดข้อผิดพลาดในการลบหมวดหมู่: " . $conn->error;
    }
} else {
    echo "เกิดข้อผิดพลาดในการลบหมวดหมู่ย่อย: " . $conn->error;
}

$conn->close();
?>
