<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Start the session at the beginning of the script
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted

    // Connect to your database (replace placeholders with your actual database details)
    $servername = "localhost";
    $username1 = "demo1";
    $password = '123';
    $dbname = "demo1";

    $conn = new mysqli($servername, $username1, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the username from the forgot password form
    $username = $_POST["forgotUsername"];

    // Check if the username exists in either the company or salesperson table
    $sql = "SELECT email FROM company WHERE username = '$username'
            UNION ALL
            SELECT email FROM salesperson WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username exists, retrieve the email
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Generate a random OTP (you can customize the length as needed)
        $otp = mt_rand(100000, 999999);

        // Store the OTP in the session for validation later
        $_SESSION['otp'] = $otp;
        $_SESSION['username'] = $username;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


        $mail = new PHPMailer(true);

        try {
            // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kmalhar64@gmail.com'; // SMTP username
        $mail->Password   = 'wdup veak pgxu kycf'; // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('kmalhar64@gmail.com', 'malhar');
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = 'Your OTP for password reset is: ' . $otp;

            // Send email
            $mail->send();
            echo 'success';
        } catch (Exception $e) {
            echo 'error';
        }
    } else {
        // Username doesn't exist
        echo "Username does not exist. Please enter a valid username.";
    }

    // Close the database connection
    $conn->close();
}
?>
