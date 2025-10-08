<?php
include("controller.php");
    switch($view){
        case 'firstaid':
            include("views/add.php");
        break;
		
		
        default:
            include("views/list.php");
        break;
    }
?>