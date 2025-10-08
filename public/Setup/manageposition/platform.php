<?php
include("controller.php");
    switch($view){
	  case "addposition":
	  include("views/addposition.php");
	  break;
      default:
	  include("views/list.php");
	  break;
    }
?>