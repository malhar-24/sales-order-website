<?php

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

// Retrieve POST data
$orderId = $_POST['orderId'];
$newStatus = $_POST['status'];

// Update the order status in the database
$sql = "UPDATE orders SET status = ? WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newStatus, $orderId);

if ($stmt->execute()) {
    echo "Order status updated successfully";
} else {
    echo "Error updating order status: " . $conn->error;
}

$stmt->close();
$conn->close();

?>
