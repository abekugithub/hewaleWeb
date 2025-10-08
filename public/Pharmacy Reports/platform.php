<?php
    switch($option){
	case md5("Prescription Report"):
	  include("Prescription Report/platform.php");
	break;
	
	case md5("Prescription Detail Report"):
	  include("Prescription Detail Report/platform.php");
	break;
	
	case md5("Processed Report"):
	  include("Processed Report/platform.php");
	break;
	
	case md5("Pending Report"):
	  include("Pending Report/platform.php");
	break;
	
	case md5("Dispensary Report"):
	  include("Dispension Report/platform.php");
	break;
	
	case md5("Stock Level Report"):
	  include("Stock Level Report/platform.php");
	break;
	
	case md5("Restock Report"):
	  include("Restock Report/platform.php");
	break;
	
	case md5("Supplies  Report"):
	  include("Supplies Report/platform.php");
	break;
	
	case md5("Supplies Detail Report"):
	  include("Supplies Detail Report/platform.php");
	break;
	
	case md5("Exception Report"):
	  include("Exception Report/platform.php");
	break;
	
	case md5("Template"):
	  include("template/report.php");
	break;
	case md5("Sales Report"):
	  include("Sales Report/platform.php");
	break;
	case md5("Cash Flow Report"):
	include("cashflowreport/platform.php");
break;
    }

?>