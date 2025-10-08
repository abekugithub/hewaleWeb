<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 5/29/2018
 * Time: 2:39 PM
 */

include 'controller.php';

switch($view) {

    case 'history':
        include("views/history.php");
    break;

    default:
        include 'view/list.php';
    break;
}