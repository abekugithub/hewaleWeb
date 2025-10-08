<?php

include ("controller.php");

switch ($view){
	
    case ("labdetails"):
        include ("views/labtests.php");
    break;
    
    case ("results"):
        include ("views/results.php");
    break;
    
	default:
        include ("views/list.php");
    break;
    
}