<?php $rs = $paging->paginate();?>
<div class="main-content">

    <div class="page-wrapper">

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Quick Consultation list</div>
            </div>
             
                <input type="hidden" name="views" value="" id="views" class="form-control" />
                <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
                <input type="hidden" name="key" value="<?php echo $key;?>" id="key" class="form-control" />
                <input type="hidden" name="patkey" value="<?php echo $patkey; ?>" id="patkey" class="form-control" />
				 <input type="hidden" name="action_search" value="<?php echo $action_search;?>" id="action_search" class="form-control" />
            <div class="pagination-tab">
                <div class="table-title">
                    <div class="col-sm-3">
                        <div id="pager">
                            <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                            <?php echo $paging->renderPrev('<span class=""></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                            <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                            <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                            <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                            <?php $paging->limitList($limit,"myform");?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                        
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Search..."/>
                            <span class="input-group-btn">
 
                                <button type="button" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('view').value='';document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div>
                     <button type="submit" onclick="document.getElementById('view').value='upload';document.myform.submit();" class="btn btn-primary btn-square"><i class="fa fa-upload"></i> Upload My Patients</button>
                    </div>
                    <div class="pagination-right">
                        <!-- Content goes here -->
                    </div>
                </div>
            </div>
           <?php $engine->msgBox($msg,$status); ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient No.</th>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Action</th>
                        <th>Unread</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 1;
                    //print_r($datarray['PAT0006']);
                   	//die();
                    if($paging->total_rows > 0 ){
                           $page = (empty($page))? 1:$page;
                           $num = (isset($page))? ($limit*($page-1))+1:1;
                           while(!$rs->EOF){
                           $obj = $rs->FetchNextObject();
						   $linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=historylist&view=historylist&keys='.$obj->REQU_PATIENTNUM;
                    $unread =$engine->getUnreadChat($usrcode,$obj->CHP_PATIENTCODE);
                   	$datarray =$engine->getDoctorChatPaddies($obj->CHP_PATIENTCODE,$fdsearch);
                   //	print_r($datarray['PATIENT_PATIENTNUM']); die();
                    if (!empty($datarray[$obj->CHP_PATIENTCODE]['PATIENT_PATIENTNUM'])){
                   	echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$datarray[$obj->CHP_PATIENTCODE]['PATIENT_PATIENTNUM'].'</td>
                        <td>'.$datarray[$obj->CHP_PATIENTCODE]['PATIENT_FULLNAME'].'</td>
                        <td>'.$datarray[$obj->CHP_PATIENTCODE]['PATIENT_GENDER'].'</td>
                        <td>'.$datarray[$obj->CHP_PATIENTCODE]['PATIENT_AGE'].'</td>
                        <td>
						<div class="btn-group">
						<button type="submit" class="btn btn-info btn-square" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'view\').value=\'chat\';document.getElementById(\'keys\').value=\''.$datarray[$obj->CHP_PATIENTCODE]['PATIENT_PATIENTNUM'].'\';document.getElementById(\'viewpage\').value=\'\';document.myform.submit;">View</button>
                                    </div>
							
						</td>
						<td > <font color="#fff">'.(($unread > 0)?'<span class="badge">'.$unread.'</span>':'').'</font></span></td>
                    </tr>';
                           }
					$num ++; }}
					?>
                </tbody>
            </table>
            
            <!--<li><button type="submit" onclick="document.getElementById(\'view\').value=\'patientdetails\';document.getElementById(\'keys\').value=\''.$obj->REQU_PATIENTNUM.'\';document.getElementById(\'viewpage\').value=\'patientdetails\';document.myform.submit();">Medical History</button></li>-->
            
        </div>

    </div>

</div>



