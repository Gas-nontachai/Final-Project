<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "./login.php";</script>';
    exit();
}

// รับข้อมูลจากฟอร์ม
$category = $_POST['category'];
$subcategories = explode(' ', $_POST['sub_category']);

// Insert category
$sql = "INSERT INTO category (cat_name) VALUES ('$category')";
if ($conn->query($sql) === TRUE) {
    $category_id = $conn->insert_id;

    // Insert subcategories
    foreach ($subcategories as $sub_category) {
        $sql = "INSERT INTO sub_category (id_category, sub_cat_name) VALUES ('$category_id', '$sub_category')";
        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo '<script>alert("อัพเดตโซนเรียบร้อย!"); window.location.href = "./manage_cat.php";</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
