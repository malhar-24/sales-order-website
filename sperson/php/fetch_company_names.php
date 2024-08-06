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

// Initialize an empty array to store company names
$companyNames = array();

// Fetch all company names based on the selected report type
if ($_GET['salesperson'] === '') {
    // Fetch all company names
    $sql = "SELECT DISTINCT company_name FROM company";
} else {
    // Fetch company names associated with the current user
    $username = $_SESSION['username']; // Assuming 'username' is the session key for the current user
    $sql = "SELECT DISTINCT company_name FROM company";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        array_push($companyNames, $row['company_name']);
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();

// Return JSON response with company names
header('Content-Type: application/json');
echo json_encode($companyNames);
?>
