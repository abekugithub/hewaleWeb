<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Patient Geolocation</title>
</head>

<body onLoad="calcRoute(<?php echo $end ; ?>);">
<div  style="height:800px; width:1080px;">
<div id="simple-map" style="width:100%; height:100%;"></div>
</div>


</body>
<script>
var map,directionsService,directionsDisplay;
 
function initMap(){
	/* var latlngStr = ress.split(",", 2);
     var lat = parseFloat(latlngStr[0]);
     var lng = parseFloat(latlngStr[1]);
 */
	 map= new google.maps.Map(document.getElementById('simple-map'), {
            zoom:8,
            center:  {lat: 5.6666, lng: -0.266271 }
        });
		directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
}
function calcRoute(end) {
      var latlngStr = end.split(",", 2);
var lat = parseFloat(latlngStr[0]);
var lng = parseFloat(latlngStr[1]);
var end = new google.maps.LatLng(lat,lng);
      var latlngStr ;
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(res){
            latlngStr=[res.coords.latitude, res.coords.longitude];
			direct();
        });
        } else{
            latlngStr= map.getCenter().toString().replace(')','').replace('(','') .split(",", 2);
			direct();
        }
      console.log(latlngStr);
	  function direct(){
var lat = parseFloat(latlngStr[0]);
var lng = parseFloat(latlngStr[1]);
//new google.maps.LatLng(5.728795, -0.246825);
var start = new google.maps.LatLng(lat, lng);
    var request = {
      destination: end,
      origin:start,
      travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);

        directionsDisplay.setMap(map);
      } else {
        alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
      }
    });
  }}
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXYPVmTRhsKm8p13ekXfQ1kMPOuwzwl5s&callback=initMap">
</script>
</html>