<?php
// Define database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drainage_system";

// Create connection to MySQL database using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
  // If not, stop the script and print the error
  die("Connection failed: " . $conn->connect_error);
}

// Get the 'approval' value from the submitted POST request (from HTML form or AJAX)
$approval = $_POST['approval'];
// Get the 'complaint_id' value from the submitted POST request
$complaint_id = $_POST['complaint_id'];

// Prepare SQL query to check if the complaint with the given ID exists
$fetch_complaint = "SELECT id FROM complaints WHERE id=$complaint_id";
// Run the query and store the result
$fetch_complaint_result = $conn->query($fetch_complaint);

// If at least one complaint is found with that ID
if ($fetch_complaint_result->num_rows > 0) {
    // Prepare an UPDATE query to update the 'approval' field in the complaints table
    $sql = "UPDATE complaints SET approval='$approval' WHERE id=$complaint_id";
    
    // Execute the update query
    if ($conn->query($sql) === TRUE) {
        // If update is successful, print "success"
        echo "success";
    } else {
        // If there's an error in the update query, print the error message
        echo "Error updating record: " . $conn->error;
    }
} else {
    // If the complaint ID doesn't exist in the database, print "fail"
    echo 'fail';
}

// End the script
die();
?>
