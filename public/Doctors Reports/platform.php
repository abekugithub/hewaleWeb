<?php
switch ($option){

    case md5("Patient Report"):
        include ("Patient Report/platform.php");
        break;

        case md5("Service Request"):
        include ("Servicerequest Report/platform.php");
        break;

    case md5("Transaction Report"):
        include ("Transaction Report/platform.php");
        break;

        case md5("Consultation Report"):
        include ("consultation_report/platform.php");
        break;

    case md5("Template"):
        include("template/report.php");
        break;
}
?>