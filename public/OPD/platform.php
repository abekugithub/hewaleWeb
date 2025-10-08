<?php
    switch($option){
        case md5("Vitals"):
	        include("vitals/platform.php");
	    break;
        case md5("Emergency"):
        	include("emergency/platform.php");
        break;
        case md5("First Aid"):
	        include("firstaid/platform.php");
	    break;
	    case md5("New Emergency"):
        	include("new_emergency/platform.php");
        break;
    }
?>