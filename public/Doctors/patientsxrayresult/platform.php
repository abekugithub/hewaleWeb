<?php
include("controller.php");
    switch($view){
      case "scanview":
	    include("views/viewscan.php");
	  break;
    case "details":
        include("views/xraydetails.php");
    break;
      default:
	    include("views/list.php");
	  break;
    }
?>