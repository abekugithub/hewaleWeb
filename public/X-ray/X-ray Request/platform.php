<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */
include ("controller.php");

switch ($view){
    case ("xraydetails"):
        include("views/x-raydetails.php");
    break;
	case "takespacimen":
	  	include("views/add.php");
	break;
	default:
        include ("views/list.php");
    break;
}