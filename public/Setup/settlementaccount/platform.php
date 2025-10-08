<?php
/**
 * Created by PhpStorm.
 * User: adusei
 * Date: 11/15/2018
 * Time: 12:09 PM
 */

include("controller.php");
    switch($view){
    	case 'add':
    		include("views/add.php");
    		break;
    		case 'edit':
    		// echo "mmm";
    		// echo $accname;
    		include("views/edit.php");
    		break;
        default:
            include("views/list.php");
        break;
    }
?>