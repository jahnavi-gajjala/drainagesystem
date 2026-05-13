<?php
// Define database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drainage_system";

// Create a new connection to the MySQL database using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
  // If connection failed, stop the script and display the error
  die("Connection failed: " . $conn->connect_error);
}

// Get the form data sent via POST request from the frontend
$name = $_POST['name'];           // Full name entered by user
$area = $_POST['area'];           // Area entered by user
$phone = $_POST['phone'];         // Phone number entered by user
$user_name = $_POST['email'];     // Email/Username entered by user
$password = $_POST['password'];   // Password entered by user

// Query to check if the username/email is already registered
$fetch_user = "SELECT userid FROM users WHERE username='$user_name'";
$fetch_user_result = $conn->query($fetch_user);

// If the query returns at least one row, user already exists
if ($fetch_user_result->num_rows > 0) {
    // Return "fail" as response (user already registered)
    echo 'fail';
} else {
    // If user does not exist, insert new user into the `users` table
    $sql = "INSERT INTO users (username, user_password, fullname, phonenumber, area, user_role) 
            VALUES ('$user_name', '$password', '$name', $phone, '$area', 'citizen')";

    // Execute the insert query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        // If insert was successful, return "success"
        echo "success";
    } else {
        // If there was an error in the query, display it
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();

// Stop the script
die();
?>
