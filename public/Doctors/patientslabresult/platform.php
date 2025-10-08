

<?php
include("controller.php");
    switch($view){
      case "newpdf":
      include("views/pdf.php");	
      break;	
      case "details":
      include("views/labdetails.php");
      break;		
      default:
	  include("views/list.php");
	  break;
    }
?>