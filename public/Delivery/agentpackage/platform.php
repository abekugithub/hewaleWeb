<?php
include("controller.php");
//var_dump ($_REQUEST);die;
    switch($view){
		
		
	  	case "edit":
	  	include("views/edit.php");
          break;
        case "delivery":
	  	include("views/delivery.php");
          break;
          
          case "map":
	  	include("views/map.php");
	  	break;
		
          case "maplocation":
          include("views/displaymap.php");
          break;
		
        default:
            include("views/list.php");
        break;
    }
?>