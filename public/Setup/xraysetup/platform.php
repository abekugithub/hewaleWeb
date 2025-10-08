<?php
include("controller.php");

switch($view){
    case "add":
        include("views/add.php");
    break;

    default:
        include("views/list.php");
    break;
}
?>