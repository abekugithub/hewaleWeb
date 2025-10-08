<?php
include("controller.php");
    switch($view){
      
	  case "add":
	  	include("views/addstock.php");
	  break;
      
      case "upload":
	  	include("views/uploadstock.php");
	  break;
	  case "edit":
        include("views/editstock.php");
	  break;
	
	  default:
		include("views/list.php");
	  break;
    }
?>