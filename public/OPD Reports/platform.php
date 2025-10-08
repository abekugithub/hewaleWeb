<?php
    switch($option){
	case md5("Patient Registration Report"):
	  include("Patient Registration Report/platform.php");
	break;
	
	case md5("Requested Service Report"):
	  include("Requested Service Report/platform.php");
	break;
	
	case md5("Vitals Report"):
	  include("Vitals Report/platform.php");
	break;
	
	case md5("First Aid Report"):
	  include("First Aid Report/platform.php");
	break;
	
	case md5("Consultation Report"):
	  include("Consultation Report/platform.php");
	break;
	
	case md5("Template"):
	  include("template/report.php");
	break;
    }
?>