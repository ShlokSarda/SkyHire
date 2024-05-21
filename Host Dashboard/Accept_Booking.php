<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=skyhire', 'root', '');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Booking_Id"])) {
    $bookingId = $_POST["Booking_Id"];
    $hostId = $_SESSION["Host_Id"]; // Assuming Host_Id is stored in session
    $hostName= $_SESSION["First_Name"];
    $hostAddress = $_SESSION["Host_Address"];
    $statement = $pdo->prepare("UPDATE host_bookings SET Host_Id = :hostId, Host_Name = :hostName WHERE Booking_Id = :bookingId");
    $success=$statement->execute(array(':hostId' => $hostId,':hostName' => $hostName ,':bookingId' => $bookingId));
    if($success==1){
        $rowCount = $statement->rowCount();
        if($rowCount>0){
            $statement1 = $pdo->prepare("SELECT * FROM host_bookings where Host_Id is NOT NULL");
            $statement1->execute();
            $bookings = $statement1->fetchAll(PDO::FETCH_ASSOC);
            // Return the bookings array as JSON
            $jsonBookings = json_encode($bookings);
            if(count($bookings)>0):
                foreach ($bookings as $booking):
                    $customerAddress=$booking['Customer_Address'];
                    $customerName=$booking['Customer_Name'];
                    $hostName=$booking['Host_Name'];
                    $hours=$booking['Hours'];
                    $time=$booking['Time'];
                    $date=$booking['Date'];
                    $query= $pdo->prepare("INSERT INTO pilot_bookings(Pilot_Id, Pilot_Name,Booking_Id, Customer_Name, Host_Id, Host_Name, Host_Address, Customer_Address, Hours_Flight, Time_Flight, Date)
                            VALUES (NULL,NULL,'$bookingId','$customerName','$hostId','$hostName','$hostAddress','$customerAddress','$hours','$time','$date')");
                    $query->execute();
                endforeach;
            endif;
        }
        else{
            echo "error1";
        }
    }
    // You may want to check for success or failure here
} else {
    // Handle invalid requests
    echo "Invalid request";
}
?>