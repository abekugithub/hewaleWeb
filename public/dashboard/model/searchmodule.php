<?php
ob_start();
include '../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."menufactory.Class.php";

$engine = new engineClass();
$menus = new MenuClass();
$actor = $engine->getActorDetails();

if($dashsearch != ''){
$dashmenu = $menus->getMenuViewAccessRightDashSearch($dashsearch);
}else{
    $dashmenu = $menus->getMenuViewAccessRightDash();
}

//print_r($dashmenu);
if(is_array($dashmenu)){
$output = '<div class="container-fluid">
<div class="row-fluid">';

foreach($dashmenu as $value){
    $linkview = 'index.php?pg='.md5($value[0]).'&amp;option='.md5($value[1]).'&uiid='.md5('1_pop');
    
    $output .= '<div class="col-sm-2 dashcard ctrlnotification" id="ctrlnotification">
        <a href="#" onClick="CallWindow(\''.$linkview.'\')" class="list-group-item">
        
        '.(($value[3] == 1)?(($usertype == 2)?(($engine->getTotalNotification($value[4],1) > 0)?'<span class="badge" >'.$engine->getTotalNotification($value[4],1).'</span>':''):(($engine->getTotalNotification($value[4],2) > 0)?'<span class="badge">'.$engine->getTotalNotification($value[4],2).'</span>':'')):'').'
        <div class="tile-card">
            <img src="media/img/icons/'.$value[2].'" alt="Avatar">
            <div class="tile-card-text">
                <span>'.$value[1].'</span>
            </div>
        </div>
        </a>
    </div>';
}
     $output .= '</div></div>' ;
    }
     echo $output;


?>