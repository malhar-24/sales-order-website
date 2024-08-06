<?php
session_start();

// Database connection parameters
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

// Retrieve the updated data sent from the client-side
$postData = json_decode(file_get_contents("php://input"), true);

// Check if the received data is empty or not
if (empty($postData)) {
    echo "Error: No data received.";
    exit;
}

// Extract data from the $postData array and perform basic validation
$name = isset($postData['company_name']) ? $postData['company_name'] : '';
$names = explode(" ", $name);
$first_name = isset($names[0]) ? $names[0] : '';
$last_name = isset($names[1]) ? $names[1] : '';
$email = isset($postData['email']) ? $postData['email'] : '';
$phone = isset($postData['phone']) ? $postData['phone'] : '';
$facebook = isset($postData['facebook']) ? $postData['facebook'] : '';
$twitter = isset($postData['twitter']) ? $postData['twitter'] : '';
$linkedin = isset($postData['linkedin']) ? $postData['linkedin'] : '';
$bio = isset($postData['bio']) ? $postData['bio'] : '';
$address = isset($postData['address']) ? $postData['address'] : '';
$languages_spoken = isset($postData['languages_spoken']) ? $postData['languages_spoken'] : '';
$area_of_expertise = isset($postData['area_of_expertise']) ? $postData['area_of_expertise'] : '';
$communication_skill = isset($postData['communication_skill']) ? $postData['communication_skill'] : '';
$followed_technique = isset($postData['followed_technique']) ? $postData['followed_technique'] : '';
$education = isset($postData['education']) ? $postData['education'] : '';

// Prepare SQL statement to update salesperson data
$sql = "UPDATE salesperson SET 
        first_name = ?,
        last_name = ?,
        email = ?,
        phone = ?,
        facebook = ?,
        twitter = ?,
        linkedin = ?,
        bio = ?,
        address = ?,
        languages_spoken = ?,
        area_of_expertise = ?,
        communication_skill = ?,
        followed_technique = ?,
        education = ?
        WHERE username = ?";

// Bind parameters and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssssss", $first_name, $last_name, $email, $phone,  $facebook, $twitter, $linkedin, $bio, $address, $languages_spoken, $area_of_expertise, $communication_skill, $followed_technique, $education, $_SESSION['username']);

if ($stmt->execute() === TRUE) {
    echo "Salesperson data updated successfully";
} else {
    echo "Error updating salesperson data: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
