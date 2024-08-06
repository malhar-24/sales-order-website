<?php
// Start the session at the beginning of the script
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted

    // Retrieve the OTP entered by the user
    $userOTP = $_POST["otp"];

    // Retrieve the OTP stored in the session
    $storedOTP = $_SESSION['otp'];

    if ($userOTP == $storedOTP) {
        // OTP is correct
        echo "success";
    } else {
        // OTP is incorrect
        echo "error";
    }
}
?>
