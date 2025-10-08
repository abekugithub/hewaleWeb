<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */
include ("controller.php");

switch ($view){

    case ("requestdetails"):
        include("views/requestdetails.php");
    break;

	case "results":
	  	include("views/results.php");
    break;
    
	default:
        include ("views/list.php");
    break;

}