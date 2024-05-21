
/* ---------- Header ----------*/
const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
const header = document.querySelector("[data-header]");

navToggleBtn.addEventListener("click", function () {
  this.classList.toggle("active");
  header.classList.toggle("active");
});

/* ---------- Date Restrict ----------*/
function getCurrentDate() {
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0');
  const day = String(today.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}
document.getElementById('date').min = getCurrentDate();

/* ---------- MAP ----------*/
mapboxgl.accessToken = 'pk.eyJ1Ijoic2hsb2sxNTA0MjAwNCIsImEiOiJjbHA5cnVkcmwwMDR3Mmt2dXpoMXZmNmhwIn0.4s2uVCLEtjym0aTdhart7w';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [73.8567,18.5204], // Default location (Longitude, Latitude)
            zoom: 15
        });
        var currentLocation=document.getElementsByClassName("current-location")[0];
        var geolocateControl = new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            // When active the map will receive updates to the device's location as it changes.
            trackUserLocation: true,
            // Draw an arrow next to the location dot to indicate which direction the device is heading.
            showUserHeading: true
        });
        currentLocation.addEventListener('click', function () {
            // Trigger click event on geolocate control button
            document.querySelector('.mapboxgl-ctrl-geolocate').click();
            
            // Rest of your code...
            // navigator.geolocation.getCurrentPosition(...)
        });
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
  currentLocation.addEventListener('click', function () {
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
                        if (marker) {
                            marker.remove();
                        }
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

  /*---------- Go to Top ----------*/
  const goTopBtn = document.querySelector("[data-go-top]");

window.addEventListener("scroll", function () {
  window.scrollY >= 500 ? goTopBtn.classList.add("active")
    : goTopBtn.classList.remove("active");
});

/*---------- Modal-1 ----------*/
var modal1=document.getElementById("myModal1");
var btn1=document.getElementById("myBtn1");
var span1=document.getElementsByClassName("close1")[0];
var body=document.body;
btn1.onclick=function(){
    modal1.style.display="block";
    body.style.overflow="hidden";
}
span1.onclick=function(){
    modal1.style.display="none";
    body.style.overflow="auto";
}

/*---------- Modal-2 ----------*/
var modal2=document.getElementById("myModal2");
var btn2=document.getElementById("myBtn2");
var span2=document.getElementsByClassName("close1")[1];
btn2.onclick=function(){
    modal2.style.display="block";
    body.style.overflow="hidden";
}
span2.onclick=function(){
    modal2.style.display="none";
    body.style.overflow="auto";
}