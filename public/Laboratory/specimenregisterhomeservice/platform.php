<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */
include ("controller.php");

switch ($view){

	
	case "edit":
	  	include("views/edit.php");
	break;
	
	case ("labsample"):
    include ("views/labsample.php");
    break;
	
	case "details":
	  	include("views/specimenlist.php");
	break;
	
	case "add":
	  	include("views/add.php");
	break;

	case "takesample":
	  	include("views/takesample.php");
    break;
	
    default:
        include ("views/list.php");
    break;
}