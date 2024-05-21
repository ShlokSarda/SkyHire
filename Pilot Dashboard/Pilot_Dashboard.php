<?php
session_start();
$pilot_id=$_SESSION['Pilot_Id'];
$pdo = new PDO('mysql:host=localhost;dbname=skyhire', 'root', '');
$statement = $pdo->prepare("SELECT * FROM pilot_bookings where Pilot_Id is NULL");
$statement->execute();
$bookings = $statement->fetchAll(PDO::FETCH_ASSOC);
// Return the bookings array as JSON
$jsonBookings = json_encode($bookings);


$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$statement1 = $pdo->prepare("SELECT * FROM pilot_bookings WHERE Pilot_Id= :pilot_id AND Date = :date");
$statement1->bindParam(':pilot_id', $pilot_id);
$statement1->bindParam(':date', $date);
$statement1->execute();
$schedules = $statement1->fetchAll(PDO::FETCH_ASSOC);

// Return the bookings array as JSON
$jsonSchedules = json_encode($schedules);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://kit.fontawesome.com/670b3a3b0d.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="./Pilot_Dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>SkyHire-Pilot Dashboard</title>
</head>
<body>
    <header class="header" data-header>
        <div class="header-container">
            <a href="#">
                <img src="../assets/images/drone_02.png" style="margin-left: 25px;">
            </a>
        </div>
        <div class="container">
            <div class="button-container">
                <div class="account-button"><i class="fa-solid fa-user"></i><?php echo $_SESSION['First_Name'] ?><i class="fa-solid fa-caret-down" style="padding-left: 5px;"></i></div>
                <div class="dropdown-content">
                    <a href="./manage.php"><i class="fa-solid fa-gear"></i> Manage Account</a>
                    <a href="./support.php"><i class="fa-solid fa-headset"></i> Support</a>
                    <a href="#"><i class="fa-solid fa-clock-rotate-left"></i> Past Bookings</a>
                    <a href="#"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
                </div>
            </div>
        </div>
    </header>  
    <!--
        host dashboard
    -->
    <div class="main-container">
    <div class="container1">
        <div class="container1-1">
          <div class="pending-req">
            <h2>Pending Bookings</h2>
            <?php if (count($bookings) > 0): ?>
            <div class="scrollable-list">
            <?php foreach ($bookings as $booking): ?>
              <div class="booking">
              Booking Id: <?php echo $booking['Booking_Id']?><br>
              Customer Name: <?php echo $booking['Customer_Name']?><br>
              Host Name: <?php echo $booking['Host_Name']?><br>
              Hours: <?php echo $booking['Hours_Flight']?><br>
              Date: <?php echo $booking['Date']?><br>
              Time: <?php echo $booking['Time_Flight']?><br>
              Customer Address: <?php echo $booking['Customer_Address']?>
              Host Address: <?php echo $booking['Host_Address']?>
              </div>
              <button class="accept-button" onclick="acceptBooking(<?php echo $booking['Booking_Id']?>)">Accept</button>
              <button class="decline-button">Decline</button>
              <br><br>
              <?php endforeach; ?>
            </div>
            <?php else: ?>
                <h2 style="margin-left:30%; margin-top:10%; font-weight:200;">No requests</h2>
            <?php endif; ?>
        </div>
      </div>
    <hr style="width:90%; float:left; margin-left: 30px; margin-top:15px;">
    <div class="container1-2">
        <div class="Scheduled-bookings">
            <h2>Scheduled Bookings</h2>
            <?php if (count($schedules) > 0): ?>
            <div class="scrollable-list">
            <?php foreach ($schedules as $schedule): ?>
                <div class="booking">
                Booking Id: <?php echo $schedule['Booking_Id']?><br>
                Customer Name: <?php echo $schedule['Customer_Name']?><br>
                Hours: <?php echo $schedule['Hours']?><br>
                Date: <?php echo $schedule['Date']?><br>
                Time: <?php echo $schedule['Time']?><br>
                Customer Address: <?php echo $schedule['Customer_Address']?>
                </div>
                <br>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <h2 style="margin-left:30%; margin-top:10%; font-weight:200;">No requests</h2>
            <?php endif; ?>
        </div>
    </div>
    </div>
    <div class="wrapper" id="wrapper">
        <header>
          <p class="current-date"></p>
          <div class="icons">
            <span id="prev" class="material-symbols-rounded"><i class="fa-solid fa-chevron-left" style="font-size: 0.8rem;"></i></span>
            <span id="next" class="material-symbols-rounded"><i class="fa-solid fa-chevron-right" style="font-size: 0.8rem;"></i></span>
          </div>
        </header>
        <div class="calendar">
          <ul class="weeks">
            <li>Sun</li>
            <li>Mon</li>
            <li>Tue</li>
            <li>Wed</li>
            <li>Thu</li>
            <li>Fri</li>
            <li>Sat</li>
          </ul>
          <ul class="days"></ul>
        </div>
      </div>
      </div>
      <script src="./Pilot_Dashboard.js" defer></script>
</body>
</html>