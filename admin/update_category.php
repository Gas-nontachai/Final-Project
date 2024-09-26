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
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                            }).then((result) => {
                                    window.location.href = "../login.php";
                                
                            });
                        });
                    </script>
                </body>
                </html>';
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
        $subcategories = explode(',', $sub_cat_names);
        foreach ($subcategories as $sub_category) {
            $sql_insert_subcategory = "INSERT INTO sub_category (id_category, sub_cat_name) VALUES ('$category_id', '$sub_category')";
            if (!$conn->query($sql_insert_subcategory)) {
                echo "ข้อผิดพลาดในการเพิ่มหมวดหมู่ย่อย: " . $conn->error;
                exit();
            }
        }
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>อัพเดทหมวดหมู่เรียบร้อยแล้ว</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "อัพเดทหมวดหมู่เรียบร้อยแล้ว",
                         icon: "success",
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                    }).then((result) => {
                            window.location.href = "./manage_cat.php";
                        
                    });
                });
            </script>
        </body>
        </html>';
    } else {
        echo "ข้อผิดพลาดในการลบหมวดหมู่ย่อยที่มีอยู่: " . $conn->error;
    }
} else {
    echo "ข้อผิดพลาดในการอัพเดทชื่อหมวดหมู่: " . $conn->error;
}

$conn->close();
