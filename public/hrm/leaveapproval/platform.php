<?php
include("controller.php");
    switch($view){
		
		
		
	  	case "edit":
	  	include("views/view.php");
	  	break;
		
		
        default:
		
            include("views/list.php");
        break;
    }
?>