<?php
  $dashmenu = $menus->getMenuViewAccessRightDash();
  //print_r($dashmenu);
  $usertype = $actordetails->USR_TYPE;
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
                            <input name="dashsearch" type="text" size="40" placeholder="Search menu item here..."
                                id="searchdash" />
                        </div>

                        <!--Sticky Note-->
                        <!--<div id="divStickyNotesContainer">

                    <div class="stickynotebtn" style="position:relative; float:right;  top:-30px;">
               <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success" id="addButton"> <i class="fa fa-plus" aria-hidden="true"></i> Add a note</button>

                    End sticky notes
                </div>	</div> -->
                        <div class="container-fluid dashboard" id="dashidash">
                            <div class="row-fluid">
                                <?php
                                if(is_array($dashmenu)){
                                    foreach($dashmenu as $value){
                                        $linkview = 'index.php?pg='.md5($value[0]).'&amp;option='.md5($value[1]).'&uiid='.md5('1_pop');

                                        echo  '<div class="dashcard ctrlnotification" id="ctrlnotification"><a href="#" onClick="CallWindow(\''.$linkview.'\')" class="list-group-item">'.(($value[3] == 1)?(($usertype == 2)?(($engine->getTotalNotification($value[4],1) > 0)?'<span class="badge" >'.$engine->getTotalNotification($value[4],1).'</span>':''):(($engine->getTotalNotification($value[4],2) > 0)?'<span class="badge">'.$engine->getTotalNotification($value[4],2).'</span>':'')):'').'<div class="tile-card"><img src="media/img/icons/'.$value[2].'" alt="Avatar"><div class="tile-card-text"><span>'.$value[1].'</span></div></div></a></div>';
                                    }} 
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php 
                    /*
                    if($objfac->FACI_TYPE = 'LH' ){

                        ?>
                    <!--
                <div class="col-sm-12">

                    <label class="form-label">Over Due Labs</label>
                    
                </div>
                        

                    <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
						<th>Date</th>
                        <th>Patient</th>
                        <th>Test</th>
                        <th>Discipline</th>
                        <th>Remarks.</th>
                        <th>Status.</th>
                        <th>Medic</th>
						
                    </tr>
                </thead>


                <tbody>
                    <?php
               /*     $num = 1;
					$i =  1;
                    if($stmtlisttestdetails->Recordcount() > 0 ){
					while ($obj = $stmtlisttestdetails->FetchNextObject()){
                    
                   echo '<tr>
						
						    <td>'.$num.'</td>
                            <td>'.$sql->UserDate($obj->LT_DATE,'d/m/Y').'</td>
                            <td>'.$obj->LT_PATIENTNAME.'</td>
                            <td>'.$encaes->decrypt($obj->LT_TESTNAME).'</td>
                            <td>'.$obj->LT_DISCPLINENAME.'</td>
                            <td>'.$encaes->decrypt($obj->LT_RMK).'</td>
                            <td>'.(($obj->LT_STATUS == '3')?'Pending':(($obj->LT_STATUS == '6' )?'Results Attached':'N/A')).'</td>
                            <td>'.$obj->LT_ACTORNAME.'</td>
                        
                      
						
					</tr>';
					$num ++; 
										
					?>			
							
				<?php $i++;	}}
					?>
                </tbody>
            </table>

                    <?php } */?>
                </div>
              


            </div>

    </div>
</div>