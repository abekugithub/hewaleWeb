<?php
include("controller.php");
    switch($view){
      default:
	  include("view/list.php");
	  break;
    }
?>