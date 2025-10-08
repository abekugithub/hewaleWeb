<?php
include("controller.php");
    switch($view){
	  case "add":
	  include("views/add.php");
	  break;
	  case "addstocknext":
	  include("views/addstocknext.php");
	  break;
	  case "editstocknext":
	  include("views/editstocknext.php");
	  break;
	  case "addstockfinal":
	  include("views/addstockfinal.php");
	  break;
	  case "editsupply":
	  include("views/editsupply.php");
	  break;
      default:
	  include("views/list.php");
	  break;
    }
?>