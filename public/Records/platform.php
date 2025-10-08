<?php
    switch($option){
    	case md5("Service Request"):
	  include("servicerequest/platform.php");
	  break;
		case md5("Patient Registration"):
	  include("patientregistration/platform.php");
	  break;

    }
?>