<?php
include 'controller.php';
    switch($views){
        case 'medicalhistory':
            include "views/medicalhistory.php";
        break;
        default:
            include "views/list.php";
        break;
    }
?>