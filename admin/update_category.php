<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "./login.php";</script>';
    exit();
}

// รับข้อมูลจากฟอร์ม
$category_id = $_POST['cat_id'];
$category_name = $_POST['cat_name'];
$sub_cat_names = $_POST['sub_cat_name'];

// อัพเดทชื่อหมวดหมู่
$sql_update_category = "UPDATE category SET cat_name = '$category_name' WHERE id_category = '$category_id'";
if ($conn->query($sql_update_category) === TRUE) {
    // ลบหมวดหมู่ย่อยที่มีอยู่สำหรับหมวดหมู่นี้
    $sql_delete_subcategories = "DELETE FROM sub_category WHERE id_category = '$category_id'";
    if ($conn->query($sql_delete_subcategories)) {
        // เพิ่มหมวดหมู่ย่อยใหม่
        $subcategories = explode(' ', $sub_cat_names);
        foreach ($subcategories as $sub_category) {
            $sql_insert_subcategory = "INSERT INTO sub_category (id_category, sub_cat_name) VALUES ('$category_id', '$sub_category')";
            if (!$conn->query($sql_insert_subcategory)) {
                echo "ข้อผิดพลาดในการเพิ่มหมวดหมู่ย่อย: " . $conn->error;
                exit();
            }
        }

        echo '<script>alert("อัพเดทหมวดหมู่เรียบร้อยแล้ว!"); window.location.href = "./manage_cat.php";</script>';
    } else {
        echo "ข้อผิดพลาดในการลบหมวดหมู่ย่อยที่มีอยู่: " . $conn->error;
    }
} else {
    echo "ข้อผิดพลาดในการอัพเดทชื่อหมวดหมู่: " . $conn->error;
}

$conn->close();
?>
