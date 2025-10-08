<?php
include("controller.php");
    switch($view){
		
		case "adduser":
	  		include("views/adduser.php");
	  	break;
	  	
		
        default:
            include("views/list.php");
        break;
    }
?>