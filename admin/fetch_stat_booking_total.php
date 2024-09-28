<?php
session_start();
require("../condb.php");

// Set default start and end dates
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-7 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Set content type to JSON
header('Content-Type: application/json');

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT 
            DATE(b.booking_date) AS booking_date, 
            COUNT(CASE WHEN b.booking_type = 'perMonth' THEN b.id_booked END) AS total_bookings_month,
            COUNT(CASE WHEN b.booking_type = 'perDay' THEN b.id_booked END) AS total_bookings_day,
            SUM(CASE WHEN b.booking_type = 'perMonth' THEN b.total_price ELSE 0 END) AS total_revenue_month,
            SUM(CASE WHEN b.booking_type = 'perDay' THEN b.total_price ELSE 0 END) AS total_revenue_day
        FROM booked b
        WHERE b.booking_date BETWEEN ? AND ? 
        GROUP BY booking_date
        ORDER BY booking_date ASC");

$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

$data = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = array("message" => "No data found");
}

$stmt->close();
$conn->close();

// Return the data as JSON
echo json_encode($data);
