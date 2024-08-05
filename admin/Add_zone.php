<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "../admin/login.php";</script>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zone_name = $_POST["zone_name"];
    $zone_detail = $_POST["zone_detail"];
    $pricePerDate = $_POST["pricePerDate"];
    $pricePerMonth = $_POST["pricePerMonth"];
    $amount = $_POST["amount"];

    if (empty($zone_name) || empty($zone_detail) || empty($pricePerDate) || empty($pricePerMonth) || empty($amount)) {
        echo '<script>alert("Please fill in all the fields."); window.location.href = "./crud_page.php";</script>';
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
                echo "Error adding lock $i: " . $lock_stmt->error;
                $lock_stmt->close();
                $stmt->close();
                exit();
            }
        }

        echo '<script>alert("Add Zone successfully!"); window.location.href = "./crud_page.php";</script>';
        $lock_stmt->close();
    } else {
        echo "Error adding zone: " . $stmt->error;
    }
    $stmt->close();
}
