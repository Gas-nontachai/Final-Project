<?php
session_start();
require("../condb.php");

// Check if the user is an admin and redirect if true
if ($_SESSION["userrole"] == 1) {
    session_destroy();
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ไม่มีสิทธิ์เข้าถึง</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "หน้านี้สำหรับผู้ใช้ทั่วไป คุณคือผู้ดูแลระบบ",
                    icon: "error",
                    showConfirmButton: true
                }).then((result) => {
                    window.location.href = "../login.php";
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

// Check if the user is logged in
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
                   showConfirmButton: true
                }).then((result) => {
                    window.location.href = "../login.php";
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

// Initialize variables
$member_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$shop_name = $_SESSION["shop_name"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $product_type = $_POST["category"];
    $sub_product_type = $_POST["subcategory"];
    $zone = $_POST["zone"];
    $booking_type = $_POST["typeReserve"];
    $booking_amount = $_POST["amount"];
    $booking_status = "1"; // Assuming "1" means booked
    $total_price = 0;

    // Calculate total price based on the booking type and amount
    $sql_price = "SELECT * FROM zone_detail WHERE zone_id = ?";
    $stmt = $conn->prepare($sql_price);

    if ($stmt) {
        $stmt->bind_param("i", $zone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($booking_type == "PerDay") {
                $total_price = $row['pricePerDate'] * $booking_amount;
            } elseif ($booking_type == "PerMonth") {
                $total_price = $row['pricePerMonth'] * $booking_amount;
            }
        }
        $stmt->close();
    }

    // Get the current date and time in the required format
    $current_time = date('Y-m-d H:i:s');

    // Insert booking information into the database
    $sql = "INSERT INTO booking (member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type, booking_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isssissss", $member_id, $booking_status, $booking_type, $zone, $booking_amount, $total_price, $product_type, $sub_product_type, $current_time);

        if ($stmt->execute()) {
            echo '<!DOCTYPE html>
            <html lang="th">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ส่งคำขอจองพื้นที่การขายเรียบร้อย</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "ส่งคำขอจองพื้นที่การขายเรียบร้อย \n กรุณาชำระเงิน จากนั้นระบบจะทำการยืนยันการจอง", 
                            icon: "success",
                            showConfirmButton: true
                        }).then(() => {
                            window.location.href = "./order.php";
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
                <title>เกิดข้อผิดพลาดในการจอง</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาดในการจอง ข้อมูลไม่ครบถ้วน",
                           icon: "error",
                           showConfirmButton: true
                        }).then(() => {
                            window.location.href = "./index.php";
                        });
                    });
                </script>
            </body>
            </html>';
        }

        $stmt->close();
    } else {
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>เกิดข้อผิดพลาดในการจอง</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาดในการจอง",
                        icon: "error",
                        showConfirmButton: true
                    }).then(() => {
                        window.location.href = "./index.php";
                    });
                });
            </script>
        </body>
        </html>';
    }

    $conn->close();
}
