<?php
include("controller.php");
    switch($view){
      case md5("process"):
	  
		include ("views/processprescription.php");
	  
	  break;
	  
	  case 'prescdetails':
            include("views/presclist.php");
        break;
	  case 'sales':
	  		include("views/sales.php");
	  break;
	   case 'salesimage':
	  		include("views/salesimage.php");
	  break;
	  case 'receipt':
	  		include("views/preview.php");
	  break;
	  case 'prepareimage':
			include("views/prepareimage.php");
	  break;
	  default:
		    include("views/list.php");
	  break;
    }
?>