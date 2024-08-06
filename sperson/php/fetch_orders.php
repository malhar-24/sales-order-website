<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(array()); // Return an empty array if not logged in
    exit;
}

// Include your database connection code here
$servername = "localhost";
$username = "demo1";
$password = '123';
$dbname = "demo1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username associated with the session
$username = $_SESSION['username'];
$status = $_GET['status']; // Assuming you pass the status as a parameter

// Query to fetch orders based on the provided status and username
$sqlOrders = "SELECT * FROM orders WHERE status = ? AND username = ?";
$stmtOrders = $conn->prepare($sqlOrders);
$stmtOrders->bind_param("ss", $status, $username);
$stmtOrders->execute();
$result = $stmtOrders->get_result();

$orders = array();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Close the database connection
$stmtOrders->close();
$conn->close();

// Return JSON response
echo json_encode($orders);

?>
