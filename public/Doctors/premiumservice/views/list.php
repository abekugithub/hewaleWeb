<?php $rs = $paging->paginate();?>
<input type="hidden" name="rowid" id="rowid" value="">
<div class="main-content">

    <div class="page-wrapper">

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Premium Patients</div>
            </div>
            
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
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('s').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
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
                    <th>Patient Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $num = 1;
                if($paging->total_rows > 0 ){
                    $page = (empty($page))? 1:$page;
                    $num = (isset($page))? ($limit*($page-1))+1:1;
                    while(!$rs->EOF){
					
                        $obj = $rs->FetchNextObject();
                        $objd = $patientCls->getPatientDetails($obj->PREMSERV_PATIENTNUM);
                        echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$obj->PREMSERV_PATIENTNUM.'</td>
                        <td>'.$objd->PATIENT_FNAME.' '.$objd->PATIENT_MNAME.' '.$objd->PATIENT_LNAME.'</td>
                        <td>'.$objd->PATIENT_GENDER.'</td>
                        <td>'.$objd->PATIENT_EMAIL.'</td>
						<td>'.$objd->PATIENT_PHONENUM.'</td>
                        <td>'.(($obj->PREMSERV_STATUS == 0)?'Pending':'Active').'</td>
						<td> 
						
						<div class="btn-group">
                                <button type="button" class="btn '.((($obj->PREMSERV_STATUS == 0)?'btn-danger':'btn-info')).'  btn-square" >Options</button>
                                <button type="button" class="btn '.((($obj->PREMSERV_STATUS == 0)?'btn-danger':'btn-info')).' btn-square dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" style="padding-right:20px">
                                    <li><button type="submit" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'view\').value=\'patientdetails\';document.getElementById(\'keys\').value=\''.$obj->PREMSERV_PATIENTNUM.'\';document.getElementById(\'viewpage\').value=\'viewpatient\';document.myform.submit;">Patient Details</button></li>
									
'.((($obj->PREMSERV_STATUS == 0)?'':'<li><button type="submit" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'view\').value=\'excuseduty\';document.getElementById(\'keys\').value=\''.$obj->PREMSERV_PATIENTNUM.'\';document.getElementById(\'rowid\').value=\''.$obj->PREMSERV_ID.'\';document.getElementById(\'viewpage\').value=\'viewpatient\';document.myform.submit;">Consulting Room</button></li>')).'

'.((($obj->PREMSERV_STATUS == 0)?'<li><button type="submit" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'rowid\').value=\''.$obj->PREMSERV_ID.'\';document.getElementById(\'keys\').value=\''.$obj->PREMSERV_PATIENTNUM.'\';document.getElementById(\'viewpage\').value=\'acceptpatient\';document.myform.submit;">Accept</button></li> <li><button type="submit" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'rowid\').value=\''.$obj->PREMSERV_ID.'\';document.getElementById(\'keys\').value=\''.$obj->PREMSERV_PATIENTNUM.'\';document.getElementById(\'viewpage\').value=\'rejectpatient\';document.myform.submit;">Reject</button></li>':'')).'


                                </ul>
					
								
                            </div>
							
						</td>
                    </tr>';
                        $num ++; }}
                ?>
                </tbody>
            </table>
        </div>

    </div>

</div>