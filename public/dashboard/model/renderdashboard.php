<?php
ob_start();
include '../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."menufactory.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";

$engine = new engineClass();
$menus = new MenuClass();
$doctors = new doctorClass();
$actor = $engine->getActorDetails();
$objdtls = $engine->getFacilityDetails();
$facitype = $objdtls->FACI_TYPE ;
$usercode = $actor->USR_CODE;
$usertype = $actor->USR_TYPE;
$facicode = $actor->USR_FACICODE;

if($dashsearch != ''){
    $dashmenu = $menus->getMenuViewAccessRightDashSearch($dashsearch);
    }else{
        $dashmenu = $menus->getMenuViewAccessRightDash();
    }
    $output = '';

if($facitype == 'CC'){

    if(is_array($dashmenu)){
        $output = '<div class="row-fluid"><div class="col-sm-9">';
        
            if(is_array($dashmenu)){
                foreach($dashmenu as $value){
        
                    $linkview = 'index.php?pg='.md5($value[0]).'&amp;option='.md5($value[1]).'&uiid='.md5('1_pop');
        
                    $output .= '<div class="dashcard ctrlnotification" id="ctrlnotification">
                                <a href="#" onClick="CallWindow(\''.$linkview.'\')" class="list-group-item">
                                '.(($value[3] == 1)?(($usertype == 2)?(($engine->getTotalNotificationRefresh($value[4],1,$usercode) > 0)?'<span class="badge" >'.$engine->getTotalNotificationRefresh($value[4],1,$usercode).'</span>':''):(($engine->getTotalNotificationRefresh($value[4],2,$facicode) > 0)?'<span class="badge">'.$engine->getTotalNotificationRefresh($value[4],2,$facicode).'</span>':'')):'').'
                                
                                <div class="tile-card" style="height: 24vh;">
                                    <img src="media/img/icons/'.$value[2].'" alt="Avatar">
                                    <div class="tile-card-text">
                                        <span>'.$value[1].'</span>
                                    </div>
                                </div>
                                </a>
                            </div>';
                }
            }
            $output .= '</div></div>';
            $output .=' <div class="col-sm-3">
                            <div class="card">
                            <h5>Assign Virtual Hospital:</h5>';

                            $stmtchp = $engine->getDoctorVirtualHospitals($usercode);
                            if($stmtchp->RecordCount() > 0){
                            while($objchp = $stmtchp->FetchNextObject()){
                                $totalpatient = $engine->getTotalPendingPatientVH($objchp->CDA_HOSPITAL_FACCODE) ;
                                $stmtavail = $doctors->checkRoomAvailability($objchp->CDA_HOSPITAL_FACCODE,$usercode);
                                if($stmtavail->RecordCount() > 0){

                          $output .='<div '.(($facicode == $objchp->CDA_HOSPITAL_FACCODE)?'style="background-color:#ffdd44;border:1px solid #f3d443;"':'' ).' class="card-body wrapper" onclick="document.getElementById(\'facicode\').value=\''.$objchp->CDA_HOSPITAL_FACCODE.'\';document.getElementById(\'viewpage\').value=\'changeVH\';document.myform.submit();">
                                 '.$objchp->CDA_HOSPITAL_NAME.
                               (($totalpatient > 0)?'<div class="badge" id="rightbadge">'.$totalpatient.'</div>':'').'
                            </div>';
                        }}}
                      $output .= '</div>
                        </div>';
        }

}else{
if(is_array($dashmenu)){
$output = '<div class="row-fluid">';

    if(is_array($dashmenu)){
        foreach($dashmenu as $value){

            $linkview = 'index.php?pg='.md5($value[0]).'&amp;option='.md5($value[1]).'&uiid='.md5('1_pop');

            $output .= '<div class="dashcard ctrlnotification" id="ctrlnotification">
                        <a href="#" onClick="CallWindow(\''.$linkview.'\')" class="list-group-item">
						
                        '.(($value[3] == 1)?(($usertype == 2)?(($engine->getTotalNotificationRefresh($value[4],1,$usercode) > 0)?'<span class="badge" >'.$engine->getTotalNotificationRefresh($value[4],1,$usercode).'</span>':''):(($engine->getTotalNotificationRefresh($value[4],2,$facicode) > 0)?'<span class="badge">'.$engine->getTotalNotificationRefresh($value[4],2,$facicode).'</span>':'')):'').'
                        <div class="tile-card">
                            <img src="media/img/icons/'.$value[2].'" alt="Avatar">
                            <div class="tile-card-text">
                                <span>'.$value[1].'</span>
                            </div>
                        </div>
                        </a>
                    </div>';
        }
    }
    $output .= '</div>';
}

}
 echo json_encode($output);


?>