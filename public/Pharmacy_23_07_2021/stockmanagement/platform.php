<?php
include("controller.php");
    switch($view){
      default:
	  include("views/list.php");
	  break;
    }
?>