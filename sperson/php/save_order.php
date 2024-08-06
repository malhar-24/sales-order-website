<?php

session_start();

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

// Get the order details from the POST request
$productName = $_POST['productName'];
$companyName = $_POST['companyName'];
$quantity = $_POST['quantity'];
$totalPrice = $_POST['totalPrice'];
$address = $_POST['address'];
$date = $_POST['date'];

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    // Handle the case where the username is not set in the session
    // You can redirect the user to a login page or handle it in any other way appropriate for your application
}


// Insert the order details into the database
$sql = "INSERT INTO orders (product_name, username, company_name, quantity, total, drop_address, order_date)
        VALUES ('$productName', '$username', '$companyName', '$quantity', '$totalPrice', '$address', '$date')";

if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully!";
} else {
    echo "Error placing order: " . $conn->error;
}

$conn->close();
?>