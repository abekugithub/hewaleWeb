<?php
include("controller.php");
    switch($view){

        case 'prescdetails':
            include("views/presclist.php");
        break;

        default:
            include("views/list.php");
        break;
    }
?>