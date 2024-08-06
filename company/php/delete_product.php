<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Connect to your database (replace placeholders with your actual database details)
    $servername = "localhost";
    $username = "demo1";
    $password = '123';
    $dbname = "demo1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve product ID from the form submission
    $productId = $_POST['product_id'];

    // Delete related records from the salesperson_product table
    $sqlDeleteSalespersonProduct = "DELETE FROM salesperson_product WHERE product_id = ?";
    $stmtDeleteSalespersonProduct = $conn->prepare($sqlDeleteSalespersonProduct);
    $stmtDeleteSalespersonProduct->bind_param("i", $productId);
    $stmtDeleteSalespersonProduct->execute();
    $stmtDeleteSalespersonProduct->close();

    // Prepare and execute SQL query to delete the product
    $sql = "DELETE FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect back to the page where the product was deleted from
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
} else {
    // If product ID is not set or the form was not submitted via POST method, redirect to homepage or an error page
    header("Location: index.php"); // Replace "index.php" with the appropriate page
    exit;
}

?>
