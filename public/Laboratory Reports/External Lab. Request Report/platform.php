<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 12/5/2017
 * Time: 12:57 PM
 */
include "controller.php";

switch ($view) {
    case "report":
        include "public/Reports/template/report.php";
//        include "view/report.php";
    break;

    default:
        include "view/filter.php";
    break;
}