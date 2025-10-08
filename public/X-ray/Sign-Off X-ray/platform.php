<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */
include ("controller.php");

switch ($view){
	case "add":
	  	include("views/add.php");
	break;
	case "scanview":
	    include("views/viewscan.php");
	break;
    default:
        include ("views/list.php");
    break;
}