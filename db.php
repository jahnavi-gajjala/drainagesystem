<?php
// Define database connection parameters
$host = 'localhost';     // The hostname where the MySQL server is running (usually 'localhost' for local server)
$db   = 'drainage_system'; // The name of the database you want to connect to
$user = 'root';          // The username used to connect to the database (default is 'root' in XAMPP)
$pass = '';              // The password for the database user (default is empty in XAMPP)
$charset = 'utf8mb4';    // Character encoding used for the database connection (supports emojis and special characters)

// Create a DSN (Data Source Name) string used by PDO to connect to MySQL
$dsn = "mysql:host=$host;dbname=$drainage_system;charset=$charset";
// Note: This line has an error: $drainage_system should be $db

// Set PDO options to handle errors and fetching mode
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors (safer error handling)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC         // Fetch results as associative arrays (column names as keys)
];

try {
    // Try to create a new PDO instance (attempt database connection)
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If connection fails, catch the exception and display the error message
    die("Database connection failed: " . $e->getMessage());
}
?>
