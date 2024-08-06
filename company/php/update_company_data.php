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
$company_name = isset($postData['company_name']) ? $postData['company_name'] : '';
$mission_statement = isset($postData['mission_statement']) ? $postData['mission_statement'] : '';
$ceo_name = isset($postData['ceo_name']) ? $postData['ceo_name'] : '';
$founded_date = isset($postData['founded_date']) ? $postData['founded_date'] : '';
$industry = isset($postData['industry']) ? $postData['industry'] : '';
$description = isset($postData['description']) ? $postData['description'] : '';
$location = isset($postData['location']) ? $postData['location'] : '';
$phone = isset($postData['phone']) ? $postData['phone'] : '';
$email = isset($postData['email']) ? $postData['email'] : '';
$website = isset($postData['website']) ? $postData['website'] : '';
$facebook = isset($postData['facebook']) ? $postData['facebook'] : '';
$twitter = isset($postData['twitter']) ? $postData['twitter'] : '';
$linkedin = isset($postData['linkedin']) ? $postData['linkedin'] : '';
$num_employees = isset($postData['num_employees']) ? $postData['num_employees'] : '';
$revenue = isset($postData['revenue']) ? $postData['revenue'] : '';

// Prepare SQL statement to update company data
$sql = "UPDATE company SET 
        company_name = ?,
        mission_statement = ?,
        ceo_name = ?,
        founded_date = ?,
        industry = ?,
        description = ?,
        location = ?,
        phone = ?,
        email = ?,
        website = ?,
        facebook = ?,
        twitter = ?,
        linkedin = ?,
        num_employees = ?,
        revenue = ?
        WHERE username = ?";

// Bind parameters and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssssss", $company_name, $mission_statement, $ceo_name, $founded_date, $industry, $description, $location, $phone, $email, $website, $facebook, $twitter, $linkedin, $num_employees, $revenue, $_SESSION['username']);

if ($stmt->execute() === TRUE) {
    echo "Company data updated successfully";
} else {
    echo "Error updating company data: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
