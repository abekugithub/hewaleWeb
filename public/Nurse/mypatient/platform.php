<?php
include("controller.php");
    switch($view){
      case 'patientdetails':
          include 'views/patientdetails.php';
      break;
	  
	  case 'viewmedicals':
          include 'views/viewmedicals.php';
      break;
	  
	  case "excuseduty":
	      include 'views/excuseduty.php';
	  break;
	  
	  case "summmaryduty":
	     include 'views/summaryexcuse.php';
	  break;
	  
      default:
	  include("views/list.php");
	  break;
    }
?>