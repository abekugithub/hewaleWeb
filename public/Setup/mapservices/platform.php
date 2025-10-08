<?php
include("controller.php");
    switch($view){
	  case "mapservices":
	  include("views/mapservices.php");
	  break;
	  case "mapedit":
	  include("views/mapservicesedit.php");
	  break;
      default:
	  include("views/list.php");
	  break;
    }
?>