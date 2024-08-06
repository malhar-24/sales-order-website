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

// Function to create the directory if it doesn't exist
function createDirectory($directory) {
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true); // Create directory recursively with full permissions
    }
}

// Directory to store company logos
$target_dir = "img/company_logo/";
createDirectory($target_dir); // Ensure directory exists

// Check if image file is uploaded
if(isset($_FILES["image"])) {
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo json_encode(array("error" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."));
            exit;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo json_encode(array("error" => "Sorry, file already exists."));
            exit;
        }

        // Delete previous image if it exists
        $sql_select_image = "SELECT image_path FROM company WHERE username = ?";
        $stmt_select_image = $conn->prepare($sql_select_image);
        $stmt_select_image->bind_param("s", $_SESSION['username']);
        $stmt_select_image->execute();
        $stmt_select_image->bind_result($old_image_path);
        $stmt_select_image->fetch();
        $stmt_select_image->close();

        if (!empty($old_image_path) && file_exists($old_image_path)) {
            unlink($old_image_path); // Delete previous image file
        }

        // Upload new image
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Save image path in the database
            $image_path = "php/" . $target_file;

            // Prepare SQL statement to update company data with image path
            $sql = "UPDATE company SET image_path = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $image_path, $_SESSION['username']);

            // Execute SQL statement
            if ($stmt->execute() === TRUE) {
                echo json_encode(array("image_path" => $image_path));
            } else {
                echo json_encode(array("error" => "Error updating image path: " . $conn->error));
            }

            // Close statement
            $stmt->close();
        } else {
            echo json_encode(array("error" => "Sorry, there was an error uploading your file."));
        }
    } else {
        echo json_encode(array("error" => "File is not an image."));
    }
} else {
    echo json_encode(array("error" => "No image uploaded."));
}

// Close connection
$conn->close();
?>
