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

if (isset($_POST['category']) && isset($_POST['sub_category'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $subcategories = explode(' ', $_POST['sub_category']);

    foreach ($subcategories as $sub_category) {
        // ตรวจสอบว่าหมวดหมู่ย่อยมีอยู่แล้วหรือไม่
        $sql_check = "SELECT * FROM sub_category WHERE id_category = '$category' AND sub_cat_name = '$sub_category'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            // ถ้าหมวดหมู่ย่อยซ้ำ
            echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>หมวดหมู่ย่อยซ้ำ</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "หมวดหมู่ย่อย \'' . htmlspecialchars($sub_category, ENT_QUOTES) . '\' ซ้ำ!",
                                icon: "error",
                                showConfirmButton: true
                            }).then((result) => {
                                    window.history.back(); // กลับไปหน้าก่อนหน้า
                            });
                        });
                    </script>
                </body>
                </html>';
            exit(); // ออกจากลูปเพื่อไม่เพิ่มข้อมูลที่ซ้ำ
        }

        // ถ้าไม่ซ้ำ ให้เพิ่มลงฐานข้อมูล
        $sql_insert = "INSERT INTO sub_category (id_category, sub_cat_name) VALUES ('$category', '$sub_category')";

        if ($conn->query($sql_insert) !== TRUE) {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
            exit();
        }
    }

    // แสดงผลเมื่อเพิ่มข้อมูลสำเร็จ
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
                    showConfirmButton: true
                }).then((result) => {
                        window.location.href = "./manage_cat.php";
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
                    showConfirmButton: true
                }).then((result) => {
                    window.location.href = "./manage_cat.php";
                });
            });
        </script>
    </body>
    </html>';
}

$conn->close();
