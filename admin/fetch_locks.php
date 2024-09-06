<?php
session_start();
require("../condb.php");

// fetch_locks.php
if (isset($_POST['zone_id'])) {
    $zone_id = $_POST['zone_id'];

    // Query ข้อมูล
    $sql = "SELECT * FROM locks WHERE zone_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $zone_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="d-flex flex-wrap gap-2">';
        while ($row = $result->fetch_assoc()) {
            $isAvailable = $row['available']; // Assume available is 1 or 0

            // เพิ่ม class และ disabled attribute ตามสถานะของล็อก
            $btnClass = $isAvailable ? 'btn-secondary' : 'btn-outline-primary';
            $btnDisabled = $isAvailable ? 'disabled' : '';
            $btnText = htmlspecialchars($row['lock_name']);

            echo '
                <div class="form-check">
                    <input class="form-check-input lock-checkbox" type="checkbox" name="id_locks[]" value="' . htmlspecialchars($row['id_locks']) . '" id="lock' . htmlspecialchars($row['id_locks']) . '" style="display:none;">
                    <button type="button" class="btn ' . $btnClass . ' lock-btn" data-lock-id="' . htmlspecialchars($row['id_locks']) . '" ' . $btnDisabled . '>' . $btnText . '</button>
                </div>
            ';
        }
        echo '</div>';
    } else {
        echo '<p>ไม่มีข้อมูลสำหรับโซนที่เลือก</p>';
    }

    $stmt->close();
    $conn->close();
}
?>
