<?php
// Sort products based on price (ascending or descending)
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the sort parameter is provided
    if (isset($_GET['sort'])) {
        // Get the sort option
        $sortOption = $_GET['sort'];
        
        // Connect to your database (replace placeholders with your actual database details)
        $servername = "localhost";
$username = "demo1";
$password = '123';
$dbname = "demo1";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define the SQL query based on the sort option
        $sql = "";
        if ($sortOption == "asc") {
            $sql = "SELECT * FROM product ORDER BY price ASC";
        } elseif ($sortOption == "desc") {
            $sql = "SELECT * FROM product ORDER BY price DESC";
        }

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output the sorted products
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
            echo "No products found.";
        }

        // Close the database connection
        $conn->close();
    } else {
        // Handle case when sort parameter is not provided
        echo "Sort parameter is missing.";
    }
} else {
    // Handle non-GET requests
    echo "Invalid request method.";
}
?>
