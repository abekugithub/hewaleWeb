<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Patient Geolocation</title>
</head>

<body>
<div class="page form">
        <div class="moduletitle" style="margin-bottom:0px;">
          
          <div class="moduletitleupper">Delivery for:
            <?php echo $patient;?>
            <span class="pull-right">
            <div class="form-group">
              <div class="col-sm-12 clientself-video" >
			 
              <button type="button" class="btn btn-danger" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
            </span>
          </div>
          </div>
        </div>
<div  style="height:800px; width:1080px;">
<div id="simple-map" style="width:100%; height:100%;"></div>
</div> 

</body>
<script>
var map ,directionsService,directionsDisplay ;
 
function initMap(){
	/* var latlngStr = ress.split(",", 2);
     var lat = parseFloat(latlngStr[0]);
     var lng = parseFloat(latlngStr[1]);
 */
 
	 map= new google.maps.Map(document.getElementById('simple-map'), {
            zoom:16,
            center:  {lat: 5.62699, lng: -0.2369671 }
        });
		 
		directionsService = new google.maps.DirectionsService();
       directionsDisplay = new google.maps.DirectionsRenderer();
	   calcRoute(<?php echo $end ; ?>);
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
      console.log('coords',latlngStr);
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
  }
  }
</script>

<script  defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkUPrlYzDX4m4hZ34djEgdGbFO918Yd8U&callback=initMap">
</script>
</html>