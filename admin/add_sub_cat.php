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
                        timerProgressBar: true, // แสดงแถบความก้าวหน้า
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
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

if (isset($_POST['category']) && isset($_POST['sub_category'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $subcategories = explode(' ', $_POST['sub_category']);

    foreach ($subcategories as $sub_category) {
        $sql = "INSERT INTO sub_category (id_category, sub_cat_name) VALUES ('$category', '$sub_category')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }
    }
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>เพิ่มประเภทย่อยเรียบร้อย</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
        </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "เพิ่มประเภทย่อยเรียบร้อย",
                     icon: "success",
                                timer: 2000, 
                                timerProgressBar: true, // แสดงแถบความก้าวหน้า
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
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
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ข้อมูลผิดพลาด/สูญหาย!</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "ข้อมูลผิดพลาด/สูญหาย!",
                    icon: "error",
                        timer: 2000, 
                        timerProgressBar: true, // แสดงแถบความก้าวหน้า
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "./manage_cat.php";
                    }
                });
            });
        </script>
    </body>
    </html>';
}

$conn->close();
