<?php
include("controller.php");
    switch($view){

        case 'callroom':				
		 include("views/callroom.php");
        break;

        case 'chatroom':
        include 'views/chatview.php';
        break;
		
		case 'history':
            include("views/history.php");
        break;
		
        default:
           include("views/list.php");
        break;
    }
?>