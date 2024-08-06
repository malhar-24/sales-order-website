<?php
session_start();

// Database connection parameters
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

// Initialize an empty array to store product names
$productNames = array();

// Fetch all product names based on the selected report type
if ($_GET['salesperson'] === 'all') {
    // Fetch all product names
    $sql = "SELECT DISTINCT product_name FROM product";
} else {
    // Fetch product names associated with the current user
    $username = $_SESSION['username']; // Assuming 'username' is the session key for the current user
    $sql = "SELECT DISTINCT product_name FROM product";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        array_push($productNames, $row['product_name']);
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();

// Return JSON response with product names
header('Content-Type: application/json');
echo json_encode($productNames);
?>
