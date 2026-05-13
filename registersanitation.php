<?php
// Define database connection variables
$servername = "localhost";   // Hostname of the MySQL server
$username = "root";          // MySQL username (default is 'root' for local)
$password = "";              // MySQL password (empty by default for localhost)
$dbname = "drainage_system"; // Name of the database to connect to

// Create a new connection to the MySQL database using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed
if ($conn->connect_error) {
  // If connection fails, terminate script and display error message
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data sent via POST method
$area = $_POST['area'];         // Get the area value from the form
$user_name = $_POST['email'];   // Get the email value from the form (used as username)
$password = $_POST['password']; // Get the password value from the form

// SQL query to check if the entered email (username) already exists in the users table
$fetch_user = "SELECT userid FROM users WHERE username='$user_name'";
$fetch_user_result = $conn->query($fetch_user); // Run the query and store result

// If the query returns any rows, it means the user already exists
if ($fetch_user_result->num_rows > 0) {
    echo 'fail'; // Send "fail" back to frontend (email already registered)
} else {
    // SQL query to insert a new user with role 'sanitationemp' (sanitation employee)
    // Since fullname and phonenumber are not collected, default values are used
    $sql = "INSERT INTO users (username, user_password, fullname, phonenumber, area, user_role) 
            VALUES ('$user_name', '$password', 'not required', 0, '$area', 'sanitationemp')";

    // Execute the insert query
    if ($conn->query($sql) === TRUE) {
        echo "success"; // Send "success" back to frontend on successful insert
    } else {
        // If insertion fails, show the error for debugging
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the MySQL database connection
$conn->close();

// Terminate the PHP script (good practice in scripts that send responses)
die();
?>
