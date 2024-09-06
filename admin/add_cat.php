<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>กรุณาล็อคอินก่อน</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "กรุณาล็อคอินก่อน",
                                icon: "error",
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href = "../login.php";
                                }
                            });
                        });
                    </script>
                </body>
                </html>';
    exit();
}

// รับข้อมูลจากฟอร์ม
$category = isset($_POST['category']) ? $conn->real_escape_string(trim($_POST['category'])) : '';
$subcategories = isset($_POST['sub_category']) ? explode(' ', trim($_POST['sub_category'])) : [];

if ($category === '') {
    die('Category name is required.');
}

// Insert category using prepared statements
$stmt = $conn->prepare("INSERT INTO category (cat_name) VALUES (?)");
$stmt->bind_param("s", $category);
if ($stmt->execute()) {
    $category_id = $stmt->insert_id;

    // Insert subcategories
    $stmt = $conn->prepare("INSERT INTO sub_category (id_category, sub_cat_name) VALUES (?, ?)");
    foreach ($subcategories as $sub_category) {
        $sub_category = $conn->real_escape_string(trim($sub_category));
        if ($sub_category !== '') {
            $stmt->bind_param("is", $category_id, $sub_category);
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
        }
    }

    echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>เพิ่มประเภทสินค้าเรียบร้อย</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "เพิ่มประเภทสินค้าเรียบร้อย",
                                icon: "success",
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href = "./manage_cat.php";
                                }
                            });
                        });
                    </script>
                </body>
                </html>';
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
