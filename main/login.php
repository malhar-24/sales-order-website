<?php
session_start(); // Start the session at the beginning of the script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted

    // Connect to your database (replace placeholders with your actual database details)
    $servername = "localhost";
    $username = "demo1";
    $password = '123';
    $dbname = "demo1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data from the AJAX request
    $username1 = $_POST["username1"];
    $password1 = $_POST["password1"];

    // Validate credentials for company login
    $sqlCompany = "SELECT * FROM company WHERE username = '$username1' AND password = '$password1'";
    $resultCompany = $conn->query($sqlCompany);

    if ($resultCompany->num_rows > 0) {
        // Login successful for company
        $_SESSION['username'] = $username1; // Store the username in the session

        echo "company";
        exit();
    }

    // Validate credentials for salesperson login
    $sqlSalesperson = "SELECT * FROM salesperson WHERE username = '$username1' AND password = '$password1'";
    $resultSalesperson = $conn->query($sqlSalesperson);

    if ($resultSalesperson->num_rows > 0) {
        // Login successful for salesperson
        $_SESSION['username'] = $username1; // Store the username in the session
        echo "salesperson";
        exit();
    }

    // Login failed for both
    echo "invalid";
    exit();

    $conn->close();
}
?>



