<?php
include("controller.php");
    switch($view){
		case 'treatment':
	    include("views/sheetlist.php");
		break;
        default:
            include("views/list.php");
        break;
    }
?>