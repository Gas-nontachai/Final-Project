<?php
$conn = mysqli_connect("localhost", "root", "", "market_booking");
mysqli_query($conn, "SET NAMES 'utf8' ");
try {
  $db = new PDO("mysql:host=localhost; dbname=market_booking;", "root", "");
} catch (\Throwable $th) {
  //throw $th;
}

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
} else {
  // echo "<h1> connect success!! </h1>";
}
// date_default_timezone_set('Asia/Bangkok');