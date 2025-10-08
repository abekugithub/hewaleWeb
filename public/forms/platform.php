<?php
    switch($views){
        case 'report':
            include "views/report.php";
        break;
        default:
            include "views/list.php";
        break;
    }
?>