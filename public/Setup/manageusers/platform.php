<?php
include("controller.php");
    switch($view){
	  case "adduser":
	  include("views/adduser.php");
	  break;
	  case "edituser":
	  include("views/edituser.php");
	  break;
	  case "resetpwd":
	  include("views/resetpwd.php");
	  break;
      default:
	  include("views/list.php");
	  break;
    }
?>