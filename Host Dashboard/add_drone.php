<?php
session_start();
$host_id=$_SESSION['Host_Id'];
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define database connection variables
    $servername = "localhost";
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "skyhire";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data and sanitize
    $drone_name = mysqli_real_escape_string($conn, $_POST['drone-name']);
    $drone_type = mysqli_real_escape_string($conn, $_POST['drone-type']);
    $drone_model = mysqli_real_escape_string($conn, $_POST['drone-model']);
    $drone_certificate = mysqli_real_escape_string($conn, $_POST['certificate']);
    $description = mysqli_real_escape_string($conn, $_POST['drone-description']);

    // Construct SQL INSERT statement
    $sql = "INSERT INTO add_drone (Host_Id,Drone_Name, Drone_Type, Drone_Model, Drone_Certificate, Description)
            VALUES ('$host_id','$drone_name', '$drone_type', '$drone_model', '$drone_certificate', '$description')";

    // Execute SQL INSERT statement
    if ($conn->query($sql) === TRUE) {
        header('location:http://localhost/drone-rental/Host Dashboard/Host_Dashboard.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>
