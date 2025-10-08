<?php
    switch($option){

     

      case md5("Sign-Off X-Ray"):
      
            include("xrayresultsignoff/platform.php");

      break;

      case md5("X-Ray Request"):

            include("xrayrequest/platform.php");

      break;

      case md5("Ultrasound Results"):
      
        include("ultrasoundresult/platform.php");

      break;

      case md5("Ultrasound Requests"):

            include("ultrasoundsrequest/platform.php");

      break;

      case md5("Sign off Ultrasound"):

            include("ultrasoundresultsignoff/platform.php");

      break;
    }
?>


