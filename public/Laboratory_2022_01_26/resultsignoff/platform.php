<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */
include ("controller.php");

switch ($view){

	case md5("takespecimen"):
        include ("views/specimen.php");
    break;
	case "edit":
	  	include("views/edit.php");
	break;
	
	case "add":
	  	include("views/add.php");
	break;   

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