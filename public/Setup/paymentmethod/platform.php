<?php
include("controller.php");
    switch($view){
        case 'paymentscheme':
            include("views/add.php");
        break;
		default:
            include("views/list.php");
        break;
    }
?>