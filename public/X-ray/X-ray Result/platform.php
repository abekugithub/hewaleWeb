<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */
include ("controller.php");

switch ($view){
	case "uploadresult":
	  	include("views/uploadresults.php");
	break;
	
    default:
        include ("views/list.php");
    break;
}