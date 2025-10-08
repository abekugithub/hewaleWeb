<?php
include("controller.php");
    switch($view){
 	  case 'chat':
      include 'view/chat.php';
      break;	
 	  case 'upload':
 	  include 'view/upload.php';
 	  break;	
      default:
	  include("view/list.php");
	  break;
    }
?>