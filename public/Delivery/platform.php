<?php
    switch($option){
      case md5("Pending Delivery"):
	  include("pendingdelivery/platform.php");
	  break;
	  
	  case md5("Delivery History"):
	  include("delivered/platform.php");
	  break;
	  
	  case md5("My Agents"):
	  include("myagents/platform.php");
	  break;
	  
	  case md5("Manage Assets"):
	  include("manageassets/platform.php");
	  break;
	  
	  case md5("Packages"):
	  include("agentpackage/platform.php");
	  break;
	  
	  case md5("Processed Packages"):
	  include("processedpackage/platform.php");
	  break;
	  
	  case md5("Delivery Payment"):
	  include("payments/platform.php");
	  break;
	  
	  case md5("Delivery Report"):
	  include("deliveryreport/platform.php");
	  break;
    }
?>