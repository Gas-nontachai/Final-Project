<?php
session_start();
require("../condb.php");

// Function to generate SweetAlert messages
function generateAlert($title, $icon, $redirectUrl)
{
    return '
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "' . $title . '",
                    icon: "' . $icon . '",
                    showConfirmButton: true
                }).then((result) => {
                    window.location.href = "' . $redirectUrl . '";
                });
            });
        </script>
    </body>
    </html>';
}

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    echo generateAlert("กรุณาล็อคอินก่อน", "error", "../login.php");
    exit();
}

// รับข้อมูลจากฟอร์ม
$category_id = $_POST['cat_id'] ?? '';
$category_name = $_POST['cat_name'] ?? '';
$sub_cat_names = $_POST['sub_cat_name'] ?? '';

// Get zone ID safely
$zone_id = isset($_POST['zone']) ? $conn->real_escape_string(trim($_POST['zone'])) : '';

// Validate required fields
if (empty($category_id) || empty($category_name) || empty($zone_id)) {
    echo generateAlert("กรุณากรอกข้อมูลที่จำเป็นทั้งหมด", "error", "./manage_cat.php");
    exit();
}

// Prepare and bind the update statement to prevent SQL injection
$sql_update_category = $conn->prepare("UPDATE category SET cat_name = ?, zone_allow = ? WHERE id_category = ?");
$sql_update_category->bind_param("ssi", $category_name, $zone_id, $category_id);

if ($sql_update_category->execute()) {
    // ลบหมวดหมู่ย่อยที่มีอยู่สำหรับหมวดหมู่นี้
    $sql_delete_subcategories = $conn->prepare("DELETE FROM sub_category WHERE id_category = ?");
    $sql_delete_subcategories->bind_param("i", $category_id);

    if ($sql_delete_subcategories->execute()) {
        // เพิ่มหมวดหมู่ย่อยใหม่
        $subcategories = explode(',', $sub_cat_names);

        // Prepare the insert statement to prevent SQL injection
        $sql_insert_subcategory = $conn->prepare("INSERT INTO sub_category (id_category, sub_cat_name) VALUES (?, ?)");

        foreach ($subcategories as $sub_category) {
            // Trim whitespace from sub_category
            $sub_category = trim($sub_category);
            $sql_insert_subcategory->bind_param("is", $category_id, $sub_category);

            if (!$sql_insert_subcategory->execute()) {
                echo generateAlert("ข้อผิดพลาดในการเพิ่มหมวดหมู่ย่อย: " . $conn->error, "error", "./manage_cat.php");
                exit();
            }
        }

        // Success message after updating category and subcategories
        echo generateAlert("อัพเดทหมวดหมู่เรียบร้อยแล้ว", "success", "./manage_cat.php");
    } else {
        echo generateAlert("ข้อผิดพลาดในการลบหมวดหมู่ย่อยที่มีอยู่: " . $conn->error, "error", "./manage_cat.php");
    }
} else {
    echo generateAlert("ข้อผิดพลาดในการอัพเดทชื่อหมวดหมู่: " . $conn->error, "error", "./manage_cat.php");
}

// Close statements and database connection
$sql_update_category->close();
$sql_delete_subcategories->close();
$sql_insert_subcategory->close();
$conn->close();
