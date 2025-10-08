<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 5/1/2018
 * Time: 5:30 PM
 */
include "controller.php";

switch ($view){
    default:
        include 'view/list.php';
    break;
}