<?php
session_start();
require("../condb.php");

function generateAlert($title, $text, $icon, $redirectUrl = "./manage_cat.php")
{
    return '
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "' . $title . '",
                    text: "' . $text . '",
                    icon: "' . $icon . '",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "ตกลง"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . $redirectUrl . '";
                    }
                });
            });
        </script>
    </body>
    </html>';
}

if (!isset($_SESSION["username"])) {
    echo generateAlert("กรุณาล็อคอินก่อน", "", "error", "../login.php");
    exit();
}

// รับข้อมูลจากฟอร์ม
$zone_id = isset($_POST['zone']) ? $conn->real_escape_string(trim($_POST['zone'])) : '';
$category = isset($_POST['category']) ? $conn->real_escape_string(trim($_POST['category'])) : '';
$subcategories = isset($_POST['sub_category']) ? explode(',', trim($_POST['sub_category'])) : [];

if ($category === '') {
    die('Category name is required.');
}

// ตรวจสอบว่าชื่อประเภทซ้ำหรือไม่
$checkCategoryStmt = $conn->prepare("SELECT id_category FROM category WHERE cat_name = ?");
$checkCategoryStmt->bind_param("s", $category);
$checkCategoryStmt->execute();
$checkCategoryStmt->store_result();

if ($checkCategoryStmt->num_rows > 0) {
    // ถ้าหมวดหมู่มีอยู่แล้ว
    echo generateAlert("ชื่อประเภทสินค้าซ้ำ", "ชื่อประเภทนี้มีอยู่แล้วในระบบ", "error");
    exit();
}

$checkCategoryStmt->close();

// Insert category using prepared statements
$stmt = $conn->prepare("INSERT INTO category (cat_name, zone_allow) VALUES (?, ?)");
$stmt->bind_param("ss", $category, $zone_id);
if ($stmt->execute()) {
    $category_id = $stmt->insert_id;

    // เตรียมคำสั่งสำหรับเช็ค subcategories ว่าซ้ำหรือไม่
    $checkSubCategoryStmt = $conn->prepare("SELECT idsub_category FROM sub_category WHERE id_category = ? AND sub_cat_name = ?");

    // Insert subcategories
    $stmt = $conn->prepare("INSERT INTO sub_category (id_category, sub_cat_name) VALUES (?, ?)");
    foreach ($subcategories as $sub_category) {
        $sub_category = $conn->real_escape_string(trim($sub_category));
        if ($sub_category !== '') {
            // ตรวจสอบว่าชื่อ subcategory ซ้ำหรือไม่
            $checkSubCategoryStmt->bind_param("is", $category_id, $sub_category);
            $checkSubCategoryStmt->execute();
            $checkSubCategoryStmt->store_result();

            if ($checkSubCategoryStmt->num_rows > 0) {
                // ถ้าชื่อ subcategory ซ้ำ
                echo generateAlert("ชื่อหมวดหมู่ย่อยซ้ำ", "ชื่อหมวดหมู่ย่อย: '" . htmlspecialchars($sub_category, ENT_QUOTES) . "' มีอยู่แล้วในระบบ", "error");
                exit();
            }

            // ถ้าไม่ซ้ำ ให้เพิ่ม subcategory ลงฐานข้อมูล
            $stmt->bind_param("is", $category_id, $sub_category);
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
        }
    }

    // แสดงการเพิ่มข้อมูลสำเร็จ
    echo generateAlert("เพิ่มประเภทสินค้าเรียบร้อย", "", "success", "./manage_cat.php");
} else {
    echo "Error: " . $stmt->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt->close();
$checkSubCategoryStmt->close();
$conn->close();
