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

// Check if username is set in session
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Query to fetch company data
    $sql = "SELECT * FROM salesperson WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Fetch and output data
        $companyData = $result->fetch_assoc();

        // Set header to indicate JSON response
        header('Content-Type: application/json');

        // Output JSON data
        echo json_encode($companyData);
    } else {
        echo "No data found";
    }
} else {
    echo "Username not set in session";
}

// Close connection
$conn->close();
?>


