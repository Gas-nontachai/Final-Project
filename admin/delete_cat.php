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
                    showConfirmButton: false // ซ่อนปุ่ม "OK"
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

if (isset($_GET['id_category'])) {
    $id_category = intval($_GET['id_category']);

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Delete subcategories first
        $sub_sql = "DELETE FROM sub_category WHERE id_category = ?";
        $stmt = $conn->prepare($sub_sql);
        $stmt->bind_param("i", $id_category);
        $stmt->execute();

        // Check if subcategory deletion was successful
        if ($stmt->affected_rows > 0) {
            // Delete category
            $cat_sql = "DELETE FROM category WHERE id_category = ?";
            $stmt = $conn->prepare($cat_sql);
            $stmt->bind_param("i", $id_category);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $conn->commit();
                echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>ลบประเภทหลักและประเภทย่อยสำเร็จ</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "ลบประเภทหลักและประเภทย่อยสำเร็จ",
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
                throw new Exception("ลบประเภทหลักไม่สำเร็จ.");
            }
        } else {
            throw new Exception("ลบประเภทย่อยไม่สำเร็จ.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>คำขอผิดพลาด</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "เออเร่อ: ' . $e->getMessage() . '",
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
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>คำขอผิดพลาด</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "คำขอผิดพลาด",
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
}
