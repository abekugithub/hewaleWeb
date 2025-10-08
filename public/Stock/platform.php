<?php
    switch($option){
      case md5("Manage Prices"):
	  include("manageprices/platform.php");
	  break;
      case md5("Suppliers"):
	  include("suppliers/platform.php");
	  break;
	  case md5("Stock Management"):
	  include("stockmgnt/platform.php");
	  break;
	  case md5("Stock Level"):
	  include("stocklevel/platform.php");
	  break;
	  case md5("Stock Setup"):
	  include("stocksetup/platform.php");
	  break;
	  case md5("Manage Supplies"):
	  include("supplies/platform.php");
	  break;
    }
?>