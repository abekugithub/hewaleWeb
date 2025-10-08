<?php
include("controller.php");
    switch($view){
      
	  case "add":
	  	include("views/editstock.php");
	  break;
			
	  case "edit":
	  include("views/editstock.php");
	  break;
	
	  default:
		include("views/list.php");
	  break;
    }
?>