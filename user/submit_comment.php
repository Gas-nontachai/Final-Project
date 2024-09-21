<?php
session_start();
require("../condb.php");

header('Content-Type: application/json');

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}
$current_time = date('Y-m-d H:i:s');
$user_id = $_SESSION["user_id"];
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['comment']) || !isset($data['rating'])) {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit();
}

$comment = mysqli_real_escape_string($conn, $data['comment']);
$rating = intval($data['rating']);

$sql = "INSERT INTO comments (user_id, comment, rating, created_at) VALUES ('$user_id', '$comment', '$rating', '$current_time')";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

mysqli_close($conn);
