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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zone_name = $_POST["zone_name"];
    $zone_detail = $_POST["zone_detail"];
    $pricePerDate = $_POST["pricePerDate"];
    $pricePerMonth = $_POST["pricePerMonth"];
    $amount = $_POST["amount"];

    if (empty($zone_name) || empty($zone_detail) || empty($pricePerDate) || empty($pricePerMonth) || empty($amount)) {
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
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                    }).then((result) => {
                            window.location.href = "./crud_page.php";
                    });
                });
            </script>
        </body>
        </html>';
        exit();
    }

    $sql = "INSERT INTO zone_detail 
            (zone_name, zone_detail, pricePerDate, pricePerMonth) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $zone_name, $zone_detail, $pricePerDate, $pricePerMonth);

    if ($stmt->execute()) {
        // Retrieve the last inserted zone ID
        $zone_id = $stmt->insert_id;

        // Prepare the SQL for inserting locks
        $lock_sql = "INSERT INTO locks (lock_name, zone_id, available) VALUES (?, ?, '0')";
        $lock_stmt = $conn->prepare($lock_sql);

        // Loop through the amount and insert locks
        for ($i = 1; $i <= $amount; $i++) {
            $lock_name = $zone_name . $i; // You can format the lock name as needed
            $lock_stmt->bind_param("si", $lock_name, $zone_id);
            if (!$lock_stmt->execute()) {
                echo "เพิ่มล็อค $i: ไม่สำเร็จ" . $lock_stmt->error;
                $lock_stmt->close();
                $stmt->close();
                exit();
            }
        }

        // ตั้งค่าการแสดงการแจ้งเตือนด้วย SweetAlert2
        echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>เพิ่มโซนสำเร็จ</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "เพิ่มโซนสำเร็จ",
                                icon: "success",
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                            }).then((result) => {
                                    window.location.href = "./crud_page.php";
                            });
                        });
                    </script>
                </body>
                </html>';
        $lock_stmt->close();
    } else {
        echo "เพิ่มโซนไม่สำเร็จ: " . $stmt->error;
    }
    $stmt->close();
}
