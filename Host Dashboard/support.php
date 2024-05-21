<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/670b3a3b0d.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="./support.css">
    <title>Customer Support</title>
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
            <a href="#" class="trips"><i class="fa-solid fa-clock-rotate-left"></i>My Trips</a>
        </div>
        <div class="button-container">
            <div class="account-button"><i class="fa-solid fa-user"></i> <?php echo $_SESSION['First_Name'] ?> <i class="fa-solid fa-caret-down"></i></div>
            <div class="dropdown-content">
                <a href="manage.html"><i class="fa-solid fa-gear"></i> Manage Account</a>
                <a href="support.html"><i class="fa-solid fa-headset"></i> Support</a>
                <a href="#"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
            </div>
        </div>
    </div>
</header>  

    <div class="container-s">
        <div class="content">
          <div class="left-side">
            <div class="address details">
              <i class="fas fa-map-marker-alt"></i>
              <div class="topic">Address</div>
              <div class="text-one">MIT-World Peace University, Pune</div>
              <div class="text-two">Maharashtra, India</div>
            </div>
            <div class="phone details">
              <i class="fas fa-phone-alt"></i>
              <div class="topic">Phone</div>
              <div class="text-one">+91 9518729218 </div>
              <div class="text-two">+91 8990859900</div>
            </div>
            <div class="email details">
              <i class="fas fa-envelope"></i>
              <div class="topic">Email</div>
              <div class="text-one">SkyHire@gmail.com</div>
              <div class="text-two">info.SkyHire@gmail.com</div>
            </div>
          </div>
          <div class="right-side">
            <div class="topic-text">Send us a message</div>
            <p>If you have any issues from us or any types of quries related to our website, you can contact us from here. It will be our pleasure to help you.</p>
          <form action="#">
            <div class="input-box">
              <input type="text" placeholder="Enter your name">
            </div>
            <div class="input-box">
              <input type="text" placeholder="Enter your email">
            </div>
            <div class="input-box message-box">
                <input type="text" placeholder="Enter Your Text">
            </div>
            <div class="button">
              <input type="button" value="Send Now" >
            </div>
          </form>
        </div>
        </div>
      </div>
    </div><br>
    <br>
</body>
</html>