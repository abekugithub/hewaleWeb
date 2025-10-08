<?php
include("controller.php");
    switch($view){

        case 'consulting':
		    if($usrtype == 2 || $usrtype == 7){
            include("views/consultation.php");
			}else{
				
				include("views/Hconsultation.php");}
        break;
		
		case 'history':
            include("views/history.php");
        break;
		
		case 'historylist':
            include("views/historylist.php");
        break;
		
		case 'historydetails':
            include("views/historydetails.php");
        break;
		
		case 'vitallist':
            include("views/vitallist.php");
        break;
		
		case 'viewmedicals':
          include 'views/viewmedicals.php';
        break;

        case 'requestreason':
           include 'views/requestreason.php';
        break;

        default:
           include("views/list.php");
        break;
    }
?>