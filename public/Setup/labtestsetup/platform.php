<?php
include("controller.php");
    switch($view){
	  case "add":
	  include("views/add.php");
	  break;
	  case "upload":
	  include("views/upload.php");
	  break;
      default:
	  include("views/list.php");
	  break;
    }
?>