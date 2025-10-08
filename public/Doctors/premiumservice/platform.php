<?php
include("controller.php");
    switch($view){
	  case "maplocation":
	  include("views/displaymap.php");
	  break;
	  case "patientdetails":
	  include("views/patientdetails.php");
	  break;
      default:
	  include("views/list.php");
	  break;
    }
?>