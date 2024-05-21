<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=skyhire', 'root', '');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Booking_Id"])) {
    $bookingId = $_POST["Booking_Id"];
    $PilotId = $_SESSION["Pilot_Id"]; // Assuming Host_Id is stored in session
    $PilotName = $_SESSION["First_Name"];
    $statement = $pdo->prepare("UPDATE pilot_bookings SET Pilot_Id = :PilotId, Pilot_Name = :PilotName WHERE Booking_Id = :bookingId");
    $statement->execute(array(':PilotId' => $PilotId, ':PilotName' => $PilotName,':bookingId' => $bookingId));
    
    // You may want to check for success or failure here
    echo "Booking updated successfully";
} else {
    // Handle invalid requests
    echo "Invalid request";
}
?>