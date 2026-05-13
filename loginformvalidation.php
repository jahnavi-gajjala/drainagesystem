<?php
// Set database server connection values
$servername = "localhost";     // Hostname of the MySQL server
$username = "root";            // Username to connect to MySQL (default for XAMPP is 'root')
$password = "";                // Password (default is empty for 'root' in XAMPP)
$dbname = "drainage_system";   // Name of the database to use

// ===== Create connection =====
$conn = new mysqli($servername, $username, $password, $dbname); // Create a new MySQLi object to connect

// ===== Check if connection was successful =====
if ($conn->connect_error) { // If there’s a connection error
  die("Connection failed: " . $conn->connect_error); // Stop execution and display the error
}

// ===== Get form data sent via POST method =====
$user_name = $_POST['username'];      // Fetch the 'username' input from the login form
$password = $_POST['password'];       // Fetch the 'password' input from the login form
$personValue = $_POST['personValue']; // Fetch the 'personValue' (user role) from the login form (e.g., citizen, gvmcemp)

// ===== Prepare SQL query to fetch user =====
$fetch_user = "SELECT userid FROM users WHERE username='$user_name' AND user_password='$password' AND user_role='$personValue'";
// This query checks if there's a user with matching username, password, and role in the 'users' table

$fetch_user_result = $conn->query($fetch_user); // Execute the SQL query

// ===== Check if any matching user was found =====
if ($fetch_user_result->num_rows > 0) {
    echo 'success'; // If at least one row is returned, login is successful
} else {
    echo 'fail'; // If no rows match, login failed
}

// ===== Close database connection =====
$conn->close(); // Good practice to close the connection after use

die(); // End the script
?>
