<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/18/2017
 * Time: 4:36 PM
 */
include "controller.php";

switch ($views){
    case "group":
        include "views/add.php";
    break;

    case "bringhere":
        include 'views/groupregistrationlist.php';
    break;

    default:
        include 'views/groupregistrationlist.php';
    break;
}