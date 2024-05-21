<?php
    session_start();
    $postData = file_get_contents("php://input");
    $servername = "localhost";  // Change this to your database server
    $username = "root";     // Change this to your database username
    $password = "";     // Change this to your database password
    $dbname = "skyhire";  // Change this to your database name
// If the POST data is not empty
if (!empty($postData)) {
    // Decode the JSON data
    $data = json_decode($postData, true);

    // Extract data
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $mobile= $data['number'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO customer (First_Name,Last_Name,Mobile_Number) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $firstname, $lastname, $mobile);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Failed to register user!";
    }
    $query="SELECT * FROM customer WHERE Mobile_Number='$mobile'";
    $result = $conn->query($query);
    if($result->num_rows == 1){
        $query1 = "SELECT * FROM customer WHERE Mobile_Number=?";
        $stmt=$conn->prepare($query1);
        $stmt->bind_param("i",$mobile);
        $stmt->execute();
        $stmt->bind_result($Customer_Id,$First_Name,$Last_Name,$Mobile_Number);
        $stmt->fetch();
        $stmt->close();
        if($Customer_Id || $First_Name || $Last_Name || $Mobile_Number){
            $_SESSION['Customer_Id']=$Customer_Id;
            $_SESSION['First_Name']=$First_Name;
            $_SESSION['Last_Name']=$Last_Name;
            $_SESSION['Mobile_Number']=$Mobile_Number;
            //header('location:http://localhost/drone-rental/Customer Dashboard/customer_dashboard.html');
        }
    }
    // Close connection
    $conn->close();
} else {
    // If POST data is empty
    echo "No data received";
}
$conn->close();
?>
