<?php
require("../condb.php");

if (isset($_GET['zone_id'])) {
    $zone_id = $_GET['zone_id'];

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
        echo '<script>alert("Cannot delete zone. There are locks that are still available."); window.location.href = "./crud_page.php";</script>';
        exit();
    }

    // Proceed with deletion if no locks with available = 1
    $delete_locks_sql = "DELETE FROM locks WHERE zone_id = ?";
    $delete_locks_stmt = $conn->prepare($delete_locks_sql);
    $delete_locks_stmt->bind_param("i", $zone_id);

    if ($delete_locks_stmt->execute()) {
        // If locks deletion successful, proceed to delete zone detail
        $delete_zone_detail_sql = "DELETE FROM zone_detail WHERE zone_id = ?";
        $delete_zone_detail_stmt = $conn->prepare($delete_zone_detail_sql);
        $delete_zone_detail_stmt->bind_param("i", $zone_id);

        if ($delete_zone_detail_stmt->execute()) {
            // Success message
            echo '<script>alert("Zone deleted successfully!"); window.location.href = "./crud_page.php";</script>';
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }

        $delete_zone_detail_stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $delete_locks_stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request.']);
}

$conn->close();
?>
