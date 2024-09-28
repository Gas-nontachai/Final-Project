<?php
session_start();
require("../condb.php");

// Get the start and end dates from the URL
$date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Validate the date inputs
if ($date === null || $end_date === null) {
    echo json_encode(['error' => 'Invalid date parameters.']);
    exit;
}

// Ensure the dates are in a valid format (YYYY-MM-DD)
if (!DateTime::createFromFormat('Y-m-d', $date) || !DateTime::createFromFormat('Y-m-d', $end_date)) {
    echo json_encode(['error' => 'Invalid date format.']);
    exit;
}

// Prepare the SQL query to prevent SQL injection
$query = "SELECT 
    zd.zone_name,
    COUNT(b.id_booked) AS booking_amount 
FROM booked b
JOIN zone_detail zd ON b.zone_id = zd.zone_id
WHERE DATE(b.booking_date) BETWEEN ? AND ?
GROUP BY zd.zone_name";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ss', $date, $end_date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Prepare data for the chart
$data = [
    'labels' => [],
    'booking_amounts' => []
];

while ($row = mysqli_fetch_assoc($result)) {
    $data['labels'][] = $row['zone_name'];
    $data['booking_amounts'][] = (int)$row['booking_amount']; // Cast to int for consistency
}

// Close the statement
mysqli_stmt_close($stmt);

// Send data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
