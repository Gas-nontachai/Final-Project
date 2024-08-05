<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "./crud_page.php";</script>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zone_id = $_POST["zone_id"];
    $zone_name = $_POST["zone_name"];
    $zone_detail = $_POST["zone_detail"];
    $pricePerDate = $_POST["pricePerDate"];
    $pricePerMonth = $_POST["pricePerMonth"];

    // Perform validation if needed
    if (empty($zone_name) || empty($zone_detail) || empty($pricePerDate) || empty($pricePerMonth)) {
        echo '<script>alert("Please fill in all required fields."); window.history.back();</script>';
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
            echo '<script>alert("Zone updated successfully!"); window.location.href = "./crud_page.php";</script>';
        } else {
            echo "Error updating zone: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    header("Location: ./crud_page.php");
    exit();
}
?>
