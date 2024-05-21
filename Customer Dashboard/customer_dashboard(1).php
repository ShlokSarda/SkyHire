<?php
session_start();
    $postData = file_get_contents("php://input");

// If the POST data is not empty
if (!empty($postData)) {
    // Decode the JSON data
    $data = json_decode($postData, true);


    // Extract data from the received JSON
    $location = $data['location'];
    $purpose = $data['purpose'];
    $date = $data['date'];
    $hours = $data['hours'];
    $pilot = $data['pilot'];
    $time = $data['time'];
    //$name = $data['name'];
    //$number = $data['mobile'];
    
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = " "; // Replace with your database password
    $dbname = "skyhire"; // Replace with your database name

    // Create connection
    $conn = new mysqli('localhost','root','','skyhire');
    $number=$_SESSION['Mobile_Number'];
    $name=$_SESSION['First_Name'];
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql_id="select Customer_Id from customer where Mobile_Number='$number'";
    // Prepare SQL statement to insert data into a table
    $result = $conn->query($sql_id);
    if($result->num_rows > 0){
        while($row=$result->fetch_assoc()){
            $customer_id=$row['Customer_Id'];
            $sql = "INSERT INTO customer_bookings (Customer_Id, Customer_Name, Customer_Address, Purpose, Date, Hours, Time, Pilot) VALUES ('$customer_id','$name','$location' ,'$purpose', '$date', '$hours', '$time','$pilot')";
        }
    }
    
    
    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Request is in Process.";
        $query="SELECT * FROM customer_bookings";
        $result1 = $conn->query($query);
    if($result1->num_rows > 0){
        while($row1=$result1->fetch_assoc()){
            $Booking_Id=$row1['Booking_Id'];
            $Hours=$row1['Hours'];
            $Time=$row1['Time'];
            $Date=$row1['Date'];
            $Customer_Address=$row1['Customer_Address'];
            $Customer_Name=$row1['Customer_Name'];
            $query1="INSERT INTO host_bookings(Host_Id,Host_Name,Booking_Id,Customer_Name, Hours, Time, Date, Customer_Address) VALUES (NULL,NULL,'$Booking_Id','$Customer_Name','$Hours','$Time','$Date','$Customer_Address')";
        }
    }
        if ($conn->query($query1) === TRUE) {
        echo "successful!";
        } else {
        echo "Error: " . $query1 . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If the request method is not POST, return an error message
    echo "Error: Method not allowed";
}
?>
