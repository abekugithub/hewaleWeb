<?php
include("controller.php");

switch($view){
    case "report":
        include("public/Reports/template/report.php");
    break;

    default:
        include("views/filter.php");
    break;
}
?>