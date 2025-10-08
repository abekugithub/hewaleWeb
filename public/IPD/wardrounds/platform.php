<?php
include("controller.php");
    switch($view){
		case 'wardlist':
	    include("views/wardlist.php");
		break;
		case 'history':
        include("views/historylist.php");
        break;
		case 'historydetails' :
        include("views/historydetails.php");
        break;
        default:
            include("views/list.php");
        break;
    }
?>