<?php
// Define database connection credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drainage_system";

// Create connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed
if ($conn->connect_error) {
  // Stop script and display error if connection fails
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data sent via POST method
$issue = $_POST['issue'];              // The selected issue type (e.g., Drainage Problem)
$area = $_POST['area'];                // The selected area (e.g., Marripalem)
$description = $_POST['description'];  // The text description of the complaint

$photoPath = ''; // Initialize the photo path variable (to store image URL later)

// Check if a file was uploaded and there was no error
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {

  $uploadDir = "uploads/"; // Folder where uploaded files will be saved

  // If the uploads directory doesn't exist, create it with permissions
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // true => create directories recursively
  }

  // Rename the file by prepending current timestamp to avoid name conflicts
  $fileName = time() . '_' . basename($_FILES['photo']['name']);

  // Full file path including uploads/ folder
  $targetFile = $uploadDir . $fileName;

  // Move uploaded file from temp location to target folder
  if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {

    // Get the server host (like localhost or domain)
    $host = $_SERVER['HTTP_HOST'];

    // Get the folder path where the script is running (e.g., /csp/csp)
    $projectFolder = dirname($_SERVER['PHP_SELF']);

    // Full URL of the uploaded image (to be stored in DB)
    $photoPath = "http://$host$projectFolder/$targetFile";

  } else {
    // If moving file fails, return error and stop script
    echo "Error uploading file.";
    exit;
  }

} else {
  // If file not uploaded or some error occurred, return message and stop script
  echo "Photo not uploaded.";
  exit;
}

// SQL query to insert complaint data into database table 'complaints'
// 'hold' is the default value for approval status
$sql = "INSERT INTO complaints (issue, complaint_description, area, photo, approval)
        VALUES (?, ?, ?, ?, 'hold')";

// Prepare SQL statement to avoid SQL injection
$stmt = $conn->prepare($sql);

// Bind the parameters to the statement (s = string type for each)
$stmt->bind_param("ssss", $issue, $description, $area, $photoPath);

// Execute the statement and check for success
if ($stmt->execute()) {
  echo "success"; // Response sent back to AJAX success block
} else {
  // If insert fails, show error message
  echo "DB Error: " . $stmt->error;
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();
?>
