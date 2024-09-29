<?php
session_start();
require("../condb.php");

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

if (!isset($_SESSION["username"])) {
    echo generateAlert("กรุณาล็อคอินก่อน", "error", "../login.php");
    exit();
}

if (!isset($_GET['id_category']) || empty($_GET['id_category'])) {
    echo generateAlert("รหัสหมวดหมู่ไม่ถูกต้อง", "error", "./manage_cat.php");
    exit();
}

$category_id = $_GET['id_category'];


// ลบหมวดหมู่ย่อยก่อน
$sql_delete_subcategories = "DELETE FROM sub_category WHERE id_category = '$category_id'";
if ($conn->query($sql_delete_subcategories)) {
    // ลบหมวดหมู่
    $sql_delete_category = "DELETE FROM category WHERE id_category = '$category_id'";
    if ($conn->query($sql_delete_category)) {
        echo generateAlert("ลบหมวดหมู่และหมวดหมู่ย่อยเรียบร้อยแล้ว", "success", "./manage_cat.php");
    } else {
        echo generateAlert("เกิดข้อผิดพลาดในการลบหมวดหมู่: " . $conn->error, "error", "./manage_cat.php");
    }
} else {
    echo generateAlert("เกิดข้อผิดพลาดในการลบหมวดหมู่ย่อย: " . $conn->error, "error", "./manage_cat.php");
}

$conn->close();
