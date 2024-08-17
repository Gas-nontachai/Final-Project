<?php
require("../condb.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $openingTime = $_POST['opening_time'];
    $closingTime = $_POST['closing_time'];

    // อัปเดตเวลาในฐานข้อมูล
    $sql = "UPDATE operating_hours SET opening_time = ?, closing_time = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $openingTime, $closingTime);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "fail";
    }
}
