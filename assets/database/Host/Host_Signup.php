<?php
    session_start();
    $postData = file_get_contents("php://input");

// If the POST data is not empty
if (!empty($postData)) {
    // Decode the JSON data
    $data = json_decode($postData, true);
    // Extract data
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $usecase = $data['usecase'];
    $mobile= $data['number'];
    $hostaddress= $data['address'];
    $conn = new mysqli('localhost','root','','skyhire');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO host (First_Name,Last_Name,Mobile_Number,Use_Case,Host_Address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $firstname, $lastname, $mobile, $usecase , $hostaddress);

    // Execute the statement
    if ($stmt->execute()) {
        
    } else {
        echo "Failed to register user!";
    }
    $query="SELECT * FROM host WHERE Mobile_Number='$mobile'";
    $result = $conn->query($query);
    if($result->num_rows == 1){
        $query1 = "SELECT * FROM host WHERE Mobile_Number=?";
        $stmt=$conn->prepare($query1);
        $stmt->bind_param("i",$mobile);
        $stmt->execute();
        $stmt->bind_result($Host_Id,$First_Name,$Last_Name,$Mobile_Number,$Use_Case,$Host_Address);
        $stmt->fetch();
        $stmt->close();
        if($Host_Id || $First_Name || $Last_Name || $Mobile_Number || $Use_Case || $Host_Address){
            $_SESSION['Host_Id']=$Host_Id;
            $_SESSION['First_Name']=$First_Name;
            $_SESSION['Last_Name']=$Last_Name;
            $_SESSION['Mobile_Number']=$Mobile_Number;
            $_SESSION['Use_Case']=$Use_Case;
            $_SESSION['Host_Address']=$Host_Address;
            //header('location:http://localhost/drone-rental/Customer Dashboard/customer_dashboard.html');
        }
    }
    // Close connection
    $conn->close();
} else {
    // If POST data is empty
    echo "No data received";
}
?>