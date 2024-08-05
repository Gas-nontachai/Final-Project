<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "../admin/login.php";</script>';
    exit();
}

$member_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$shop_name = $_SESSION["shop_name"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $product_type = $_POST["category"];
    $sub_product_type = $_POST["subcategory"];
    $zone = $_POST["zone"];
    $booking_type = $_POST["typeReserve"];
    $booking_amount = $_POST["amount"];
    $booking_status = "1";
    $booking_lock_number = "NONE"; // Assuming this is needed
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

    // Insert the booking information into the database
    $sql = "INSERT INTO booking (member_id, booking_status, booking_type, zone_id, booking_amount, total_price, product_type, sub_product_type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isssisss", $member_id, $booking_status, $booking_type, $zone, $booking_amount, $total_price, $product_type, $sub_product_type);

        if ($stmt->execute()) {
            echo '<script>alert("การจองสำเร็จ"); window.location.href = "./index.php";</script>';
        } else {
            echo '<script>alert("เกิดข้อผิดพลาดในการจอง");</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("เกิดข้อผิดพลาดในการจอง");</script>';
    }

    $conn->close();
}
?>
