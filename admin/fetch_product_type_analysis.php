<?php
session_start();
require("../condb.php");

// Get start and end dates from the query parameters, default to the last 7 days if not set
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-7 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Query to get booking counts by product category within the specified date range
$query = "
SELECT 
    c.cat_name AS product_category,
    COUNT(b.id_booked) AS booking_amount
FROM 
    booked b
LEFT JOIN 
    category c ON b.product_type = c.id_category
WHERE 
    b.booking_date BETWEEN '$start_date' AND '$end_date'  -- Adjust 'booking_date' to your actual date column
GROUP BY 
    c.cat_name
";
$result = mysqli_query($conn, $query);

// Prepare data for the chart
$data = [];
$data['labels'] = [];
$data['booking_amounts'] = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data['labels'][] = $row['product_category'];
    $data['booking_amounts'][] = $row['booking_amount'];
}

// Send data as JSON
echo json_encode($data);
