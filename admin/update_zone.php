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
                        window.location.href = "../admin/login.php";
                    }
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zone_id = $_POST["zone_id"];
    $zone_name = $_POST["zone_name"];
    $zone_detail = $_POST["zone_detail"];
    $pricePerDate = $_POST["pricePerDate"];
    $pricePerMonth = $_POST["pricePerMonth"];
    // Check if there are locks with available = 1
    $check_locks_sql = "SELECT COUNT(*) AS count FROM locks WHERE zone_id = ? AND available = 1";
    $check_locks_stmt = $conn->prepare($check_locks_sql);
    $check_locks_stmt->bind_param("i", $zone_id);
    $check_locks_stmt->execute();
    $check_locks_result = $check_locks_stmt->get_result();
    $locks_row = $check_locks_result->fetch_assoc();
    $count = $locks_row['count'];

    // If there are locks with available = 1, notify and exit
    if ($count > 0) {
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ไม่สามารถอัปเดตโซนได้ มีล็อคที่ยังมีอยู่</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "ไม่สามารถอัปเดตโซนได้ มีล็อคที่ยังใช้งานอยู่",
                        icon: "error",
                        timer: 2000,
                        timerProgressBar: true, // แสดงแถบความก้าวหน้า
                        showConfirmButton: false // ซ่อนปุ่ม "OK"
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = "./crud_page.php";
                        }
                    });
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // Perform validation if needed
    if (empty($zone_name) || empty($zone_detail) || empty($pricePerDate) || empty($pricePerMonth)) {
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>กรุณากรอกข้อมูลในช่องที่ต้องกรอกทั้งหมด</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "กรุณากรอกข้อมูลในช่องที่ต้องกรอกทั้งหมด",
                        icon: "error",
                        timer: 2000,
                        timerProgressBar: true, // แสดงแถบความก้าวหน้า
                        showConfirmButton: false // ซ่อนปุ่ม "OK"
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = "./crud_page.php";
                        }
                    });
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // Prepare and execute the SQL update statement
    $sql = "UPDATE zone_detail
            SET 
                zone_name = ?, 
                zone_detail = ?, 
                pricePerDate = ?, 
                pricePerMonth = ? 
            WHERE 
                zone_id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("sssss", $zone_name, $zone_detail, $pricePerDate, $pricePerMonth, $zone_id);

        if ($stmt->execute()) {
            echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>อัพเดตโซนสำเร็จ</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "อัพเดตโซนสำเร็จ",
                                icon: "success",
                                timer: 2000, 
                                timerProgressBar: true, // แสดงแถบความก้าวหน้า
                                showConfirmButton: false // ซ่อนปุ่ม "OK"
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href = "./crud_page.php";
                                }
                            });
                        });
                    </script>
                </body>
                </html>';
        } else {
            echo "Error updating zone: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    header("Location: ./crud_page.php");
    exit();
}
