<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/20/2017
 * Time: 2:41 AM
 */

switch ($v){
    case "group":
        include "groupregisteration/platform.php";
    break;

    case "add":
        include "groupregisteration/views/add.php";
    break;

    default:
        include "singleregistration/platform.php";
    break;
}