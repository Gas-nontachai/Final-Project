<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$commentId = $data['id'];
$comment = mysqli_real_escape_string($conn, $data['comment']);
$rating = (int)$data['rating'];
$user_id = $_SESSION['user_id'];

$sql = "UPDATE comments SET comment='$comment', rating='$rating' WHERE id='$commentId' AND user_id='$user_id'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update comment"]);
}
