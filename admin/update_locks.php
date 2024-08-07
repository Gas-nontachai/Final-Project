<?php
session_start();
require("../condb.php");

// Check if form data is posted
if (isset($_POST['booking_id']) && isset($_POST['zone_id']) && isset($_POST['id_locks'])) {
    $booking_id = $_POST['booking_id'];
    $zone_id = $_POST['zone_id'];
    $lock_ids = $_POST['id_locks']; // Array of selected lock IDs

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update the status of selected locks
        $sql_locks = "UPDATE locks SET available = 1, booking_id = ? WHERE id_locks = ? AND zone_id = ?";
        $stmt_locks = $conn->prepare($sql_locks);

        foreach ($lock_ids as $lock_id) {
            $stmt_locks->bind_param('iii', $booking_id, $lock_id, $zone_id);
            $stmt_locks->execute();
        }

        // Get lock names for updating booking
        $sql_lock_names = "SELECT lock_name FROM locks WHERE id_locks IN (" . implode(',', array_fill(0, count($lock_ids), '?')) . ")";
        $stmt_lock_names = $conn->prepare($sql_lock_names);
        $stmt_lock_names->bind_param(str_repeat('i', count($lock_ids)), ...$lock_ids);
        $stmt_lock_names->execute();
        $result_lock_names = $stmt_lock_names->get_result();

        $lock_names = [];
        while ($row = $result_lock_names->fetch_assoc()) {
            $lock_names[] = $row['lock_name'];
        }
        $lock_names_str = implode(', ', $lock_names);

        // Update booking status and lock names
        $sql_booking = "UPDATE booking SET booking_status = 4, book_lock_number = ? WHERE booking_id = ?";
        $stmt_booking = $conn->prepare($sql_booking);
        $stmt_booking->bind_param('si', $lock_names_str, $booking_id);
        $stmt_booking->execute();

        // Commit the transaction
        $conn->commit();
        
        // Redirect to a success page or show a success message
        echo '<script>
                alert("ทำการปรับเปลี่ยนสถานะเรียบร้อย");
                window.location.href = "./confirm_reserve.php";
              </script>';
        exit();
        
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        
        // Output or log the error
        echo 'Error: ' . htmlspecialchars($e->getMessage());
    } finally {
        $stmt_locks->close();
        $stmt_lock_names->close();
        $stmt_booking->close();
        $conn->close();
    }
} else {
    echo 'Invalid request: Missing data.';
}
?>
