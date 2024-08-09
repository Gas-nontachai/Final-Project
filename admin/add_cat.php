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

    echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>อัพเดตโซนเรียบร้อย</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "อัพเดตโซนเรียบร้อย",
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
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
