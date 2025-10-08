<?php
include("controller.php");
    switch($view){
		
		case "adduser":
	  		include("views/adduser.php");
	  	break;
	  	case "edit":
	  	include("views/edit.php");
	  	break;
		
		case "process":
	  	include("views/process.php");
	  	break;
		
        default:
            include("views/list.php");
        break;
    }
?>