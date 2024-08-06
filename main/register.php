<?php
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

    // Get form data
    $registerAs = $_POST["registerAs"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $Quantity = 0;

    // Additional data based on registration type
    if ($registerAs == "salesperson") {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];

        // Save data to salesperson table
        $sql = "INSERT INTO salesperson (first_name, last_name, email, phone, username, password,total_quantity_sold)
                VALUES ('$firstName', '$lastName', '$email', '$phone', '$username', '$password','$Quantity')";
    } elseif ($registerAs == "company") {
        $companyName = $_POST["companyName"];

        // Save data to company table
        $sql = "INSERT INTO company (company_name, email, phone, username, password)
                VALUES ('$companyName', '$email', '$phone', '$username', '$password')";
    }

    if ($conn->query($sql) === TRUE) {
        // Registration successful, include script to redirect to index.html
        echo "<script>
                alert('Registration successful! login with username and password!!!');
                window.location.href = 'index.html';
            </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>


