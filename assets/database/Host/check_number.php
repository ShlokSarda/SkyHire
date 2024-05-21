<?php
// Database connection parameters
$servername = "localhost";  // Change this to your database server
$username = "root";     // Change this to your database username
$password = "";     // Change this to your database password
$dbname = "skyhire";  // Change this to your database name

// Get the email from the request
$number = $_GET['number'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to check if the email exists
$stmt = $conn->prepare("SELECT * FROM host WHERE mobile_number = ?");
$stmt->bind_param("i", $number);

// Execute the statement
$stmt->execute();
// Get the result
$result = $stmt->get_result();

// Check if any rows are returned (email exists)
if ($result->num_rows > 0) {
    echo "Number already in use";
} else {
    echo "Number available"; // Email is not in use
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
