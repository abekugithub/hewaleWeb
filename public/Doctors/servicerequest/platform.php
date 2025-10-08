<?php
include("controller.php");
    switch($view){
		
		case "patientdetails":
		include ('views/history.php');
		break;
		
		case 'viewmedicals':
          include 'views/viewmedicals.php';
      break;
		
      default:
	  include("views/list.php");
	  break;
    }
?>