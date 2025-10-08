<?php
    switch($option){
      case md5("Dispensary"):
	  include("dispensary/platform.php");
	  break;
      case md5("Prescriptions"):
	  include("prescriptions/platform.php");
	  break;
	  case md5("Pending Prescription"):
	  include("pending/platform.php");
	  break;
	  case md5("Sales"):
	  include("sales/platform.php");
	  break;
      case md5("Stock Management"):
	  include("stockmanagement/platform.php");
	  break;
	  case md5("Manage Collection"):
	  include("collection/platform.php");
	  break;
	  case md5("Vitals"):
	  include("public/OPD/vitals/platform.php");
	  break;
	  case md5("Monitor Prescription"):
	      include("pendingdispensary/platform.php");
	  break;
	  case md5("Transaction History"):
	  include("transhistory/platform.php");
      break;

    }
?>