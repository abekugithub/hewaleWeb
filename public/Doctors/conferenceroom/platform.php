<?php
include("controller.php");
    switch($view){
	  case "conferenceview":
	       include 'views/conferenceroom.php';
	  break;

	  case "setupconference":
	     include 'views/addconference.php';
	  break;

	  case "savenext":
	     include 'views/addconference2.php';
	  break;


	  case "editcon":
	  include 'views/edit.php';
   break;

	  case "excuseduty":
	  include 'views/excuseduty.php';
   break;
	  
      default:
	  include("views/list.php");
	  break;
    }
?>