<?php
include("controller.php");
    switch($view){
	  case 'prescdetails':
            include("views/presclist.php");
        break;
	  case 'prepareprescription':
	  		include("views/presclist.php");
	  break;
	  case 'prepareimage':
			include("views/prepareimage.php");
	  break;
    case 'viewpresc':
        include("views/viewpresc.php");
    break;
    case 'viewprepareimage':
        include("views/viewprepareimage.php");
    break;

    case 'pharmahistory':
        include("views/pharmahistory.php");
    break;

    case 'details':
        include("views/detailshistory.php");
    break;

	  default:
		    include("views/list.php");
	  break;
    }
?>