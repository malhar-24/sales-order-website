<?php
session_start();

// Database connection
$servername = "localhost";
$username = "demo1";
$password = '123';
$dbname = "demo1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Get logged-in user's username
$username = $_SESSION['username'];

// Fetch data based on report type
$reportType = $_GET['type'];
$timeline = $_GET['timeline'];

if ($reportType === 'products') {
    // If report type is products, check if a specific product is selected
    $productCondition = "";
    if (isset($_GET['product']) && $_GET['product'] !== 'all') {
        $selectedProduct = $_GET['product'];
        $productCondition = "AND product_name = '$selectedProduct'";
    }

    // Fetch data for the logged-in user
    $sql = "SELECT product_name, quantity, total FROM orders WHERE company_username = ? AND status = 'Done' $productCondition";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Fetch data for the logged-in user
    $sql = "SELECT username, SUM(quantity) AS total_quantity, SUM(total) AS total_revenue FROM orders WHERE company_username = ? AND status = 'Done' GROUP BY username";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
}

$data = array(
    'labels' => array(),
    'data' => array(
        'quantity' => array(),
        'revenue' => array()
    )
);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($data['labels'], $row['username'] ?? $row['product_name']); // Use username for salesperson report, product name for product report
        array_push($data['data']['quantity'], $row['total_quantity'] ?? $row['quantity']); // Use total_quantity for salesperson report, quantity for product report
        array_push($data['data']['revenue'], $row['total_revenue'] ?? $row['total']); // Use total_revenue for salesperson report, total for product report
    }
}

$stmt->close();
$conn->close();

// Return data in JSON format
header('Content-Type: application/json');
echo json_encode($data);
?>
