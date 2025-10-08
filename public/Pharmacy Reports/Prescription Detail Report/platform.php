<?php
	include("controller.php");
	
    switch($view){
		
	case "report":
	  //include("views/report.php");
	 // include("public/Reports/template/report.php");
	break;
		
	default:
		//echo "";die();
		include("views/filter.php");
	break;
    }
?>