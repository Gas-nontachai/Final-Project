<?php
header('Content-Type: application/json');
require("../condb.php");

// Check if required GET parameter is set
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prepare SQL statement to delete the user
    $sql = "DELETE FROM tbl_user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete user: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required parameter']);
}

$conn->close();
