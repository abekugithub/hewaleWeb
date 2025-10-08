<?php
    switch($option){
	
	case md5("Patient Registration Report"):
	  include("template/report.php");
	break;
	
	case md5("Template"):
	  include("template/report.php");
	break;
	
	default:
		include("template/report.php");
	break;
    }
?>