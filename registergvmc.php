<?php
// ====== Database connection details ======
$servername = "localhost";  // MySQL server (usually localhost for local dev)
$username = "root";         // MySQL username
$password = "";             // MySQL password (empty by default for localhost)
$dbname = "drainage_system"; // Name of the database you're working with

// ====== Create a connection to MySQL ======
$conn = new mysqli($servername, $username, $password, $dbname);

// ====== Check if connection was successful ======
if ($conn->connect_error) {
  // If there's a connection error, stop and show error message
  die("Connection failed: " . $conn->connect_error);
}

// ====== Get form values from POST request ======
$area = $_POST['area'];         // User's area input from the form
$user_name = $_POST['email'];   // User's email input from the form
$password = $_POST['password']; // User's password input from the form

// ====== Check if user already exists ======
$fetch_user = "SELECT userid FROM users WHERE username='$user_name'"; // Query to check for existing username
$fetch_user_result = $conn->query($fetch_user); // Run the query

// ====== If user exists already ======
if ($fetch_user_result->num_rows > 0) {
    echo 'fail'; // Send 'fail' back to AJAX if email already exists
} else {
    // ====== Insert new GMVC employee into the database ======
    $sql = "INSERT INTO users (username, user_password, fullname, phonenumber, area, user_role)
            VALUES ('$user_name', '$password', 'not required', 0, '$area', 'gvmcemp')";

    // ====== Check if insertion was successful ======
    if ($conn->query($sql) === TRUE) {
        echo "success"; // Send success response to AJAX
    } else {
        // If there's an error, print the error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// ====== Close the DB connection ======
$conn->close();

// ====== End script execution ======
die();
?>
