<?php
include "controller.php";

switch ($views){
    
	case "details":
        include 'views/details.php';
    break;

    default:
        include 'views/list.php';
    break;
	
}

?>