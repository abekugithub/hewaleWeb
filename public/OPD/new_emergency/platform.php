<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/18/2017
 * Time: 4:36 PM
 */
include "controller.php";

switch ($views){
    case "add":
        include 'views/add.php';
    break;
    case "add_janedoe":
    	include 'views/add_janedoe.php';
    break;	
    default:
        include 'views/list.php';
    break;
}