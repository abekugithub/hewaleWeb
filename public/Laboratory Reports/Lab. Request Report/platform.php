<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/27/2017
 * Time: 4:34 PM
 */
include "controller.php";

switch ($view){
    case "report":
        include "public/Reports/template/report.php";
//        include "view/report.php";
    break;

    default:
        include "view/filter.php";
    break;
}