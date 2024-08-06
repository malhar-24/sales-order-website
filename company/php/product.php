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

        // Get form data
        $productName = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $total_sold = 0;

        // Upload image
        $targetDir = "../images/product/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Prepare SQL statement to insert data into the products table
                $sql = "INSERT INTO product (company_id, total_quantity_sold, product_name, description, price, stock, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iisssis", $companyId, $total_sold, $productName, $description, $price, $quantity, $targetFile);

                // Execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to index.html after successful insertion
                    header("Location: ../index.html");
                    exit;
                } else {
                    // Error adding product
                    echo json_encode(['success' => false, 'message' => 'Error adding product: ' . $conn->error]);
                }

                // Close statement
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Company not found
        echo json_encode(['success' => false, 'message' => 'Company not found']);
    }

    // Close database connection
    $conn->close();
}
?>
