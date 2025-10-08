<?php
include("controller.php");
    switch($view){
      case 'receipt':
    	  include ("views/preview.php");
      break;			
      default:
		  include("views/list.php");
	  break;
    }
?>