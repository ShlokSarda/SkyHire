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
    $mobile= $data['number'];
    $rpc_number= $data['rpc_number'];
    $conn = new mysqli('localhost','root','','skyhire');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO pilot (First_Name,Last_Name,Mobile_Number,RPC_Number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $firstname, $lastname, $mobile, $rpc_number);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Failed to register user!";
    }
    $query="SELECT * FROM pilot WHERE Mobile_Number='$mobile'";
    $result = $conn->query($query);
    if($result->num_rows == 1){
        $query1 = "SELECT * FROM pilot WHERE Mobile_Number=?";
        $stmt=$conn->prepare($query1);
        $stmt->bind_param("i",$mobile);
        $stmt->execute();
        $stmt->bind_result($Pilot_Id_Id,$First_Name,$Last_Name,$Mobile_Number,$RPC_Number);
        $stmt->fetch();
        $stmt->close();
        if($Pilot_Id || $First_Name || $Last_Name || $Mobile_Number || $RPC_Number){
            $_SESSION['Pilot_Id']=$Pilot_Id;
            $_SESSION['First_Name']=$First_Name;
            $_SESSION['Last_Name']=$Last_Name;
            $_SESSION['Mobile_Number']=$Mobile_Number;
            $_SESSION['RPC_Number']=$RPC_Number;
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