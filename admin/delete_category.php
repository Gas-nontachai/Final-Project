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
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "กรุณาล็อคอินก่อน",
                    icon: "error",
                    timer: 2000, 
                    timerProgressBar: true, // แสดงแถบความก้าวหน้า
                    showConfirmButton: false // ซ่อนปุ่ม "OK"
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "./login.php";
                    }
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>รหัสหมวดหมู่ไม่ถูกต้อง</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "รหัสหมวดหมู่ไม่ถูกต้อง",
                    icon: "error",
                    timer: 2000, 
                    timerProgressBar: true, // แสดงแถบความก้าวหน้า
                    showConfirmButton: false // ซ่อนปุ่ม "OK"
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "./manage_cat.php";
                    }
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

$category_id = $_GET['id'];

// ลบหมวดหมู่ย่อยก่อน
$sql_delete_subcategories = "DELETE FROM sub_category WHERE id_category = '$category_id'";
if ($conn->query($sql_delete_subcategories)) {
    // ลบหมวดหมู่
    $sql_delete_category = "DELETE FROM category WHERE id_category = '$category_id'";
    if ($conn->query($sql_delete_category)) {
        echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>ลบหมวดหมู่และหมวดหมู่ย่อยเรียบร้อยแล้ว</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "ลบหมวดหมู่และหมวดหมู่ย่อยเรียบร้อยแล้ว",
                                icon: "success",
                                timer: 2000, 
                                timerProgressBar: true, // แสดงแถบความก้าวหน้า
                                showConfirmButton: false // ซ่อนปุ่ม "OK"
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
        echo "เกิดข้อผิดพลาดในการลบหมวดหมู่: " . $conn->error;
    }
} else {
    echo "เกิดข้อผิดพลาดในการลบหมวดหมู่ย่อย: " . $conn->error;
}

$conn->close();
