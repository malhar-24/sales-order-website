<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $uname = $_POST['uname'];
    $satisfy = isset($_POST['satisfy']) ? $_POST['satisfy'] : '';
    $rating = $_POST['rating'];
    $msg = $_POST['msg'];
    $order_id = $_POST['order_id']; // Retrieve order ID from the hidden input field

    // Establish database connection
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

    // Fetch product name associated with the order ID
    $product_name = '';
$sql_fetch_product_name = "SELECT product_name FROM orders WHERE order_id = ?";
$stmt_product_name = $conn->prepare($sql_fetch_product_name);
$stmt_product_name->bind_param("i", $order_id);
$stmt_product_name->execute();
$result_product_name = $stmt_product_name->get_result();
if ($result_product_name->num_rows > 0) {
    $row_product_name = $result_product_name->fetch_assoc();
    $product_name = $row_product_name['product_name'];
}
$stmt_product_name->close();

    // Prepare and bind the SQL statement for feedback insertion
    $stmt = $conn->prepare("INSERT INTO feedback (uname, satisfy, rating, msg, product_name, order_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissi", $uname, $satisfy, $rating, $msg, $product_name, $order_id);

    // Execute the SQL statement
    if ($stmt->execute() === TRUE) {
        echo "<script>
                alert('Registration successful! login with username and password!!!');
                window.location.href = '../index.html';
            </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>


