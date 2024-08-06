<?php
// Database connection
$servername = "localhost";
$username = "demo1";
$password = '123';
$dbname = "demo1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all distinct product names from the orders table
$sql = "SELECT DISTINCT product_name FROM orders";
$result = $conn->query($sql);

$productNames = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productNames[] = $row['product_name'];
    }
}

$conn->close();

// Return product names in JSON format
header('Content-Type: application/json');
echo json_encode($productNames);
?>
