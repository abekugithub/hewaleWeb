<?php
include("controller.php");
    switch($view){
      case "passwordsuccess":
      include("views/passwordsuccess.php");
      break;
      default:
	  include("views/password.php");
	  break;
    }
?>