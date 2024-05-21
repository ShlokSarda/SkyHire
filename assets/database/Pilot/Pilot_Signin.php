<?php
session_start();
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
else{
    $query="SELECT * FROM pilot WHERE Mobile_Number='$number'";
    $result = $conn->query($query);
    if($result->num_rows == 1){
        $query1 = "SELECT * FROM pilot WHERE Mobile_Number=?";
        $stmt=$conn->prepare($query1);
        $stmt->bind_param("i",$number);
        $stmt->execute();
        $stmt->bind_result($Pilot_Id,$First_Name,$Last_Name,$Mobile_Number,$RPC_Number);
        $stmt->fetch();
        $stmt->close();
        if($Host_Id || $First_Name || $Last_Name || $Mobile_Number || $Use_Case || $Host_Address){
            $_SESSION['Pilot_Id']=$Pilot_Id;
            $_SESSION['First_Name']=$First_Name;
            $_SESSION['Last_Name']=$Last_Name;
            $_SESSION['Mobile_Number']=$Mobile_Number;
            $_SESSION['RPC_Number']=$RPC_Number;
            //header('location:http://localhost/drone-rental/Customer Dashboard/customer_dashboard.html');
        }
        echo "Number already in use";
    }
    else{
        echo "Number available";
    }
}
$conn->close();
?>
