<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bitebuzz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch only new restaurants (restaurant_id > 1011)
$sql = "SELECT * FROM restaurant WHERE restaurant_id > 1011 ORDER BY restaurant_id DESC";
$result = $conn->query($sql);

$restaurants = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $restaurants[] = $row;
  }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($restaurants);
?>
