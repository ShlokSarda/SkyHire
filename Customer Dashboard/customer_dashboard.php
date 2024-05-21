<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/670b3a3b0d.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="./customer_dashboard.css">
    <title>SkyHire-Customer Dashboard</title>
    <style>
        /* Modal */
        .modal{
            display: none;
            justify-content: center;
            align-items: center;
            position: fixed;
            z-index:99;
            left:0;
            top:0;
            width:100%;
            height:100%;
            overflow:none;
        }

        .modal-content{
            background-color: #fefefe;
            align-items: center;
            border:1px solid #888;
            border-radius: 20px;
            width: 50%;
            padding: 20px;
            height:50%;
        }

        .close1{
            color: #000;
            float: right;
            font-size: 40px;
            font-weight: 600;
        }

        .close1:hover,
        .close1:focus {
            color: #aaaaaa;
            text-decoration: none;
            cursor: pointer;
        }

        .content{
            margin-top: 15vh;
        }

        .content-1 .fa-regular {
            display: flex;
            justify-content: center;
            font-size: 50px;
            margin-bottom: 30px;
        }
        .content-1 h2{
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            
        }
    </style>
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
            <div class="account-button" id="account-button"><i class="fa-solid fa-user"></i><?php echo $_SESSION['First_Name'] ?><i class="fa-solid fa-caret-down" style="padding-left: 5px;"></i></div>
            <div class="dropdown-content">
                <a href="./manage.php"><i class="fa-solid fa-gear"></i> Manage Account</a>
                <a href="./support.php"><i class="fa-solid fa-headset"></i> Support</a>
                <a href="#"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
            </div>
        </div>
    </div>
</header>  

  <div class="home-section" id="booknow">
    <div class="text">
        <div class="new" style="border-color: #11101d;">
            <h2>Get A Drone</h2>
            <div class="subcont1 search-container">
            <div class="label">
                <label>Enter your Location</label>
            </div>
            <div class="input" id="input-container">
              <input type="list" id="pickup" class="pickup" name="pickup" placeholder="Enter your Location">
              
            </div>
          
              
            </div>
            <div class="label">
                <label>Purpose of Drone</label>
            </div>
            <div class="input">
                <input list="drones" name="drone" required="" id="drone" placeholder="Select the purpose of your drone">
                <datalist id="drones" name="drone">
                    <option value="Agriculture"></option>
                    <option value="Cinematography"></option>
                    <option value="Surveying"></option>
                    <option value="Inspection"></option>
                </datalist>
            </div>
            <div class="label">
              <label>Schedule to</label>
          </div>
          <div class="input">
              <input type="date" id="date" name="date">
          </div>
          <div class="label">
            <label>Time</label>
          </div>
          <div class="input">
            <input type="time" id="time" name="time">
          </div>
          <div class="label">
              <label>Number of Hours</label>
              <span class="light-text">(hrs)</span>
          </div>
          <div class="input">
              <input type="number" id="hours" name="hours" min="1" max="13" placeholder="Select Number of Hours">
          </div>
          <div class="label">
            <label>Do You Need A Pilot?</label><br>
            <div id="pilot">
            <input type="radio" id="with_pilot" name="pilot" value="yes">
            <label for="with_pilot" >Yes</label>
            <input type="radio" id="without_pilot" name="pilot" value="no">
            <label for="without_pilot" >No </label>
            <br>
          </div>
            </div>
          <button class="search" onclick="book_now()">Book Now</button>
          <div id="myModal1" class="modal">
            <div class="modal-content">
                <i class="close1 fa-solid fa-circle-xmark"></i>
                <div class="content">
                    <div class="content-1">
                        <i class="fa-regular fa-hourglass-half"></i>
                        <h2>Booking Initiated</h2>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
  </div>
  <div id='map'></div>
<script>
/* ---------- MAP ----------*/
mapboxgl.accessToken = 'pk.eyJ1Ijoic2hsb2sxNTA0MjAwNCIsImEiOiJjbHA5cnVkcmwwMDR3Mmt2dXpoMXZmNmhwIn0.4s2uVCLEtjym0aTdhart7w';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [73.8567,18.5204], // Default location (Longitude, Latitude)
            zoom: 15
        });
        var geolocateControl = new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            // When active the map will receive updates to the device's location as it changes.
            trackUserLocation: true,
            // Draw an arrow next to the location dot to indicate which direction the device is heading.
            showUserHeading: true
        });
        const nav = new mapboxgl.NavigationControl();
        map.addControl(nav, 'bottom-right');
        

        document.addEventListener('DOMContentLoaded', function () {
            // Trigger click event on geolocate control button
            document.querySelector('.mapboxgl-ctrl-geolocate').click();
            
            // Rest of your code...
            // navigator.geolocation.getCurrentPosition(...)
        });
        map.addControl(geolocateControl);
        var searchInput = document.getElementById('pickup');
        var autocompleteResults = document.getElementById('autocomplete-results');
        var marker;
  
        searchInput.addEventListener('input', function () {
            var query = searchInput.value;
  
            // Clear previous results
            autocompleteResults.innerHTML = '';
  
            // Use the Mapbox Geocoding API to fetch autocomplete suggestions
            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${query}.json?access_token=${mapboxgl.accessToken}`)
                .then(response => response.json())
                .then(data => {
                    if (data.features) {
                        data.features.forEach(feature => {
                            var li = document.createElement('li');
                            li.textContent = feature.place_name;
                            li.addEventListener('click', function () {
                                var coordinates = feature.geometry.coordinates;
                                if (marker) {
                                      marker.remove();
                                }

                                searchInput.value = feature.place_name;
                                // Create a marker and add it to the map
                                marker = new mapboxgl.Marker({ color: 'red' })
                                    .setLngLat(coordinates)
                                    .addTo(map);
  
                                // Update map location based on the selected result
                                map.flyTo({ center: coordinates, zoom: 15 });
  
                                // Clear the autocomplete results
                                autocompleteResults.innerHTML = '';
                            });
  
                            autocompleteResults.appendChild(li);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });
  
        // Close autocomplete results when clicking outside the search container
        document.addEventListener('click', function (event) {
            if (!event.target.closest('#search-container')) {
                autocompleteResults.innerHTML = '';
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
      navigator.geolocation.getCurrentPosition(
          function (position) {
              var userLocation = [position.coords.longitude, position.coords.latitude];
  
              // Reverse geocoding to get the human-readable address
              fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${userLocation[0]},${userLocation[1]}.json?access_token=${mapboxgl.accessToken}`)
                  .then(response => response.json())
                  .then(data => {
                      if (data.features && data.features.length > 0) {
                          var address = data.features[0].place_name;
                          searchInput.value = address;
                      } else {
                          console.error('Unable to retrieve address information.');
                      }
                  })
                  .catch(error => {
                      console.error('Error fetching address data:', error);
                  });
  
              // Add a marker to the map for the user's current location
              map.setCenter(userLocation);
          },
          function (error) {
              console.error('Error getting user location:', error);
          },
          { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
      );
  });
 
/*booking*/
// Increment and decrement the number of hours
document.getElementById('hours').addEventListener('change', function() {
    const hours = parseInt(this.value);
    if (hours < 1) {
        this.value = 1;
    }
});

// Get the selected pilot option
function getPilotOption() {
    const withPilot = document.getElementById('with_pilot').checked;
    return withPilot ? 'With Pilot' : 'Without Pilot';
}

// Function to book now
function book_now() {
    var modal1=document.getElementById("myModal1");
    var span1=document.getElementsByClassName("close1")[0];
    var body=document.body;
    modal1.style.display="flex";
    body.style.overflow="hidden";
    span1.onclick=function(){
        modal1.style.display="none";
        body.style.overflow="auto";
    }
    const location = document.getElementById('pickup').value;
    const purpose = document.getElementById('drone').value;
    const date = document.getElementById('date').value;
    const hours = document.getElementById('hours').value;
    const pilot = document.getElementById("pilot").querySelector('input[name="pilot"]:checked').value;
    const time = document.getElementById('time').value;

   const data={
    location: location,
    purpose: purpose,
    date: date,
    hours: hours,
    pilot: pilot,
    time:time,
    mobile:'<?php $_SESSION['Mobile_Number'] ?>',
    name:'<?php $_SESSION['First_Name'] ?>'
   };

   fetch("./customer_dashboard(1).php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Log response from PHP script
        // You can perform further actions here based on the response
    })
    .catch(error => {
        console.error("Error:", error);
    });
}

  
  
  /* ---------- Date Restrict ----------*/
  function getCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }
  document.getElementById('date').min = getCurrentDate();
</script>  
</body>
</html>
