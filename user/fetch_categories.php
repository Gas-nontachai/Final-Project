<?php
include '../condb.php'; // Make sure to include your database connection

if (isset($_GET['zoneName'])) {
    $zoneName = $_GET['zoneName'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM category AS C LEFT JOIN zone_detail AS Z ON C.zone_allow = Z.zone_id WHERE zone_name = ?");
    $stmt->bind_param("s", $zoneName);
    $stmt->execute();
    $result = $stmt->get_result();

    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row; // Collect categories
    }

    // Return categories as JSON
    echo json_encode($categories);
    exit; // Exit to prevent further output
}

// Close the database connection
$conn->close();
