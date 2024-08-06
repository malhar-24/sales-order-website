<?php
// Start the session at the beginning of the script
session_start();

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
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmNewPassword"];

    // Validate if passwords match
    if ($newPassword !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Get username from session or wherever you have stored it
    $username = $_SESSION['username'];

    // Hash the new password
    $hashedPassword = $newPassword;

    // Update the password in the database
    // Assuming you have tables named 'company' and 'salesperson' with a column 'password'
    $sqlCompany = "UPDATE company SET password = '$hashedPassword' WHERE username = '$username'";
    $sqlSalesperson = "UPDATE salesperson SET password = '$hashedPassword' WHERE username = '$username'";

    if ($conn->query($sqlCompany) === TRUE) {
         // Registration successful, include script to redirect to index.html
         echo "<script>
         alert('Password Change successful! login with username and password!!!');
         window.location.href = 'index.html';
     </script>";
    } else if ($conn->query($sqlSalesperson) === TRUE) {
         // Registration successful, include script to redirect to index.html
         echo "<script>
         alert('Password Change successful! login with username and password!!!');
         window.location.href = 'index.html';
     </script>";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

