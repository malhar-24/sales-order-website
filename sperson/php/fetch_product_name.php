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

// Get the product name from the request
$productName = $_GET['productName'];

// Query to fetch all data for the product including company name
$sql = "SELECT product.*, company.company_name 
        FROM product 
        INNER JOIN company ON product.company_id = company.company_id 
        WHERE product.product_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $productName);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the first row (assuming product name is unique)
    $row = $result->fetch_assoc();
    
    // Filter out the required fields
    $data = array(
        "image_url" => $row['image_url'],
        "product_name" => $row['product_name'],
        "price" => $row['price'],
        "stock" => $row['stock'],
        "description" => $row['description'],
        "company_name" => $row['company_name']
    );
    
    // Encode the data as JSON and echo it
    echo json_encode($data);
} else {
    echo "Product not found";
}

$stmt->close();
$conn->close();
?>

