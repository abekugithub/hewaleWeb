<?php
include("controller.php");

switch($views){
    case 'add':
        include "views/add.php";
    break;

    case 'requestservice':
        include "views/requestservice.php";
    break;
    case 'requestqueue':
    	include "views/requestservicequeue.php";
    break;	
    case 'upload':
        include "views/upload.php";
    break;

	default:
		include "views/list.php";
	break;
    }
?>