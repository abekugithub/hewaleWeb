<?php
include('controller.php');
    switch($views){
		case "addnote":
		   include "views/add_note.html";
		break;
        default:
            if($facitype == 'CC'){
                include "views/dashvirtual.php";
            }else{
            include "views/dash.php";
            }
        break;
    }
?>