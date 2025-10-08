<?php
    switch($option){

      case md5("Manage Users"):
		include("public/Setup/manageusers/platform.php");
	  break;
	  
	  case md5("Specimen Register"):
        include ("specimenregister/platform.php");
      break;
	  
      case md5("Specimen Register (Home Service)"):
        include ("specimenregisterhomeservice/platform.php");
      break;
	  
	  case md5("Lab Result"):
        include ("labResult/platform.php");
      break;
	  
      case md5("Lab Request"):
        include ("Lab Request/platform.php");
      break;
	  
	   case md5("Sign off Test"):
        include ("resultsignoff/platform.php");
      break;

      case md5("X-Ray Request"):
        include ("x-rayrequest/platform.php");
      break;

      case md5("Sign-Off X-Ray"):
        include ("x-rayresultsignoff/platform.php");
      break;
	  
	    case md5("My Wallet"):
        include ("wallet/platform.php");
      break;

      case md5("Transaction History"):
        include ("transhistory/platform.php");
      break;
    }
?>


