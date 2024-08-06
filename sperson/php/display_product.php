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

// Pagination
$limit = 20; // Products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM product LIMIT $start, $limit";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product-box">';
        echo '<div class="product-img"><img src="../company/images/' . $row['image_url'] . '" alt="Product Image"></div>';
        echo '<div class="product-info">';
        echo '<h3>' . $row['product_name'] . '</h3>';
        echo '<p>Price: $' . $row['price'] . '  Stock: ' . $row['stock'] . '</p>';
        // Pass product details to JavaScript function
        echo '<button class="buy-btn" onclick="showOrderForm(\'' . $row['product_name'] . '\')" 
      data-productname="' . $row['product_name'] . '">
      <i class="fas fa-shopping-cart"></i> Buy
      </button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No products found.</p>';
}

$conn->close();
?>
