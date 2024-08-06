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

// Retrieve company name associated with the session username
$username = $_SESSION['username'];
$companyName = '';

$sqlCompany = "SELECT company_name FROM company WHERE username = ?";
$stmtCompany = $conn->prepare($sqlCompany);
$stmtCompany->bind_param("s", $username);
$stmtCompany->execute();
$stmtCompany->bind_result($companyName);
$stmtCompany->fetch();
$stmtCompany->close();

if (empty($companyName)) {
    echo json_encode(array()); // Return an empty array if company name not found
    exit;
}

// Fetch orders based on the provided status
$status = $_GET['status'];
$sqlOrders = "SELECT * FROM orders WHERE company_name = ? AND status = ?";
$stmtOrders = $conn->prepare($sqlOrders);
$stmtOrders->bind_param("ss", $companyName, $status);
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
