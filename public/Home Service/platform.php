<?php

switch($option){
  case md5("Home Service"):
      include ("Home Service/platform.php");
  break;
	  
  case md5("Home Service Results"):
    include ("Home Service Results/platform.php");
  break;

}

?>