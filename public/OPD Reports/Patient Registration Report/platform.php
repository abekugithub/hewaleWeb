<?php
	include("controller.php");
	
    switch($view){
		
	case "report":
	  //include("views/report.php");
	  include("public/Reports/template/report.php");
	break;
		
	default:
		include("views/filter.php");
	break;
    }
?>