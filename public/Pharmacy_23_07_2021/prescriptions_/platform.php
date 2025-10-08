<?php
include("controller.php");
    switch($view){
      
	  case md5("process"):
	  	include ("views/processprescription.php");
	  break;
	  
	  case "add":
	  	include("views/add.php");
	  break;
	
	  default:
		include("views/list.php");
	  break;
    }
?>