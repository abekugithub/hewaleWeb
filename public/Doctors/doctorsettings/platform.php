<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/11/2017
 * Time: 1:32 PM
 */

include 'controller.php';

switch ($view){
    default:
        include "views/mysettings.php";
    break;
}