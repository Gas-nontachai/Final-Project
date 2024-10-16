<?php
session_start();
require("../condb.php");

// fetch_locks.php
if (isset($_POST['zone_id'])) {
    $zone_id = $_POST['zone_id'];

    // Query ข้อมูล
    $sql = "SELECT * FROM locks WHERE zone_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(['error' => 'ไม่สามารถเตรียมคำสั่ง SQL ได้: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $zone_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="d-flex flex-wrap gap-2">';
        while ($row = $result->fetch_assoc()) {
            $isAvailable = $row['available'];

            // เพิ่ม class และ disabled attribute ตามสถานะของล็อก
            $btnClass = $isAvailable ? 'btn-secondary' : 'btn-outline-primary';
            $btnDisabled = $isAvailable ? 'disabled' : '';
            $btnText = htmlspecialchars($row['lock_name']);

            echo '
                <div class="form-check">
                    <input class="form-check-input editlock-checkbox" type="checkbox" name="editid_locks[]" value="' . htmlspecialchars($row['id_locks']) . '" id="editlock' . htmlspecialchars($row['id_locks']) . '" style="display:none;">
                    <button type="button" class="btn ' . $btnClass . ' editlock-btn" data-lock-id="' . htmlspecialchars($row['id_locks']) . '" ' . $btnDisabled . '>' . $btnText . '</button>
                </div>
            ';
        }
        echo '</div>';
    } else {
        echo json_encode(['message' => 'ไม่มีข้อมูลสำหรับโซนที่เลือก']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ไม่มี zone_id ที่ส่งมา']);
}

$conn->close();
