<?php
  $dashmenu = $menus->getMenuViewAccessRightDash();
  //print_r($dashmenu);
  $usertype = $actordetails->USR_TYPE;
  $usercode = $actordetails->USR_CODE;
  $objfac = $engine->getFacilityDetails();
    //$rsb = $pagingBroad->paginate();
    $bropt = md5('Dispensary');
    $bkb = md5('Pharmacy');
    $isPharm = false;


?>


<div class="main-content">
    <input type="hidden" name="option" id="option">
    <input type="hidden" name="pg" id="pg">
    <div class="page-wrapper">
        <div class="page" style="min-height:50vh;">
            <div class="row">
                <div class="col-md-12">
                    <div class="moduletitle" style="border-bottom:0px;margin-bottom: 10px">
                        <div class="moduletitleupper">Dashboard</div>
                        <div class="search-wrapper">
                            <input dashsearch name="dashsearch" type="text" size="40" placeholder="Search menu item here..."
                                id="searchdashvirtual" />
                        </div>
<input type="hidden" value="<?php echo $facicode ;?>" name="facicode" id="facicode">
                      
                        <div class="container-fluid dashboard" id="dashidash">
                            <div class="row-fluid">
                                <div class="col-sm-9">
                                <?php
                                if(is_array($dashmenu)){
                                    foreach($dashmenu as $value){
                                        $linkview = 'index.php?pg='.md5($value[0]).'&amp;option='.md5($value[1]).'&uiid='.md5('1_pop');

                                        echo  '<div class="dashcard ctrlnotification" id="ctrlnotification"><a href="#" onClick="CallWindow(\''.$linkview.'\')" class="list-group-item">'.(($value[3] == 1)?(($usertype == 2)?(($engine->getTotalNotification($value[4],1) > 0)?'<span class="badge" >'.$engine->getTotalNotification($value[4],1).'</span>':''):(($engine->getTotalNotification($value[4],2) > 0)?'<span class="badge">'.$engine->getTotalNotification($value[4],2).'</span>':'')):'').'<div class="tile-card" style="height: 24vh;"><img src="media/img/icons/'.$value[2].'" alt="Avatar"><div class="tile-card-text"><span>'.$value[1].'</span></div></div></a></div>';
                                    }} 
                                ?>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <h5>Assign Virtual Hospital:</h5>
                                        <?php
                                           $stmtchp = $engine->getDoctorVirtualHospitals($usercode);
                                           if($stmtchp->RecordCount() > 0){
                                           while($objchp = $stmtchp->FetchNextObject()){
                                            $facicode = (!empty($facicode)?$facicode:$faccode) ;

                                            $stmtavail = $doctors->checkRoomAvailability($objchp->CDA_HOSPITAL_FACCODE,$usercode);
                                            if($stmtavail->RecordCount() > 0){
                                        ?>
                                        <div <?php echo (($facicode == $objchp->CDA_HOSPITAL_FACCODE)?'style="background-color:#ffdd44;border:1px solid #f3d443;"':'' ) ?> class="card-body wrapper" onclick="document.getElementById('facicode').value='<?php echo $objchp->CDA_HOSPITAL_FACCODE ;?>';document.getElementById('viewpage').value='changeVH';document.myform.submit();">
                                            <?php echo $objchp->CDA_HOSPITAL_NAME ; 
                                             $totalpatient = $engine->getTotalPendingPatientVH($objchp->CDA_HOSPITAL_FACCODE) ;
                                             echo (($totalpatient > 0)?'<div class="badge" id="rightbadge">'.$totalpatient.'</div>':'') ;
                                            ?>
                                          
                                        </div>
                                        <?php }} } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                </div>
              


            </div>

    </div>
</div>