<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://kit.fontawesome.com/670b3a3b0d.js" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
<link rel="stylesheet" href="./manage.css">
<title>Manage Account</title>
</head>
<body>

<header>
    <div class="topnav">
        <h2>SkyHire Account</h2>
    </div>
<header>

<div class="sidenav">
    <a href="#" onclick="showSection('account')">Account Information</a>
    <a href="#" onclick="showSection('history')">Payment History </a>
    <a href="#" onclick="showSection('legal')">Legal and Compliance</a>
    <a href="#" onclick="showSection('delete')">Delete Account</a>
</div>

<div class="content">
    <div id="account" class="section"><br><br><br>
        <h2>Basic Information</h2> 
        <img src="../assets/images/user (2).png" width="150" height="150">
        <h3>Account Name:</h3>
        <div class="trial2" style="display: flex; justify-content: space-between; width: 48%;">
        <div class="trial"><span id="accountName"><?php echo $_SESSION['First_Name']?></span></div>
        <div class="trial"><i class="fa-solid fa-arrow-right fa-xl" onclick="editAccount('accountName')"></i></div></div>
        <hr style="width:50%;text-align:left;margin-left:0;color: #ddd;">
        <h3>Phone Number: </h3>
        <div class="trial2" style="display: flex; justify-content: space-between; width: 47.2%;">
        <div class="trial"><span id="phoneNumber"><?php echo $_SESSION['Mobile_Number']?></span> </div>
        <div class="trial"><i class="fa-solid fa-arrow-right fa-xl" onclick="editAccount('phoneNumber')" style="margin-left: 37.8%;"></i></div></div>
        <hr style="width:50%;text-align:left;margin-left:0">
        <form class="edit-form" id="editForm">
            <input type="text" id="newInfo" style="font-family: Montserrat, sans-serif; padding: 10px 20px; border-radius: 5px; border: 1px solid #ccc;">

            <button type="submit"><i class="fa-regular fa-floppy-disk"></i> Save</button>
            <button type="button" onclick="cancelEdit()"><i class="fa-solid fa-xmark"></i> Cancel</button>
        </form>
        <div class="overlay" id="editOverlay" onclick="cancelEdit()"></div>
    </div>

    <div id="history" class="section"><br><br><br>
        <h2> Payment History</h2>
    </div>

    <div id="legal" class="section">
        <br><br><br><h2>Terms and Conditions</h2>
        <p><b>1. Introduction</b><br>
            1.1 These terms and conditions ("Terms") govern your use of our drone rental services provided by SkyHire.<br>
            
            1.2 By accessing or using our Website, you agree to be bound by these Terms. If you disagree with any part of these Terms, you may not access the Website or use our services.<br><br>
            
            <b>2. Definitions</b><br>
            
            2.1 "Consumer" refers to any individual or entity using our drone rental services for personal use.<br>
            
            2.2 "Host" refers to individuals or entities providing drone rental services through our platform.<br>
            
            2.3 "Pilot" refers to a certified and licensed individual responsible for operating the drone during the rental period.<br><br>
            
            <b>3. Rental Services</b><br>
            
            3.1 Our Website facilitates the rental of drones for personal use at an hourly rate.<br>
            
            3.2 Consumers have the option to select the type of drone application and whether they require a certified pilot for operation.<br>
            
            3.3 Hosts guarantee that the pilot provided is certified and licensed, ensuring safe and compliant operation of the drone.<br>
            
            3.4 The drones provided by hosts are thoroughly inspected and maintained to ensure they are secure and free from any unauthorized surveillance equipment, including spycams.<br><br>
            
            <b>4. Consumer Responsibilities</b><br>
            
            4.1 Consumers are responsible for the proper use and care of the rented drone during the rental period.<br>
            
            4.2 Any damages caused to the drone during the rental period due to consumer negligence or misuse must be reported to the Company immediately.<br>
            
            4.3 Consumers are liable for any damages caused to the drone during the rental period and agree to reimburse the Company or the host for repair or replacement costs.<br><br>
            
            <b>5. Privacy and Data Protection</b><br>
            
            5.1 We are committed to protecting consumer privacy. We do not store any personal information on the drone after its use.<br>
            
            5.2 Any data collected during the rental process, including personal information, is handled in accordance with our Privacy Policy, available on our Website.<br><br>
            
            <b>6. Pilot Certification and Licensing</b><br>
            
            6.1 Pilots provided by hosts are required to possess valid certifications and licenses for drone operation as per regulatory requirements.<br>
            
            6.2 Consumers have the right to request proof of pilot certification and licensing before the commencement of the rental period.<br><br>
            
            <b>7. Limitation of Liability</b><br>
            
            7.1 In no event shall the Company be liable for any indirect, incidental, special, consequential, or punitive damages arising out of or in connection with the use of our services.<br>
            
            7.2 The Company's total liability, whether in contract, warranty, tort (including negligence), or otherwise, shall not exceed the total amount paid by the consumer for the rental services.<br><br>
            
            <b>8. Governing Law and Dispute Resolution</b><br>
            
            8.1 These Terms shall be governed by and construed in accordance with the laws of Government of India.<br>
            
            8.2 Any dispute arising out of or in connection with these Terms shall be resolved through arbitration in accordance with the rules of Law.<br><br>
            
            <b>9. Amendments</b><br>
            
            9.1 The Company reserves the right to modify or amend these Terms at any time. Any changes to these Terms will be effective immediately upon posting on the Website.<br>
            
            
            </p>
    </div>

    <div id="delete" class="section"><br><br><br>
        <h2> Delete Account</h2>
        <h3>Do you want to delete your account?</h3>
        <button class="cancel" style="background-color: red;">Delete Account</button>

    </div>
</div>

<script>
   function showSection(sectionId) {
        // Hide all sections
        var sections = document.getElementsByClassName("section");
        for (var i = 0; i < sections.length; i++) {
            sections[i].style.display = "none";
        }

        // Show the selected section
        document.getElementById(sectionId).style.display = "block";
    }

    function editAccount(field) {
        var fieldValue = document.getElementById(field).textContent;
        var editForm = document.getElementById('editForm');
        var newInfo = document.getElementById('newInfo');

        newInfo.value = fieldValue;
        editForm.style.display = 'block';
        editForm.onsubmit = function(event) {
            event.preventDefault();
            document.getElementById(field).textContent = newInfo.value;
            editForm.style.display = 'none';
        };
    }

    function cancelEdit() {
        document.getElementById('editForm').style.display = 'none';
    }

    window.onload = function() {
        showSection('account');
    };
    </script>
</body>
</html>
