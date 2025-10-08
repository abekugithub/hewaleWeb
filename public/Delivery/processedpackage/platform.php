<?php
include("controller.php");
    switch($view){
		
		
	  	case "process":
	  	include("views/process.php");
          break;
          
        case "details":
	  	include("views/details.php");
	  	break;
		
		
        default:
		
            include("views/list.php");
        break;
    }
?>