<?php
session_start(); // Start the session at the beginning of the script

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to your database (replace placeholders with your actual database details)
    $servername = "localhost";
    $username = "demo1";
    $password = '123';
    $dbname = "demo1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve username from session
    $username = $_SESSION['username'];

    // Fetch company id from the company table based on the username
    $sql = "SELECT company_id FROM company WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Company found, fetch the id
        $row = $result->fetch_assoc();
        $companyId = $row['company_id'];

        // Fetch all products belonging to the company
        $sql = "SELECT * FROM product WHERE company_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any products
        if ($result->num_rows > 0) {
            // Output each product in a product box
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-box">';
                echo '<div class="img-container">';
                echo '<img src="company/' . $row['image_url'] . '" alt="Product Image">';
                echo '</div>';
                echo '<div class="product-name">Name:' . $row['product_name'] . '</div>';
                echo '<div class="product-price">Price:' . $row['price'] . '  Stock: ' . $row['stock'] . '</div>';
                echo '<form method="post" action="php/delete_product.php">';
                echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
                echo '<button class="delete-btn" ><i class="fa fa-trash"></i></button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            // No products found
            echo '<p>No products available.</p>';
        }
    } else {
        // Company not found
        echo '<p>Company not found.</p>';
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}



?>