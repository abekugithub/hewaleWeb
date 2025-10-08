<?php

include ("controller.php");

switch ($view){
	
    case ("labdetails"):
        include ("views/labtests.php");
    break;
    
    case ("maps"):
        include ("views/maps.php");
    break;
    
	default:
        include ("views/list.php");
    break;
    
}