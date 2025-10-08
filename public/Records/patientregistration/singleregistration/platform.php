<?php
include "controller.php";

switch($views){
    case 'add':
        include "views/add.php";
    break;

    case 'requestservice':
        include "views/requestservice.php";
    break;

    case 'upload':
        include "views/upload.php";
    break;

    case 'groupregistrationlist':
        include "views/groupregistrationlist.php";
//        include "groupregisteration/platform.php";
    break;

    case 'groupregistrationadd':
        include "views/groupregistrationadd.php";
//        include "groupregisteration/platform.php";
    break;

    case 'viewgroup':
        include "views/viewgroup.php";
    break;

	default:
		include "views/list.php";
	break;
    }
?>