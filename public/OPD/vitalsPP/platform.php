<?php
include("controller.php");
    switch($view){
        case 'vitals':
            include("views/vitals.php");
        break;
		
		case 'vitalview':
            include("views/vitalview.php");
        break;
		case 'vitalhistory':
            include("views/vitalhistory.php");
        break;
        default:
            include("views/list.php");
        break;
    }
?>