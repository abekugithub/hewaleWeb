<!DOCTYPE html>
<html>
  <head>
    <title>Lat/Lng Object Literal</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        min-height: 100%;
        height: 100vh;
        /* border: thin solid red; */
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    
    <script>
      let map;

      function initMap() {
        const mapOptions = {
          zoom: 15,
          // center: { lat: -34.397, lng: 150.644 },
          center: new google.maps.LatLng(<?php echo $ploc;?>),
        };
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        const marker = new google.maps.Marker({
          
          // position: { lat: -34.397, lng: 150.644 },
          position: new google.maps.LatLng(<?php echo $ploc;?>),
          map: map,
        });
        
        const infowindow = new google.maps.InfoWindow({
          content: "<p>Marker Location:" + marker.getPosition() + "</p>",
        });
        google.maps.event.addListener(marker, "click", () => {
          infowindow.open(map, marker);
        });
      }
    </script>
  </head>
  <body>
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkUPrlYzDX4m4hZ34djEgdGbFO918Yd8U&callback=initMap"></script>
  </body>
</html>
