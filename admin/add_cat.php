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

// Receive form data
$zone_id = isset($_POST['zone']) ? $conn->real_escape_string(trim($_POST['zone'])) : '';
$category = isset($_POST['category']) ? $conn->real_escape_string(trim($_POST['category'])) : '';
$subcategories = isset($_POST['sub_category']) ? explode(',', trim($_POST['sub_category'])) : [];

if ($category === '') {
    die('Category name is required.');
}

// Check for duplicate category name
$checkCategoryStmt = $conn->prepare("SELECT id_category FROM category WHERE cat_name = ?");
$checkCategoryStmt->bind_param("s", $category);
$checkCategoryStmt->execute();
$checkCategoryStmt->store_result();

if ($checkCategoryStmt->num_rows > 0) {
    // If category already exists
    echo generateAlert("ชื่อประเภทสินค้าซ้ำ", "error", "javascript:window.history.back();");
    exit();
}

$checkCategoryStmt->close();

// Insert category using prepared statements
$stmt = $conn->prepare("INSERT INTO category (cat_name, zone_allow) VALUES (?, ?)");
$stmt->bind_param("ss", $category, $zone_id);
if ($stmt->execute()) {
    $category_id = $stmt->insert_id;

    // Prepare to check for duplicate subcategories
    $checkSubCategoryStmt = $conn->prepare("SELECT idsub_category FROM sub_category WHERE id_category = ? AND sub_cat_name = ?");

    // Insert subcategories
    $stmt = $conn->prepare("INSERT INTO sub_category (id_category, sub_cat_name) VALUES (?, ?)");
    foreach ($subcategories as $sub_category) {
        $sub_category = $conn->real_escape_string(trim($sub_category));
        if ($sub_category !== '') {
            // Check for duplicate subcategory name
            $checkSubCategoryStmt->bind_param("is", $category_id, $sub_category);
            $checkSubCategoryStmt->execute();
            $checkSubCategoryStmt->store_result();

            if ($checkSubCategoryStmt->num_rows > 0) {
                // If subcategory name is duplicate
                echo generateAlert("ชื่อหมวดหมู่ย่อยซ้ำ: '" . htmlspecialchars($sub_category, ENT_QUOTES) . "'", "error", "javascript:window.history.back();");
                exit();
            }

            // If not duplicate, insert subcategory
            $stmt->bind_param("is", $category_id, $sub_category);
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
        }
    }

    // Success message
    echo generateAlert("เพิ่มประเภทสินค้าเรียบร้อย", "success", "./manage_cat.php");
} else {
    echo "Error: " . $stmt->error;
}

// Close database connections
$stmt->close();
$checkSubCategoryStmt->close();
$conn->close();
