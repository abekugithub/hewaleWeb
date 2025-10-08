<?php
include("controller.php");
    switch($view){

        case 'admdetails':
            include("views/admdetails.php");
        break;

        default:
            include("views/list.php");
        break;
    }
?>